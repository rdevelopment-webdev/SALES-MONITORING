<template>
  <template v-if="canAdd">
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
          <i class="pi pi-users text-gray-600 text-xl"></i>
          <span class="cursor-pointer transition-colors hover:text-[#F52C11]"
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
          <span class="text-[#F52C11] font-medium">Add User</span>
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
                    Full name <span class="text-[#F52C11]">*</span>
                  </label>
                  <input
                    v-model="form.fullName"
                    type="text"
                    placeholder="Full name"
                    :class="[
                      'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                      errors.fullName
                        ? 'border-[#F52C11]'
                        : 'border-gray-200 focus:border-[#F52C11]',
                    ]"
                  />
                  <p
                    v-if="errors.fullName"
                    class="text-[8px] text-[#F52C11] mt-0.5"
                  >
                    Full name is required
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
                      'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                      errors.email
                        ? 'border-[#F52C11]'
                        : 'border-gray-200 focus:border-[#F52C11]',
                    ]"
                  />
                  <p
                    v-if="errors.email"
                    class="text-[8px] text-[#F52C11] mt-0.5"
                  >
                    Email is required
                  </p>
                  <p v-else class="text-[8px] text-gray-400 mt-0.5">
                    Changing the email will update the user's login credentials.
                  </p>
                </div>

                <div class="relative"></div>
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
                    Create Password
                  </label>
                  <input
                    v-model="form.password"
                    type="password"
                    placeholder="Create a password"
                    :class="[
                      'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                      errors.password
                        ? 'border-[#F52C11]'
                        : 'border-gray-200 focus:border-[#F52C11]',
                    ]"
                  />
                  <p
                    v-if="errors.password"
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
                    Confirm Password <span class="text-[#F52C11]">*</span>
                  </label>
                  <input
                    v-model="form.confirmPassword"
                    type="password"
                    placeholder="Re-enter new password"
                    :disabled="!form.password"
                    :class="[
                      'w-full border rounded-[4px] px-3 py-2 text-[12px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                      !form.password
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
            <div class="px-3 py-1.5">
              <div
                class="grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(320px,1.2fr)] items-center"
              >
                <div class="flex items-center gap-1.5">
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
                    <h2
                      class="text-[11px] font-bold text-[#1F2835] leading-tight"
                    >
                      Role & permissions
                    </h2>
                    <p class="text-[9px] text-gray-400 leading-tight">
                      Controls what this user can access and do
                    </p>
                  </div>
                </div>
                <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">
                  Permissions
                </h2>
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
                  <div class="relative" ref="roleDropdownRef">
                    <button
                      type="button"
                      :disabled="rolesLoading"
                      @click="isRoleDropdownOpen = !isRoleDropdownOpen"
                      :class="[
                        'w-full bg-white border rounded-[4px] px-3 py-2 text-[12px] text-left focus:outline-none transition-colors cursor-pointer disabled:bg-gray-100 disabled:cursor-not-allowed',
                        errors.role
                          ? 'border-[#F52C11]'
                          : isRoleDropdownOpen
                          ? 'border-[#F52C11]'
                          : 'border-gray-200',
                        form.role ? 'text-[#1F2835]' : 'text-gray-400',
                      ]"
                    >
                      {{
                        form.role ||
                        (rolesLoading
                          ? "Loading roles..."
                          : "- Please select -")
                      }}
                    </button>
                    <svg
                      class="w-2.5 h-2.5 text-[#F52C11] absolute right-2.5 top-[7px] pointer-events-none transition-transform"
                      :class="{ 'rotate-180': isRoleDropdownOpen }"
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

                    <ul
                      v-if="isRoleDropdownOpen"
                      class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-[4px] shadow-lg max-h-48 overflow-auto py-1"
                    >
                      <li
                        v-for="role in roles"
                        :key="role.id"
                        @click="selectRole(role.role_name)"
                        :class="[
                          'px-3 py-1.5 text-[12px] cursor-pointer transition-colors hover:bg-[#FEF4F3]',
                          form.role === role.role_name
                            ? 'bg-[#FEF4F3] text-[#F52C11] font-medium'
                            : 'text-[#1F2835]',
                        ]"
                      >
                        {{ role.role_name }}
                      </li>
                    </ul>
                  </div>
                  <p
                    v-if="errors.role"
                    class="text-[8px] text-[#F52C11] mt-0.5"
                  >
                    Role is required
                  </p>
                </div>

                <div>
                  <label
                    class="flex items-start gap-2.5 p-2.5 mb-2 border border-gray-200 rounded-[6px] bg-white cursor-pointer hover:bg-gray-50 transition-colors"
                  >
                    <input
                      type="checkbox"
                      v-model="globalFullAccess"
                      @change="toggleGlobalFullAccess"
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
                    class="overflow-x-auto rounded-[4px] border border-gray-200"
                  >
                    <table class="min-w-[360px] w-full border-collapse">
                      <thead>
                        <tr class="border-b border-gray-200">
                          <th
                            class="text-left px-2 py-[3px] text-[9px] font-semibold text-[#F52C11]"
                          >
                            Module
                          </th>
                          <th
                            class="text-center px-1.5 py-[3px] text-[9px] font-semibold text-[#F52C11] w-8"
                          >
                            View
                          </th>
                          <th
                            class="text-center px-1.5 py-[3px] text-[9px] font-semibold text-[#F52C11] w-8"
                          >
                            Edit
                          </th>
                          <th
                            class="text-center px-1.5 py-[3px] text-[9px] font-semibold text-[#F52C11] w-8"
                          >
                            Add
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="module in permissions"
                          :key="module.name"
                          class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/30 transition-colors"
                        >
                          <td class="px-2 py-[3px] text-[10px] text-[#1F2835]">
                            <span class="inline-flex items-center gap-1">
                              {{ module.name }}
                              <span
                                v-if="hasAnyPermission(module)"
                                class="px-1 py-[1px] rounded-[3px] bg-[#F52C11]/10 text-[7px] font-semibold text-[#F52C11] leading-none"
                                title="This page will be granted to the new user"
                              >
                                Granted
                              </span>
                            </span>
                          </td>
                          <td class="px-1.5 py-[3px] text-center">
                            <input
                              type="checkbox"
                              v-model="module.view"
                              @change="checkGlobalFullAccess"
                              class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                            />
                          </td>
                          <td class="px-1.5 py-[3px] text-center">
                            <input
                              type="checkbox"
                              v-model="module.edit"
                              @change="checkGlobalFullAccess"
                              class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                            />
                          </td>
                          <td class="px-1.5 py-[3px] text-center">
                            <input
                              type="checkbox"
                              v-model="module.add"
                              @change="checkGlobalFullAccess"
                              class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                            />
                          </td>
                        </tr>
                        <tr v-if="!pagesLoading && permissions.length === 0">
                          <td
                            colspan="4"
                            class="px-2 py-4 text-center text-[10px] text-gray-400"
                          >
                            No pages found in the database.
                          </td>
                        </tr>
                        <tr v-if="pagesLoading">
                          <td
                            colspan="4"
                            class="px-2 py-4 text-center text-[10px] text-gray-400"
                          >
                            Loading pages...
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="flex flex-col-reverse gap-2 border-t border-gray-100 px-3 py-3 sm:flex-row sm:items-center sm:justify-end"
            >
              <button
                @click="cancel"
                class="w-full rounded-[4px] border border-gray-300 bg-white px-4 py-2 text-[11px] font-medium text-[#1F2835] transition-colors hover:bg-gray-50 sm:w-auto"
              >
                Cancel
              </button>
              <button
                @click="createUser"
                :disabled="!isFormValid || saving"
                :class="[
                  'flex w-full items-center justify-center gap-1 rounded-[4px] px-4 py-2 text-[11px] font-medium transition-colors shadow-sm sm:w-auto',
                  isFormValid && !saving
                    ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white'
                    : 'bg-gray-300 text-gray-500 cursor-not-allowed',
                ]"
              >
                {{ saving ? "Creating..." : "Create User" }}
              </button>
            </div>
          </div>
          <p v-if="submitMessage" class="text-[10px] text-[#F52C11]">
            {{ submitMessage }}
          </p>
        </div>
      </main>

      <div
        v-if="showDatePicker"
        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
        @click.self="showDatePicker = false"
      >
        <div class="bg-white rounded-[8px] w-[280px] shadow-xl p-4">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-[13px] font-bold text-[#1F2835]">Select Date</h3>
            <button
              @click="showDatePicker = false"
              class="text-gray-400 hover:text-[#1F2835]"
            >
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <div class="flex items-center justify-between mb-2">
            <button
              @click="prevMonth"
              class="p-1 hover:bg-gray-100 rounded text-gray-500"
            >
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15 19l-7-7 7-7"
                />
              </svg>
            </button>
            <span class="text-[12px] font-semibold text-[#1F2835]">{{
              currentMonthYear
            }}</span>
            <button
              @click="nextMonth"
              class="p-1 hover:bg-gray-100 rounded text-gray-500"
            >
              <svg
                class="w-4 h-4"
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
            </button>
          </div>

          <div class="grid grid-cols-7 gap-0.5 mb-1">
            <div
              v-for="day in ['S', 'M', 'T', 'W', 'T', 'F', 'S']"
              :key="day"
              class="text-center text-[9px] font-semibold text-gray-400 py-1"
            >
              {{ day }}
            </div>
          </div>
          <div class="grid grid-cols-7 gap-0.5">
            <div
              v-for="date in calendarDates"
              :key="date.key"
              @click="selectDate(date)"
              :class="[
                'text-center text-[11px] py-1 rounded cursor-pointer transition-colors',
                date.isCurrentMonth ? 'text-[#1F2835]' : 'text-gray-300',
                date.isSelected
                  ? 'bg-[#F52C11] text-white'
                  : 'hover:bg-gray-100',
                date.isToday && !date.isSelected
                  ? 'border border-[#F52C11] text-[#F52C11]'
                  : '',
              ]"
            >
              {{ date.day }}
            </div>
          </div>

          <div
            class="flex items-center justify-end gap-2 mt-3 pt-2 border-t border-gray-100"
          >
            <button
              @click="showDatePicker = false"
              class="px-3 py-[4px] rounded-[4px] text-[10px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
            >
              Cancel
            </button>
            <button
              @click="confirmDate"
              class="bg-[#F52C11] hover:bg-[#d9250e] text-white px-3 py-[4px] rounded-[4px] text-[10px] font-medium transition-colors"
            >
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <template v-else>
    <div
      class="flex h-full min-h-0 flex-col items-center justify-center overflow-hidden bg-[#e5e5e5] font-['Overpass'] text-[13px] text-gray-400"
    >
      {{
        permissionsLoading
          ? "Checking permissions..."
          : "You don't have permission to add users."
      }}
    </div>
  </template>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { useAuditLog } from "~/composables/useAuditLog";
