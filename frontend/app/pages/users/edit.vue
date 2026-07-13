<template>
  <div
    class="flex h-full min-h-0 flex-col overflow-hidden bg-[#e5e5e5] font-['Overpass'] text-[13px] text-[#1F2835]"
  >
    <div
      class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200"
    >
      <div class="flex items-center text-[10px] text-gray-500 gap-1">
        <svg
          class="w-3 h-3 text-gray-400"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
          />
        </svg>
        <span
          @click="router.push('/users')"
          class="cursor-pointer transition-colors hover:text-[#F52C11]"
          >User Management</span
        >
        <svg
          class="w-2.5 h-2.5 text-gray-400"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 5l7 7-7 7"
          />
        </svg>
        <span class="text-[#F52C11] font-medium">Edit User</span>
      </div>
    </div>

    <main class="min-h-0 flex-1 overflow-auto p-3 sm:p-4 lg:p-6">
      <div class="mx-auto w-full max-w-[920px] space-y-3">
        <div
          class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
        >
          <div class="flex items-center gap-1.5 px-3 py-1.5">
            <div
              class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
            >
              <svg
                class="w-2.5 h-2.5 text-[#F52C11]"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                />
              </svg>
            </div>
            <div>
              <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">
                Account information
              </h2>
              <p class="text-[9px] text-gray-400 leading-tight">
                Basic profile details
              </p>
            </div>
          </div>

          <div class="px-3 pb-2.5">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  First name <span class="text-[#F52C11]">*</span>
                </label>
                <input
                  v-model="form.firstName"
                  type="text"
                  placeholder="First name"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] focus:outline-none transition-colors placeholder:text-gray-400',
                    errors.firstName
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                />
                <p
                  v-if="errors.firstName"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  First name is required
                </p>
              </div>

              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Last name <span class="text-[#F52C11]">*</span>
                </label>
                <input
                  v-model="form.lastName"
                  type="text"
                  placeholder="Last name"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] focus:outline-none transition-colors placeholder:text-gray-400',
                    errors.lastName
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                />
                <p
                  v-if="errors.lastName"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Last name is required
                </p>
              </div>

              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Email address <span class="text-[#F52C11]">*</span>
                </label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="example@company.com"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] focus:outline-none transition-colors placeholder:text-gray-400',
                    errors.email
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                />
                <p v-if="errors.email" class="text-[8px] text-[#F52C11] mt-0.5">
                  Email is required
                </p>
                <p v-else class="text-[8px] text-gray-400 mt-0.5">
                  Changing the email will update the user's login credentials.
                </p>
              </div>

              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Date added
                </label>
                <div class="relative">
                  <input
                    v-model="form.dateAdded"
                    type="text"
                    readonly
                    class="w-full bg-gray-100 border border-gray-200 rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] focus:outline-none cursor-not-allowed pr-8 placeholder:text-gray-400"
                  />
                  <svg
                    class="w-3.5 h-3.5 text-gray-400 absolute right-2.5 top-[7px] pointer-events-none"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
        >
          <div class="flex items-center gap-1.5 px-3 py-1.5">
            <div
              class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
            >
              <svg
                class="w-2.5 h-2.5 text-[#F52C11]"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                />
              </svg>
            </div>
            <div>
              <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">
                Password settings
              </h2>
              <p class="text-[9px] text-gray-400 leading-tight">
                Password security details
              </p>
            </div>
          </div>

          <div class="px-3 pb-2.5">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  New Password
                </label>
                <input
                  v-model="form.newPassword"
                  type="password"
                  placeholder="Leave blank to keep current password"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.newPassword
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                />
                <p
                  v-if="errors.newPassword"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Password is required
                </p>
                <p
                  v-else-if="passwordReminder"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Please create a password first
                </p>
              </div>

              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Confirm New Password <span class="text-[#F52C11]">*</span>
                </label>
                <input
                  v-model="form.confirmPassword"
                  type="password"
                  placeholder="Re-enter new password"
                  :disabled="!form.newPassword"
                  :class="[
                    'w-full border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    !form.newPassword
                      ? 'bg-gray-100 cursor-not-allowed border-gray-200'
                      : 'bg-white border-gray-200 focus:border-[#F52C11]',
                    errors.confirmPassword ? 'border-[#F52C11]' : '',
                  ]"
                  @focus="checkPasswordFirst"
                />
                <p
                  v-if="errors.confirmPassword"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Passwords do not match
                </p>
              </div>
            </div>
          </div>
        </div>

        <div
          class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden flex flex-col"
        >
          <div class="flex items-center gap-1.5 px-3 py-1.5">
            <div
              class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
            >
              <svg
                class="w-2.5 h-2.5 text-[#F52C11]"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                />
              </svg>
            </div>
            <div>
              <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">
                Role & permissions
              </h2>
              <p class="text-[9px] text-gray-400 leading-tight">
                Controls what this user can access and do
              </p>
            </div>
          </div>

          <div class="px-3 pb-2">
            <div
              class="grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(320px,1.2fr)]"
            >
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Assign role <span class="text-[#F52C11]">*</span>
                </label>
                <div class="relative">
                  <select
                    v-model="form.roleId"
                    :class="[
                      'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] focus:outline-none transition-colors appearance-none cursor-pointer',
                      errors.roleId
                        ? 'border-[#F52C11]'
                        : 'border-gray-200 focus:border-[#F52C11]',
                      form.roleId ? 'text-[#1F2835]' : 'text-gray-400',
                    ]"
                  >
                    <option value="" disabled>Select role</option>
                    <option
                      v-for="role in roles"
                      :key="role.id"
                      :value="role.id"
                    >
                      {{ role.role_name || role.name }}
                    </option>
                  </select>
                  <svg
                    class="w-2.5 h-2.5 text-[#F52C11] absolute right-2.5 top-[7px] pointer-events-none"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19 9l-7 7-7-7"
                    />
                  </svg>
                </div>
                <p
                  v-if="errors.roleId"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Role is required
                </p>
              </div>

              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Permissions
                </label>

                <label
                  class="flex items-start gap-2.5 p-2.5 mb-2 border border-gray-200 rounded-[6px] bg-white cursor-pointer hover:bg-gray-50 transition-colors"
                >
                  <input
                    type="checkbox"
                    v-model="isFullAccess"
                    class="mt-0.5 w-4 h-4 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer shrink-0"
                  />
                  <div>
                    <h3
                      class="text-[12px] font-bold text-[#1F2835] leading-tight mb-0.5"
                    >
                      Full Access
                    </h3>
                    <p class="text-[10px] text-gray-500 leading-tight">
                      Grants all available permissions across the system.
                    </p>
                  </div>
                </label>

                <div
                  class="border border-gray-200 rounded-[4px] overflow-hidden transition-opacity"
                  :class="{
                    'opacity-50 pointer-events-none select-none': isFullAccess,
                  }"
                >
                  <table class="w-full border-collapse">
                    <thead>
                      <tr class="border-b border-gray-200 bg-gray-50/50">
                        <th
                          class="text-left px-3 py-1.5 text-[10px] font-semibold text-[#F52C11]"
                        >
                          Module
                        </th>
                        <th
                          class="text-center px-2 py-1.5 text-[10px] font-semibold text-[#F52C11] w-10"
                        >
                          View
                        </th>
                        <th
                          class="text-center px-2 py-1.5 text-[10px] font-semibold text-[#F52C11] w-10"
                        >
                          Edit
                        </th>
                        <th
                          class="text-center px-2 py-1.5 text-[10px] font-semibold text-[#F52C11] w-10"
                        >
                          Add
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="module in permissions"
                        :key="module.name"
                        class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/30"
                      >
                        <td class="px-3 py-2 text-[11px] text-[#1F2835]">
                          <span class="inline-flex items-center gap-1.5">
                            {{ module.name }}
                            <span
                              v-if="isRowOverridden(module)"
                              class="px-1 py-[1px] rounded-[3px] bg-[#F52C11]/10 text-[8px] font-semibold text-[#F52C11] leading-none"
                              title="Differs from this user's role default"
                            >
                              Custom
                            </span>
                          </span>
                        </td>
                        <td class="px-2 py-2 text-center">
                          <input
                            type="checkbox"
                            v-model="module.view"
                            class="w-3.5 h-3.5 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                          />
                        </td>
                        <td class="px-2 py-2 text-center">
                          <input
                            type="checkbox"
                            v-model="module.edit"
                            class="w-3.5 h-3.5 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                          />
                        </td>
                        <td class="px-2 py-2 text-center">
                          <input
                            type="checkbox"
                            v-model="module.add"
                            class="w-3.5 h-3.5 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                          />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div
            class="px-3 py-2 border-t border-gray-100 flex items-center justify-end gap-2 bg-gray-50/50"
          >
            <p
              v-if="submitMessage"
              class="mr-auto text-[10px]"
              :class="submitError ? 'text-[#F52C11]' : 'text-green-600'"
            >
              {{ submitMessage }}
            </p>
            <button
              @click="discardChanges"
              :disabled="saving"
              class="px-3 py-1 rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
            >
              Discard
            </button>
            <button
              @click="saveChanges"
              :disabled="!isFormValid || loading || saving"
              :class="[
                'px-3 py-1 rounded-[4px] text-[11px] font-medium flex items-center gap-1.5 transition-colors shadow-sm',
                isFormValid && !loading && !saving
                  ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white'
                  : 'bg-gray-300 text-gray-500 cursor-not-allowed',
              ]"
            >
              <svg
                class="w-3 h-3"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M5 13l4 4L19 7"
                />
              </svg>
              {{ saving ? "Saving..." : "Save changes" }}
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useAuditLog } from "~/composables/useAuditLog";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

