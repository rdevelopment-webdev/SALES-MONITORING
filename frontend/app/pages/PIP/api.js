// ============================================================
// api.js — shared Laravel API layer for the PIP tracker
// ============================================================
// This module needs two things wired in from a Nuxt component context
// (it can't call composables itself): call configureApi({ baseURL, getToken })
// once — see index.vue's <script setup> — before any other api.* call runs.
//   - baseURL: your Laravel API root, e.g. runtimeConfig.public.apiBase
//   - getToken: a function returning the current auth token (with or
//     without a "Bearer " prefix), e.g. from @sidebase/nuxt-auth's useAuth()
//
// Other assumptions (adjust if your setup differs):
//  - PerformancePlanController relations (technique, service,
//    salesRepresentatives, waysOfCommunication) each expose a human-readable
//    label. We don't know the exact column name on each model, so
//    `pickLabel()` below tries a list of common candidates. If your
//    lookup tables use a different column, add it to CANDIDATE_KEYS.
//  - Archive routes use {type} as the resource slug, e.g. "performance_plan"
//    matching the apiResource name. Adjust ARCHIVE_TYPE below if your
//    ArchiveController expects something else (e.g. a model class name).
//  - Lookup endpoints (/prospect_techniques, /sales__representatives,
//    /services, /ways_of_communication) may return either a bare array
//    ([{...}, {...}]) or a Laravel API Resource collection wrapped as
//    { data: [{...}, ...] }. normalizeList() below handles both shapes.
// ============================================================

const PERFORMANCE_PLAN_PATH = "/performance_plans";
const ARCHIVE_TYPE = "performance_plan";

// api.js is a plain module, so it can't call Nuxt composables (useRuntimeConfig,
// useAuth) itself — those only work inside a component/plugin context. Instead,
// index.vue calls configureApi() once, right in <script setup> (safe context),
// passing in the real API base URL and a function that returns the current
// auth token. Everything below just uses whatever was configured.
let _baseURL = "/api";
let _getToken = () =>
  typeof localStorage !== "undefined"
    ? localStorage.getItem("auth_token")
    : null;

export function configureApi({ baseURL, getToken } = {}) {
  if (baseURL) _baseURL = baseURL.replace(/\/$/, "");
  if (getToken) _getToken = getToken;
}

// ---------------- auth (fallback helpers if you're not using configureApi) ----------------
export function getToken() {
  return _getToken();
}

export function setToken(token) {
  if (token) localStorage.setItem("auth_token", token);
  else localStorage.removeItem("auth_token");
}

// ---------------- low-level request helper ----------------
async function request(path, { method = "GET", body, headers = {} } = {}) {
  const token = _getToken();
  const authHeader = token
    ? String(token).toLowerCase().startsWith("bearer ")
      ? token
      : `Bearer ${token}`
    : null;

  const res = await fetch(`${_baseURL}${path}`, {
    method,
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest",
      ...(authHeader ? { Authorization: authHeader } : {}),
      ...headers,
    },
    body: body !== undefined ? JSON.stringify(body) : undefined,
  });

  let data = null;
  const text = await res.text();
  if (text) {
    try {
      data = JSON.parse(text);
    } catch {
      data = text;
    }
  }

  if (!res.ok) {
    const message =
      (data && (data.message || data.error)) ||
      `Request failed (${res.status})`;
    const error = new Error(message);
    error.status = res.status;
    error.data = data;
    throw error;
  }

  return data;
}

const get = (path) => request(path);
const post = (path, body) => request(path, { method: "POST", body });
const put = (path, body) => request(path, { method: "PUT", body });
const del = (path) => request(path, { method: "DELETE" });

// ---------------- lookups ----------------
export async function fetchLookups() {
  const [statuses, techniques, salesReps, services, communications] =
    await Promise.all([
      get("/statuses"),
      get("/prospect_techniques"),
      get("/sales__representatives"),
      get("/services"),
      get("/ways_of_communication"),
    ]);

  return {
    // /statuses is a plain array of strings, e.g. ['Emailed', 'Called', ...],
    // but tolerate a { data: [...] } wrapper here too just in case.
    statuses: Array.isArray(statuses)
      ? statuses
      : Array.isArray(statuses?.data)
      ? statuses.data
      : [],
    techniques: normalizeList(techniques),
    salesReps: normalizeList(salesReps),
    services: normalizeList(services),
    communications: normalizeList(communications),
  };
}