import { useToast } from "~/composables/useToast";
import { usePermissions } from "~/composables/usePermissions";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

// --- PERMISSIONS ---
const {
  ready: permissionsReady,
  isLoading: permissionsLoading,
  canAdd,
} = usePermissions("user-management");

const form = ref({
  fullName: "",
  email: "",
  password: "",
  confirmPassword: "",
  role: "",
  dateAdded: "",
});

const { apiFetch } = useApi();
const router = useRouter();
const roles = ref([]);
const rolesLoading = ref(false);
const pagesLoading = ref(false);
const saving = ref(false);
const submitMessage = ref("");
const permissions = ref([]);
const globalFullAccess = ref(false);

const errors = ref({
  fullName: false,
  email: false,
  password: false,
  confirmPassword: false,
  role: false,
});

const showDatePicker = ref(false);
const selectedDate = ref(null);
const viewDate = ref(new Date());
const passwordReminder = ref(false);

const currentMonthYear = computed(() => {
  return viewDate.value.toLocaleDateString("en-US", {
    month: "long",
    year: "numeric",
  });
});

const calendarDates = computed(() => {
  const year = viewDate.value.getFullYear();
  const month = viewDate.value.getMonth();
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const startDayOfWeek = firstDay.getDay();
  const dates = [];
  const today = new Date();
  const prevMonthLastDay = new Date(year, month, 0).getDate();

  for (let i = startDayOfWeek - 1; i >= 0; i--) {
    dates.push({
      key: `prev-${i}`,
      day: prevMonthLastDay - i,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false,
    });
  }

  for (let day = 1; day <= lastDay.getDate(); day++) {
    const dateObj = new Date(year, month, day);
    dates.push({
      key: `current-${day}`,
      day,
      isCurrentMonth: true,
      isSelected:
        selectedDate.value &&
        dateObj.toDateString() === selectedDate.value.toDateString(),
      isToday: dateObj.toDateString() === today.toDateString(),
      dateObj,
    });
  }

  const remaining = 42 - dates.length;
  for (let day = 1; day <= remaining; day++) {
    dates.push({
      key: `next-${day}`,
      day,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false,
    });
  }

  return dates;
});