const route = useRoute();
const router = useRouter();
const { fetchUser, updateUser } = useUserApi();
const { apiFetch } = useApi();

const form = ref({
  firstName: "",
  lastName: "",
  email: "",
  dateAdded: "",
  newPassword: "",
  confirmPassword: "",
  roleId: "",
});

const errors = ref({
  firstName: false,
  lastName: false,
  email: false,
  newPassword: false,
  confirmPassword: false,
  roleId: false,
});

const loading = ref(false);
const saving = ref(false);
const submitMessage = ref("");
const submitError = ref(false);
const originalForm = ref(null);
const originalPermissions = ref(null);
const roles = ref([]);
const rolePagePermissions = ref([]);
const userPagePermissions = ref([]);
const permissions = ref([]);
const passwordReminder = ref(false);

let isInitialLoad = true;

const isFullAccess = computed({
  get() {
    if (!permissions.value || permissions.value.length === 0) return false;
    return permissions.value.every((m) => m.view && m.edit && m.add);
  },
  set(val) {
    permissions.value.forEach((m) => {
      m.view = val;
      m.edit = val;
      m.add = val;
    });
  },
});

watch(
  () => form.value.roleId,
  () => {
    if (isInitialLoad) return;
    applyEffectivePermissions();
  }
);

const isFormValid = computed(() => {
  return (
    form.value.firstName.trim() &&
    form.value.lastName.trim() &&
    form.value.email.trim() &&
    form.value.roleId
  );
});