export async function fetchCurrentUser() {
  try {
    return await get("/me");
  } catch (error) {
    console.error("Failed to fetch current user:", error);
    return null;
  }
}

const CANDIDATE_KEYS = [
  "name",
  "title",
  "label",
  "technique_name",
  "service_name",
  "representative_name",
  "communication_name",
  "way_name",
  "full_name",
];

function pickLabel(item) {
  for (const key of CANDIDATE_KEYS) {
    if (item && item[key]) return item[key];
  }
  return item?.id != null ? `#${item.id}` : String(item);
}

// Unwraps either a bare array ([{...}, {...}]) or a wrapped response like
// Laravel's API Resource collections ({ data: [{...}, ...] }) into a plain array.
function unwrapList(list) {
  if (Array.isArray(list)) return list;
  if (Array.isArray(list?.data)) return list.data;
  return [];
}

function normalizeList(list) {
  // Without this unwrap, a { data: [...] }-wrapped response silently produces
  // an empty array — the request succeeds (200) but every dropdown ends up
  // with no options.
  return unwrapList(list).map((item) => ({
    id: item.id,
    name: pickLabel(item),
    raw: item,
  }));
}

function findLabel(lookupArray, id) {
  const match = lookupArray.find((item) => String(item.id) === String(id));
  return match ? match.name : "";
}

// ---------------- lookup create/delete (quick-add "+" rows in create.vue/edit.vue) ----------------
// Same endpoints fetchLookups() reads from. Unlike fetchLookups() (which can
// tolerate an unknown label column via CANDIDATE_KEYS/pickLabel), creating a
// record must send the EXACT field name each controller's store() validates
// on, and each controller wraps its created record under a different key —
// both taken straight from the controller source, not guessed:
//   ProspectTechniqueController::store    -> body: technique_name      -> response.technique
//   SalesRepresentativeController::store  -> body: representative_name -> response.representative
//   ServiceController::store              -> body: service_name        -> response.service
//   WayOfCommunicationController::store   -> body: communication_name  -> response.data
async function createLookupItem(path, fieldName, responseKey, name) {
  const created = await post(path, { [fieldName]: name });
  const item = created?.[responseKey] ?? created?.data ?? created;
  return { id: item?.id, name: pickLabel(item) || name, raw: item };
}

export async function createProspectTechnique(name) {
  return createLookupItem(
    "/prospect_techniques",
    "technique_name",
    "technique",
    name
  );
}

export async function createSalesRepresentative(name) {
  return createLookupItem(
    "/sales__representatives",
    "representative_name",
    "representative",
    name
  );
}

export async function createService(name) {
  return createLookupItem("/services", "service_name", "service", name);
}

export async function createWayOfCommunication(name) {
  return createLookupItem(
    "/ways_of_communication",
    "communication_name",
    "data",
    name
  );
}

export async function deleteProspectTechnique(id) {
  return del(`/prospect_techniques/${id}`);
}

export async function deleteSalesRepresentative(id) {
  return del(`/sales__representatives/${id}`);
}

export async function deleteService(id) {
  return del(`/services/${id}`);
}

export async function deleteWayOfCommunication(id) {
  return del(`/ways_of_communication/${id}`);
}

// ---------------- date helpers ----------------
// Form fields display mm/dd/yyyy; backend wants a parseable date (ISO is safest)
export function toBackendDate(mmddyyyy) {
  if (!mmddyyyy) return null;
  const [mm, dd, yyyy] = mmddyyyy.split("/");
  if (!mm || !dd || !yyyy) return mmddyyyy; // already something else, pass through
  return `${yyyy}-${mm.padStart(2, "0")}-${dd.padStart(2, "0")}`;
}

export function toDisplayDate(isoDate) {
  if (!isoDate) return "";
  const d = new Date(isoDate);
  if (isNaN(d.getTime())) return isoDate;
  return d.toLocaleDateString("en-US", {
    month: "2-digit",
    day: "2-digit",
    year: "numeric",
  });
}