function prevMonth() {
  viewDate.value = new Date(
    viewDate.value.getFullYear(),
    viewDate.value.getMonth() - 1,
    1
  );
}

function nextMonth() {
  viewDate.value = new Date(
    viewDate.value.getFullYear(),
    viewDate.value.getMonth() + 1,
    1
  );
}

function selectDate(date) {
  if (!date.isCurrentMonth) {
    if (date.day > 20) {
      prevMonth();
    } else {
      nextMonth();
    }
    return;
  }

  selectedDate.value = date.dateObj;
}

function confirmDate() {
  if (selectedDate.value) {
    form.value.dateAdded = selectedDate.value.toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric",
    });
  }
  showDatePicker.value = false;
}

function checkPasswordFirst() {
  if (!form.value.password) {
    passwordReminder.value = true;
    setTimeout(() => {
      passwordReminder.value = false;
    }, 3000);
  }
}

const isFormValid = computed(() => {
  return (
    form.value.fullName.trim() &&
    form.value.email.trim() &&
    form.value.password.trim() &&
    form.value.confirmPassword.trim() &&
    form.value.password === form.value.confirmPassword &&
    form.value.role &&
    selectedRoleId.value
  );
});

const selectedRoleId = computed(() => {
  const selectedRole = roles.value.find(
    (role) =>
      role.role_name?.toLowerCase() === form.value.role.trim().toLowerCase()
  );
  return selectedRole?.id || null;
});