onMounted(loadEditData);

async function loadEditData() {
  const userId = route.query.id;
  if (!userId) {
    router.push("/users");
    return;
  }

  loading.value = true;
  submitMessage.value = "";

  try {
    const [rolesResponse, pagesResponse, permissionsResponse, userResponse] =
      await Promise.all([
        apiFetch("/roles"),
        apiFetch("/pages"),
        apiFetch("/role_page_permissions"),
        fetchUser(userId),
      ]);

    roles.value = unwrapData(rolesResponse);
    rolePagePermissions.value = unwrapData(permissionsResponse);
    buildPermissionRows(unwrapData(pagesResponse));

    // Fetched separately: if this endpoint isn't set up yet (route/migration
    // missing) or errors out, we still want the rest of the page to load —
    // the user just won't see any override indicators until it's fixed.
    try {
      const userPermissionsResponse = await apiFetch(
        `/user_page_permissions?user_id=${userId}`
      );
      userPagePermissions.value = unwrapData(userPermissionsResponse);
    } catch (overrideError) {
      console.error("Unable to load user permission overrides:", overrideError);
      userPagePermissions.value = [];
    }

    fillForm(userResponse.data);

    setTimeout(() => {
      isInitialLoad = false;
    }, 50);
  } catch (error) {
    console.error("Error loading user:", error);
    submitError.value = true;
    submitMessage.value = "Unable to load this user. Please try again.";
  } finally {
    loading.value = false;
  }
}