// ---------------- field mapping ----------------
// Frontend form shape -> Laravel PerformancePlanController validated shape
export function toBackendPayload(form, userId) {
  return {
    user_id: userId,
    date_recorded: toBackendDate(form.dateRecorded),
    client_name: form.clientName,
    technique_id: form.prospectTechnique || null,
    email: form.email,
    service_id: form.service || null,
    // create.vue no longer has a Lead Status field (it was intentionally
    // removed), but PerformancePlanController still validates `status` as
    // required|string. Default new records to 'Emailed' so creation
    // doesn't fail validation; edit.vue still lets you change it afterward.
    status: form.leadStatus || "Emailed",
    percentage: form.status ?? null,
    area_input: form.location || null,
    // Backend now supports multiple reps via a pivot table — send the
    // full array instead of just the first pick.
    sales_representative_ids: Array.isArray(form.salesRepresentative)
      ? form.salesRepresentative
      : form.salesRepresentative
      ? [form.salesRepresentative]
      : [],
    onboarding_date: toBackendDate(form.onboardingDate),
    remarks: form.remarks || null,
    contact_name: form.contactPersonName,
    contact_number: form.contactPersonPhone,
    communication_id: form.waysOfCommunication || null,
  };
}

// Laravel plan (with loaded relations) -> Frontend record shape used by the table/view/edit modals
export function toFrontendRecord(plan, lookups) {
  const techniqueName = plan.technique
    ? pickLabel(plan.technique)
    : findLabel(lookups.techniques, plan.technique_id);
  const serviceName = plan.service
    ? pickLabel(plan.service)
    : findLabel(lookups.services, plan.service_id);
  // Laravel serializes relation keys as snake_case by default, so
  // waysOfCommunication() comes back as plan.ways_of_communication, not
  // plan.waysOfCommunication.
  const commName = plan.ways_of_communication
    ? pickLabel(plan.ways_of_communication)
    : findLabel(lookups.communications, plan.communication_id);

  // Same snake_case rule applies to salesRepresentatives() ->
  // plan.sales_representatives (array of rep objects via the pivot).
  const repList = Array.isArray(plan.sales_representatives)
    ? plan.sales_representatives
    : [];
  const repNames = repList.map((r) => pickLabel(r));
  const repIds = repList.map((r) => r.id);

  return {
    id: plan.id,
    dateRecorded: toDisplayDate(plan.date_recorded),
    onboardingDate: toDisplayDate(plan.onboarding_date),
    clientName: plan.client_name,
    location: plan.area_input || "",
    prospectTechnique: techniqueName,
    prospectTechniqueId: plan.technique_id,
    salesRepresentative: repNames,
    salesRepresentativeIds: repIds,
    email: plan.email,
    waysOfCommunication: commName,
    waysOfCommunicationId: plan.communication_id,
    service: serviceName,
    serviceId: plan.service_id,
    remarks: plan.remarks || "",
    contactPersonName: plan.contact_name,
    contactPersonPhone: plan.contact_number,
    status: plan.percentage ?? 0, // 0-100 progress bar
    leadStatus: plan.status || "", // Emailed / Called / Prospect / Client / Rejected
  };
}

// ---------------- performance plans CRUD ----------------
export async function getPerformancePlans() {
  return unwrapList(await get(PERFORMANCE_PLAN_PATH));
}

export async function getPerformancePlan(id) {
  return get(`${PERFORMANCE_PLAN_PATH}/${id}`);
}

export async function createPerformancePlan(payload) {
  const res = await post(PERFORMANCE_PLAN_PATH, payload);
  return res?.plan ?? res;
}

export async function updatePerformancePlan(id, payload) {
  const res = await put(`${PERFORMANCE_PLAN_PATH}/${id}`, payload);
  return res?.plan ?? res;
}

export async function deletePerformancePlan(id) {
  return del(`${PERFORMANCE_PLAN_PATH}/${id}`);
}

// ---------------- archive ----------------
export async function getArchivedPerformancePlans() {
  return unwrapList(await get(`/archived/${ARCHIVE_TYPE}`));
}

export async function archivePerformancePlan(id) {
  return post(`/archive/${ARCHIVE_TYPE}/${id}`);
}

export async function unarchivePerformancePlan(id) {
  return post(`/unarchive/${ARCHIVE_TYPE}/${id}`);
}