function validateForm() {
  errors.value.fullName = !form.value.fullName.trim();
  errors.value.email = !form.value.email.trim();
  errors.value.password = !form.value.password.trim();
  errors.value.confirmPassword =
    !form.value.confirmPassword.trim() ||
    form.value.password !== form.value.confirmPassword;
  errors.value.role = !form.value.role;

  return !Object.values(errors.value).some((error) => error);
}

function cancel() {
  router.push("/users");
}

function resetErrors() {
  errors.value = {
    fullName: false,
    email: false,
    password: false,
    confirmPassword: false,
    role: false,
  };
}

// Utility to format "user-management" to "User Management"
function formatPageName(slug) {
  if (!slug) return "";
  return String(slug)
    .replace(/[_-]+/g, " ")
    .split(" ")
    .filter(Boolean)
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");
}

function unwrapData(response) {
  return Array.isArray(response) ? response : response?.data || [];
}

function buildPermissionRows(pages) {
  permissions.value = pages.map((page) => ({
    page_id: page.id,
    page_name: page.page_name,
    name: formatPageName(page.page_name),
    view: false,
    edit: false,
    add: false,
  }));
}

// True when at least one permission is checked for this page — flags
// which pages will be granted to the new user on save.
function hasAnyPermission(row) {
  return Boolean(row.view || row.edit || row.add);
}

// Selects or deselects all checkboxes based on master checkbox state
function toggleGlobalFullAccess() {
  const state = globalFullAccess.value;
  permissions.value.forEach((module) => {
    module.view = state;
    module.edit = state;
    module.add = state;
  });
}