function unwrapData(response) {
  return Array.isArray(response) ? response : response?.data || [];
}

function formatPageName(slug) {
  if (!slug) return "";
  return String(slug)
    .replace(/[_-]+/g, " ")
    .split(" ")
    .filter(Boolean)
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");
}

function buildPermissionRows(pages) {
  permissions.value = pages.map((page) => ({
    page_id: page.id,
    page_name: page.page_name,
    name: formatPageName(page.page_name),
    view: false,
    edit: false,
    add: false,
    // the selected role's default for this page, used to detect overrides
    roleDefault: { view: false, edit: false, add: false },
  }));
}

// Applies the selected role's defaults, then overlays this user's
// individual overrides (if any) on top, per page.
function applyEffectivePermissions() {
  const selectedId = form.value.roleId;
  const userId = route.query.id;
  if (!selectedId) return;

  permissions.value.forEach((permissionRow) => {
    const rolePermission = rolePagePermissions.value.find(
      (permission) =>
        Number(permission.role_id) === Number(selectedId) &&
        Number(permission.page_id) === Number(permissionRow.page_id)
    );

    const roleDefault = {
      view: Boolean(rolePermission?.can_view),
      edit: Boolean(rolePermission?.can_edit),
      add: Boolean(rolePermission?.can_create),
    };
    permissionRow.roleDefault = roleDefault;

    const userOverride = userPagePermissions.value.find(
      (permission) =>
        Number(permission.user_id) === Number(userId) &&
        Number(permission.page_id) === Number(permissionRow.page_id)
    );

    permissionRow.view = userOverride?.can_view ?? roleDefault.view;
    permissionRow.edit = userOverride?.can_edit ?? roleDefault.edit;
    permissionRow.add = userOverride?.can_create ?? roleDefault.add;
  });
}

// True when this row's current checkboxes differ from the role's default,
// i.e. this page has a per-user override in effect.
function isRowOverridden(row) {
  if (!row.roleDefault) return false;
  return (
    row.view !== row.roleDefault.view ||
    row.edit !== row.roleDefault.edit ||
    row.add !== row.roleDefault.add
  );
}

function fillForm(user) {
  const fullName = user?.full_name || user?.name || "";
  const [firstName = "", ...lastNameParts] = fullName.trim().split(/\s+/);

  form.value = {
    firstName,
    lastName: lastNameParts.join(" "),
    email: user?.email || "",
    dateAdded: formatDate(user?.created_at),
    newPassword: "",
    confirmPassword: "",
    roleId: user?.role_id || user?.role?.id || "",
  };

  applyEffectivePermissions();

  originalForm.value = { ...form.value };
  originalPermissions.value = JSON.parse(JSON.stringify(permissions.value));
  resetErrors();
}

function formatDate(dateString) {
  if (!dateString) return "";
  const date = new Date(dateString);
  if (Number.isNaN(date.getTime())) return "";
  return date.toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
}

// Redirects user straight back to User Management page
function discardChanges() {
  router.push("/users");
}

