// app/pages/sales/api.js
//
// RECONSTRUCTED FILE — this went missing from the project (only index.vue
// and edit.vue survived on disk). Everything in the "HTTP / AUTH LAYER"
// section below is rebuilt with high confidence directly from the contract
// index.vue's own comments already describe: the exact routes, the
// configureApi({ baseURL, getToken }) signature, and the shape of errors
// thrown by request() (error.data.errors for Laravel 422 validation,
// error.message otherwise).
//
// The "FIELD MAPPING" section at the bottom is the part I could NOT verify
// against your actual Laravel response shape — check it against a real
// response from GET /api/pip-records before trusting it in production.
//
// If this file is recoverable from git history, prefer that over this
// reconstruction:
//   git log --all --oneline -- "**/sales/api.js"
//   git checkout <commit-hash> -- app/pages/sales/api.js

let _config = {
  baseURL: "",
  getToken: () => null,
};

/**
 * configureApi({ baseURL, getToken })
 * Called once from index.vue's setup with the Nuxt runtime config's
 * apiBase and a function that reads the auth token from localStorage.
 */
export function configureApi(config) {
  _config = { ..._config, ...config };
}

// ==================== HTTP / AUTH LAYER ====================

/**
 * Low-level fetch wrapper shared by every function below.
 * - Attaches Bearer token from configureApi's getToken(), if present.
 * - On a non-2xx response, throws an Error whose `.data` is the parsed
 *   JSON body (so Laravel 422 responses expose `.data.errors`, consumed
 *   by index.vue's describeApiError()) and whose `.message` is either the
 *   body's `message` field or a generic fallback.
 */
async function request(path, options = {}) {
  const token = _config.getToken?.();
  const headers = {
    Accept: "application/json",
    ...(options.body ? { "Content-Type": "application/json" } : {}),
    ...(token ? { Authorization: `Bearer ${token}` } : {}),
    ...options.headers,
  };

  const res = await fetch(`${_config.baseURL}${path}`, {
    ...options,
    headers,
  });

  let data = null;
  try {
    data = await res.json();
  } catch {
    // No/invalid JSON body (e.g. 204 No Content) — leave data as null.
  }

  if (!res.ok) {
    const error = new Error(
      data?.message || `Request failed with status ${res.status}`
    );
    error.status = res.status;
    error.data = data;
    throw error;
  }

  return data;
}

// ==================== LOOKUPS ====================

/**
 * TODO: confirm this route. No explicit path was given in index.vue's
 * comments — this is inferred only from the shape of the `lookups` ref
 * it initializes: { statuses, techniques, salesReps, services, communications }.
 */
export async function fetchLookups() {
  const data = await request("/api/lookups");
  return {
    statuses: data?.statuses ?? [],
    techniques: data?.techniques ?? [],
    salesReps: data?.salesReps ?? data?.sales_reps ?? [],
    services: data?.services ?? [],
    communications: data?.communications ?? [],
  };
}

// ==================== PERFORMANCE PLANS (pip-records) ====================
// Routes below are copied directly from the "Backend dev: Replace with
// your API call (...)" comments in index.vue.

export async function getPerformancePlans() {
  // GET /api/pip-records
  const data = await request("/api/pip-records");
  return data?.data ?? data ?? [];
}

export async function getArchivedPerformancePlans() {
  // GET /api/pip-records/archived
  const data = await request("/api/pip-records/archived");
  return data?.data ?? data ?? [];
}

export async function updatePerformancePlan(id, payload) {
  // PUT /api/pip-records/:id
  const data = await request(`/api/pip-records/${id}`, {
    method: "PUT",
    body: JSON.stringify(payload),
  });
  return data?.data ?? data;
}

export async function archivePerformancePlan(id) {
  // POST /api/pip-records/:id/archive
  return request(`/api/pip-records/${id}/archive`, { method: "POST" });
}

export async function unarchivePerformancePlan(id) {
  // POST /api/pip-records/:id/unarchive
  return request(`/api/pip-records/${id}/unarchive`, { method: "POST" });
}

// ==================== FIELD MAPPING ====================
// *** Least certain section of this file — verify against a real API response. ***
//
// Maps between your Laravel model's attributes and the frontend record
// shape that index.vue / view.vue / edit.vue expect:
//   { id, clientName, dateRecorded, service, onboardingDate, status,
//     prospectTechnique, salesRep, communication, remarks }
//
// Each field tries a camelCase key first, then a snake_case fallback, so
// it won't hard-crash if your API uses one convention or the other — but
// confirm the real key names against GET /api/pip-records and adjust.

export function toFrontendRecord(plan, lookups = {}) {
  if (!plan) return null;
  return {
    id: plan.id,
    clientName: plan.clientName ?? plan.client_name ?? "",
    dateRecorded: plan.dateRecorded ?? plan.date_recorded ?? "",
    service: plan.service ?? plan.service_name ?? plan.service_id ?? "",
    onboardingDate: plan.onboardingDate ?? plan.onboarding_date ?? "",
    status: Number(plan.status ?? plan.progress ?? 0),
    prospectTechnique:
      plan.prospectTechnique ??
      plan.prospect_technique ??
      plan.prospect_technique_id ??
      "",
    salesRep: plan.salesRep ?? plan.sales_rep ?? plan.sales_rep_id ?? "",
    communication:
      plan.communication ??
      plan.communication_mode ??
      plan.communication_id ??
      "",
    remarks: plan.remarks ?? plan.notes ?? "",
  };
}

export function toBackendPayload(recordData, userId) {
  return {
    client_name: recordData.clientName,
    date_recorded: recordData.dateRecorded,
    service: recordData.service,
    onboarding_date: recordData.onboardingDate,
    status: recordData.status,
    prospect_technique: recordData.prospectTechnique,
    sales_rep: recordData.salesRep,
    communication: recordData.communication,
    remarks: recordData.remarks,
    user_id: userId,
  };
}