// Verifies if all checkmarks are clicked, and automatically toggles the master checkbox
function checkGlobalFullAccess() {
  if (permissions.value.length === 0) {
    globalFullAccess.value = false;
    return;
  }
  globalFullAccess.value = permissions.value.every(
    (module) => module.view && module.edit && module.add
  );
}

// Saves permissions for the newly created user. Only pages with at least
// one checkbox checked get a row — this writes directly to
// user_page_permissions, there is no role-level default anymore.
async function saveUserPermissions(userId) {
  if (!userId) return;

  for (const permissionRow of permissions.value) {
    if (!hasAnyPermission(permissionRow)) continue;

    await apiFetch("/user_page_permissions", {
      method: "POST",
      body: {
        user_id: userId,
        page_id: permissionRow.page_id,
        permission_name: permissionRow.page_name,
        can_view: Boolean(permissionRow.view),
        can_create: Boolean(permissionRow.add),
        can_edit: Boolean(permissionRow.edit),
      },
    });
  }
}

const { logAuditAction } = useAuditLog();
const toast = useToast();

async function createUser() {
  if (!validateForm()) {
    toast.error("Please fill in all required fields correctly.");
    return;
  }

  if (!selectedRoleId.value) {
    errors.value.role = true;
    submitMessage.value = "Selected role was not found in the database.";
    toast.error("Selected role was not found in the database.");
    return;
  }

  saving.value = true;
  submitMessage.value = "";

  try {
    const fullName = form.value.fullName.trim();

    const userResponse = await apiFetch("/users", {
      method: "POST",
      body: {
        full_name: fullName,
        email: form.value.email.trim(),
        password: form.value.password,
        role_id: selectedRoleId.value,
      },
    });

    const createdUser = userResponse?.data || userResponse;

    const hasPermissions = permissions.value.some((row) =>
      hasAnyPermission(row)
    );
    try {
      await saveUserPermissions(createdUser?.id);
      if (hasPermissions) {
        toast.success("Permissions saved for the new user.");
      }
    } catch (permissionsError) {
      console.error("Error saving user permissions:", permissionsError);
      toast.warning("User was created, but permissions could not be saved.");
    }

    logAuditAction({
      module: "User Management",
      description: `Created new user account for ${fullName} (${form.value.email.trim()})`,
    });

    toast.success(`${fullName} was created successfully.`);

    await router.push("/users");
  } catch (error) {
    const message = error?.data?.message || error?.message || "";
    const isDuplicate =
      error?.status === 409 || /already exists|duplicate/i.test(message || "");

    submitMessage.value = message || "Unable to create user.";

    if (isDuplicate) {
      errors.value.email = true;
      toast.error("A user with this email already exists.");
    } else {
      toast.error(message || "Unable to create user. Please try again.");
    }
  } finally {
    saving.value = false;
  }
}

// --- ROLE DROPDOWN ---
const isRoleDropdownOpen = ref(false);
const roleDropdownRef = ref(null);

function selectRole(roleName) {
  form.value.role = roleName;
  isRoleDropdownOpen.value = false;
}

function handleClickOutsideRoleDropdown(event) {
  if (roleDropdownRef.value && !roleDropdownRef.value.contains(event.target)) {
    isRoleDropdownOpen.value = false;
  }
}

onMounted(async () => {
  document.addEventListener("click", handleClickOutsideRoleDropdown);

  await permissionsReady;

  if (!canAdd.value) {
    toast.error("You don't have permission to add users.");
    router.push("/users");
    return;
  }

  rolesLoading.value = true;
  pagesLoading.value = true;

  try {
    const [rolesResponse, pagesResponse] = await Promise.all([
      apiFetch("/roles"),
      apiFetch("/pages"),
    ]);

    roles.value = unwrapData(rolesResponse);
    buildPermissionRows(unwrapData(pagesResponse));
  } catch (error) {
    submitMessage.value = "Unable to load initial data from the database.";
    toast.error("Unable to load roles and pages. Please refresh the page.");
  } finally {
    rolesLoading.value = false;
    pagesLoading.value = false;
  }
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutsideRoleDropdown);
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

input[type="checkbox"] {
  accent-color: #f52c11;
}
</style>