function checkPasswordFirst() {
  if (!form.value.newPassword) {
    passwordReminder.value = true;
    setTimeout(() => {
      passwordReminder.value = false;
    }, 3000);
  }
}

function validateForm() {
  errors.value.firstName = !form.value.firstName.trim();
  errors.value.lastName = !form.value.lastName.trim();
  errors.value.email = !form.value.email.trim();
  errors.value.roleId = !form.value.roleId;

  if (form.value.newPassword || form.value.confirmPassword) {
    errors.value.newPassword = !form.value.newPassword.trim();
    errors.value.confirmPassword =
      !form.value.confirmPassword.trim() ||
      form.value.newPassword !== form.value.confirmPassword;
  } else {
    errors.value.newPassword = false;
    errors.value.confirmPassword = false;
  }

  return !Object.values(errors.value).some((error) => error);
}

function resetErrors() {
  errors.value = {
    firstName: false,
    lastName: false,
    email: false,
    newPassword: false,
    confirmPassword: false,
    roleId: false,
  };
}

// Writes this user's permission overrides (NOT the role's permissions).
// Only pages where the checkboxes differ from the role's default become
// an override row; pages that match the role default have any existing
// override removed, so the user cleanly falls back to inheriting the role.
async function syncUserPermissions() {
  const userId = route.query.id;
  if (!userId) return;

  for (const permissionRow of permissions.value) {
    const existingOverride = userPagePermissions.value.find(
      (permission) =>
        Number(permission.user_id) === Number(userId) &&
        Number(permission.page_id) === Number(permissionRow.page_id)
    );

    if (!isRowOverridden(permissionRow)) {
      // Matches the role default: no override needed.
      if (existingOverride) {
        await apiFetch(`/user_page_permissions/${existingOverride.id}`, {
          method: "DELETE",
        });
        userPagePermissions.value = userPagePermissions.value.filter(
          (permission) => permission.id !== existingOverride.id
        );
      }
      continue;
    }

    const payload = {
      user_id: Number(userId),
      page_id: permissionRow.page_id,
      permission_name: permissionRow.page_name,
      can_view: Boolean(permissionRow.view),
      can_create: Boolean(permissionRow.add),
      can_edit: Boolean(permissionRow.edit),
    };

    if (existingOverride) {
      await apiFetch(`/user_page_permissions/${existingOverride.id}`, {
        method: "PUT",
        body: payload,
      });
    } else {
      const response = await apiFetch("/user_page_permissions", {
        method: "POST",
        body: payload,
      });
      const createdOverride = response?.data || response;
      userPagePermissions.value.push(createdOverride);
    }
  }
}

const { logAuditAction } = useAuditLog();

async function saveChanges() {
  if (!validateForm()) return;

  saving.value = true;
  submitMessage.value = "";
  submitError.value = false;

  try {
    const fullName =
      `${form.value.firstName.trim()} ${form.value.lastName.trim()}`.trim();

    const body = {
      full_name: fullName,
      email: form.value.email.trim(),
      role_id: Number(form.value.roleId),
    };

    const passwordChanged = Boolean(form.value.newPassword.trim());
    if (passwordChanged) {
      body.password = form.value.newPassword;
    }

    await updateUser(route.query.id, body);
    await syncUserPermissions();

    submitMessage.value = "User updated successfully.";

    logAuditAction({
      module: "User Management",
      description: passwordChanged
        ? `Updated user account and reset password for ${fullName}`
        : `Updated user account for ${fullName}`,
    });

    originalForm.value = { ...form.value };
    originalPermissions.value = JSON.parse(JSON.stringify(permissions.value));
    resetErrors();

    await router.push("/users");
  } catch (error) {
    console.error("Error updating user:", error);
    submitError.value = true;
    submitMessage.value =
      error?.data?.message || "Unable to save changes. Please try again.";
  } finally {
    saving.value = false;
  }
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

input[type="checkbox"] {
  accent-color: #f52c11;
}
</style>
