<template>
  <div
    class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#f0f0f0] font-['Overpass'] text-[14px] text-[#1F2835]"
  >
    <!-- Top Header: Breadcrumb -->
    <div
      class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200"
    >
      <div class="flex items-center text-[11px] text-gray-500 gap-1">
        <svg
          class="w-3.5 h-3.5 text-gray-400"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
        >
          <path d="M6 4L3 8v8l3 4" />
          <path d="M18 4l3 4v8l-3 4" />
          <circle cx="12" cy="9" r="2.8" />
          <path d="M8 16c0-2.2 1.8-4 4-4s4 1.8 4 4" />
          <path d="M10.5 13l1.2 1.2 2.3-2.5" />
          <circle cx="12" cy="3" r="1.2" fill="currentColor" stroke="none" />
          <circle cx="12" cy="21" r="1.2" fill="currentColor" stroke="none" />
        </svg>
        <span class="text-[#f52c11]">Audit Logs</span>
      </div>
    </div>

    <!-- Title + Subtitle (compressed) -->
    <div class="px-4 pt-1.5 pb-1 shrink-0">
      <h1 class="font-bold text-[16px] tracking-tight leading-tight">
        Audit Logs
      </h1>
      <p class="text-[11px] text-gray-400 leading-tight">
        Track every change made across the system
      </p>
    </div>

    <!-- Filters Row (compressed) -->
    <div class="px-4 pb-1.5 flex items-center justify-between gap-2 shrink-0">
      <!-- Left: Search -->
      <div class="flex items-center gap-1.5">
        <div class="relative flex items-center">
          <svg
            class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-[4px] pointer-events-none"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            />
          </svg>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search user & description"
            class="pl-7 pr-2 py-[2px] w-64 bg-white border border-gray-300 rounded-[4px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
          />
        </div>
      </div>

      <!-- Right: Users, Modules, Date -->
      <div class="flex items-center gap-1.5">
        <!-- Users Dropdown (filters by role: Admin / Sales) -->
        <div class="relative">
          <button
            @click="
              showUsersDropdown = !showUsersDropdown;
              showModulesDropdown = false;
              showDatePicker = false;
            "
            :class="
              selectedRole !== 'All Users'
                ? 'border-[#F52C11] text-[#F52C11]'
                : 'border-gray-300 text-[#1F2835]'
            "
            class="bg-white border px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-1 hover:border-gray-400 transition-colors"
          >
            {{ selectedRole }}
            <svg
              class="w-2.5 h-2.5 text-gray-500"
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
          </button>
          <div
            v-if="showUsersDropdown"
            class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[140px]"
          >
            <button
              v-for="role in roleOptions"
              :key="role"
              @click="
                selectedRole = role;
                showUsersDropdown = false;
              "
              :class="
                selectedRole === role
                  ? 'bg-[#F52C11]/10 text-[#F52C11] font-medium'
                  : 'text-[#1F2835] hover:bg-gray-50'
              "
              class="w-full text-left px-3 py-1.5 text-[11px] transition-colors"
            >
              {{ role }}
            </button>
          </div>
        </div>

        <!-- Modules Dropdown (5 modules) -->
        <div class="relative">
          <button
            @click="
              showModulesDropdown = !showModulesDropdown;
              showUsersDropdown = false;
              showDatePicker = false;
            "
            :class="
              selectedModule !== 'All Modules'
                ? 'border-[#F52C11] text-[#F52C11]'
                : 'border-gray-300 text-[#1F2835]'
            "
            class="bg-white border px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-1 hover:border-gray-400 transition-colors"
          >
            {{ selectedModule }}
            <svg
              class="w-2.5 h-2.5 text-gray-500"
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
          </button>
          <div
            v-if="showModulesDropdown"
            class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[220px]"
          >
            <button
              v-for="mod in moduleOptions"
              :key="mod"
              @click="
                selectedModule = mod;
                showModulesDropdown = false;
              "
              :class="
                selectedModule === mod
                  ? 'bg-[#F52C11]/10 text-[#F52C11] font-medium'
                  : 'text-[#1F2835] hover:bg-gray-50'
              "
              class="w-full text-left px-3 py-1.5 text-[11px] transition-colors"
            >
              {{ mod }}
            </button>
          </div>
        </div>

        <!-- Date Picker (behavior copied from PIP: selectedDate + calendar, no separate clear button) -->
        <!-- Date Picker -->
        <div class="relative">
          <button
  @click="showDatePicker = !showDatePicker"
  :class="selectedDate ? 'border-[#F52C11] text-[#F52C11]' : 'border-gray-300 text-[#1F2835]'"
  class="bg-white border px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-1.5 hover:border-gray-400 transition-colors"
>
  <span>{{ selectedDate || "Select Date" }}</span>
  <svg
    class="w-3 h-3 text-[#F52C11]"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    viewBox="0 0 24 24"
  >
    <path
      stroke-linecap="round"
      stroke-linejoin="round"
      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
    />
  </svg>
</button>
                    <div
            v-if="showDatePicker"
            class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[12px] shadow-lg z-50 p-3 w-64"
          >
            <div class="flex items-center justify-between mb-2">
              <button
                @click="prevMonth"
                class="text-gray-400 hover:text-[#1F2835]"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <span class="text-[12px] font-semibold">{{
                currentMonthYear
              }}</span>
              <button
                @click="nextMonth"
                class="text-gray-400 hover:text-[#1F2835]"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
            <div
              class="grid grid-cols-7 gap-1 text-center text-[10px] text-gray-400 mb-1"
            >
              <span>Su</span><span>Mo</span><span>Tu</span><span>We</span
              ><span>Th</span><span>Fr</span><span>Sa</span>
            </div>
            <div class="grid grid-cols-7 gap-1">
              <button
  v-for="day in calendarDays"
  :key="day.date || Math.random()"
  @click="day.date && selectDate(day.date)"
  :disabled="!day.date"
  :class="[
    'w-7 h-7 rounded-[4px] text-[11px] flex items-center justify-center transition-colors',
    day.isCurrentMonth ? 'text-[#1F2835]' : 'text-transparent',
    day.isSelected
      ? 'bg-[#F52C11] text-white font-semibold'
      : day.isToday
      ? 'border border-[#F52C11] text-[#F52C11] font-semibold'
      : day.date
      ? 'hover:bg-gray-100'
      : '',
  ]"
>
  {{ day.isCurrentMonth ? day.day : '' }}
</button>
            </div>
             <!-- Clear date -->
            <div class="flex justify-end mt-2 pt-2">
              <button
                @click="clearDateFilter"
                class="text-[10px] text-gray-400 hover:text-[#F52C11] transition-colors"
              >
                Clear date
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content: Table Section -->
    <main class="flex-1 flex flex-col px-2.5 min-h-0 overflow-hidden">
      <section
        class="flex-1 flex flex-col min-h-0 bg-white border border-gray-200 border-b-0 overflow-hidden relative rounded-t-[6px]"
      >
        <!-- Table Header Info -->
        <div
          class="flex items-center justify-between px-2 py-[2px] border-b border-gray-100 shrink-0"
        >
          <div class="flex items-center gap-3">
            <span class="text-[11px] text-gray-500 font-medium"
              >Showing {{ recordsRangeStart }}-{{ recordsRangeEnd }}</span
            >
            <span class="text-[11px] text-gray-400"
              >{{ totalRecords }} total records</span
            >
          </div>

          <div class="flex items-center gap-1.5">
            <span class="text-[10px] text-gray-500">Rows per page</span>
            <div class="relative">
              <select
                v-model.number="recordsRowsPerPage"
                class="bg-white border border-gray-300 rounded-[6px] pl-2 pr-6 py-[2px] text-[10px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] appearance-none cursor-pointer"
              >
                <option
                  v-for="option in rowsPerPageOptions"
                  :key="option"
                  :value="option"
                >
                  {{ option }}
                </option>
              </select>
              <svg
                class="w-2.5 h-2.5 text-[#F52C11] absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none"
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
          </div>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="flex-1 flex items-center justify-center">
          <div class="text-gray-400 text-[12px]">Loading logs...</div>
        </div>

        <!-- Table -->
        <div v-else class="flex-1 min-h-0 overflow-auto custom-scroll relative">
          <table class="w-full border-collapse text-left table-fixed">
            <colgroup>
              <col class="w-10" />
              <col class="w-[15%]" />
              <col class="w-[20%]" />
              <col class="w-[15%]" />
              <col class="w-[25%]" />
              <col class="w-[25%]" />
            </colgroup>
            <thead class="bg-gray-100 sticky top-0 z-20">
              <tr class="border-b border-gray-200">
                <th class="px-2 py-[2px]"></th>
                <th
                  class="px-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                >
                  Timestamp
                </th>
                <th
                  class="px-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                >
                  User
                </th>
                <th
                  class="px-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                >
                  Role
                </th>
                <th
                  class="px-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                >
                  Module
                </th>
                <th
                  class="px-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                >
                  Description
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(log, index) in paginatedRecords"
                :key="log.id"
                class="bg-white hover:bg-[#F52C11]/10 transition-colors"
                :class="{
                  'border-b border-gray-100':
                    index !== paginatedRecords.length - 1,
                }"
              >
                <td class="px-2 py-[4px] text-[11px] text-gray-400 text-center">
                  {{ recordsRangeStart + index }}
                </td>
                <td class="px-4 py-[4px] whitespace-nowrap">
                  <div class="text-[11px] font-medium text-[#1F2835]">
                    {{ log.date }}
                  </div>
                  <div class="text-[9px] text-gray-400">{{ log.time }}</div>
                </td>
                <td
                  class="px-4 py-[4px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]"
                >
                  {{ log.user }}
                </td>
                <td class="px-4 py-[4px] whitespace-nowrap">
                  <span
                    class="inline-block px-2 py-[2px] rounded-full text-[9px] font-semibold"
                    :class="
                      log.role === 'Admin'
                        ? 'bg-[#F52C11]/10 text-[#F52C11]'
                        : 'bg-green-100 text-green-700'
                    "
                  >
                    {{ log.role }}
                  </span>
                </td>
                <td
                  class="px-4 py-[4px] whitespace-nowrap text-[11px] text-gray-600"
                >
                  {{ log.module }}
                </td>
                <td
                  class="px-4 py-[4px] whitespace-nowrap text-[11px] text-gray-600"
                >
                  {{ log.description }}
                </td>
              </tr>

              <tr v-if="paginatedRecords.length === 0">
                <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                  <div
                    v-if="
                      searchQuery ||
                      selectedRole !== 'All Users' ||
                      selectedModule !== 'All Modules' ||
                      selectedDate
                    "
                  >
                    No logs found matching current filters
                  </div>
                  <div v-else>No audit logs available</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>

    <!-- Pagination Footer - pinned to the very bottom of the screen -->
    <div
      class="shrink-0 bg-[#f0f0f0] border border-gray-200 border-t-0 rounded-b-[6px] mx-2.5 mb-2.5 px-2.5 py-1 flex items-center justify-between gap-2 flex-wrap"
    >
      <span class="text-[11px] text-gray-500"
        >Page {{ recordsCurrentPage }} of {{ totalRecordsPages }}</span
      >

      <div class="flex items-center gap-1">
        <span class="text-[11px] text-gray-500">Go to</span>
        <input
          v-model="recordsPageInput"
          type="number"
          min="1"
          :max="totalRecordsPages"
          placeholder="---"
          class="w-10 bg-white border border-gray-300 rounded-[6px] px-1.5 py-[1px] text-[11px] text-[#1F2835] text-center focus:outline-none focus:border-[#F52C11] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
          @keyup.enter="goToTypedRecordsPage"
        />
        <button
          @click="goToTypedRecordsPage"
          class="bg-gray-200 border border-gray-300 hover:bg-gray-300 text-[#1F2835] px-1.5 py-[1px] rounded-[6px] text-[9px] font-medium transition-colors"
        >
          Go
        </button>
      </div>

      <div class="flex items-center gap-0.5">
        <button
          @click="goToRecordsPage(recordsCurrentPage - 1)"
          :disabled="recordsCurrentPage === 1"
          class="w-5 h-5 flex items-center justify-center rounded-[6px] text-gray-400 hover:text-[#1F2835] hover:bg-gray-100 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-400 transition-colors"
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
              d="M15 19l-7-7 7-7"
            />
          </svg>
        </button>
        <button
          v-for="page in recordsPageNumbers"
          :key="page"
          @click="goToRecordsPage(page)"
          :class="
            recordsCurrentPage === page
              ? 'text-[#1F2835]'
              : 'text-gray-400 hover:bg-gray-100'
          "
          class="w-5 h-5 flex items-center justify-center rounded-[6px] text-[10px] font-medium transition-colors"
        >
          {{ page }}
        </button>
        <button
          @click="goToRecordsPage(recordsCurrentPage + 1)"
          :disabled="recordsCurrentPage === totalRecordsPages"
          class="w-5 h-5 flex items-center justify-center rounded-[6px] text-gray-400 hover:text-[#1F2835] hover:bg-gray-100 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-400 transition-colors"
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
              d="M9 5l7 7-7 7"
            />
          </svg>
        </button>
      </div>
    </div>

    <!-- Click outside to close dropdowns -->
    <div
      v-if="showDatePicker || showUsersDropdown || showModulesDropdown"
      class="fixed inset-0 z-40"
      @click="closeAllDropdowns"
    ></div>
        <!-- Click outside to close dropdowns -->
    <div
      v-if="showDatePicker || showUsersDropdown || showModulesDropdown"
      class="fixed inset-0 z-40"
      @click="closeAllDropdowns"
    ></div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useAuditLog } from "~/composables/useAuditLog";
// If this project isn't using Nuxt's "~" alias, change the import above to a
// relative path instead, e.g. import { useAuditLog } from '../../composables/useAuditLog'

// ==================== STATE ====================
const searchQuery = ref("");
const showDatePicker = ref(false);
const showUsersDropdown = ref(false);
const showModulesDropdown = ref(false);
const isLoading = ref(false);

// Users dropdown now filters by role (Admin / Sales)
const selectedRole = ref("All Users");
const roleOptions = ref(["All Users", "Admin", "Sales"]);

// Modules dropdown: 5 real modules
const selectedModule = ref("All Modules");
const moduleOptions = ref([
  "All Modules",
  "User Management",
  "Industry",
  "Performance Improvement Plan (PIP)",
  "Sales Task",
  "Audit Logs",
]);

// Date filter - COPIED FROM PIP: simple selectedDate string (MM/DD/YY), '' = no filter
const selectedDate = ref("");

// Live, shared audit-log data — any component in the app that calls
// logAuditAction() (see composables/useAuditLog.js) writes directly into
// this array, so entries show up here in real time, no fetch needed.
const { logs: records } = useAuditLog();

// ==================== COMPUTED ====================
const filteredRecords = computed(() => {
  let result = records.value;

  const q = searchQuery.value.trim().toLowerCase();
  if (q) {
    result = result.filter(
      (l) =>
        l.user?.toLowerCase().includes(q) ||
        l.description?.toLowerCase().includes(q) ||
        l.module?.toLowerCase().includes(q)
    );
  }

  if (selectedRole.value !== "All Users") {
    result = result.filter((l) => l.role === selectedRole.value);
  }

  if (selectedModule.value !== "All Modules") {
    result = result.filter((l) => l.module === selectedModule.value);
  }

  if (selectedDate.value) {
    result = result.filter((l) => l.date === selectedDate.value);
  }

  return result;
});

// ==================== PAGINATION ====================
const rowsPerPageOptions = [13, 26, 39, 52, 65];
const recordsRowsPerPage = ref(13);
const recordsCurrentPage = ref(1);
const recordsPageInput = ref("");

const totalRecords = computed(() => filteredRecords.value.length);

const totalRecordsPages = computed(() =>
  Math.max(
    1,
    Math.ceil(filteredRecords.value.length / recordsRowsPerPage.value)
  )
);

const paginatedRecords = computed(() => {
  const start = (recordsCurrentPage.value - 1) * recordsRowsPerPage.value;
  return filteredRecords.value.slice(start, start + recordsRowsPerPage.value);
});

const recordsRangeStart = computed(() =>
  filteredRecords.value.length === 0
    ? 0
    : (recordsCurrentPage.value - 1) * recordsRowsPerPage.value + 1
);
const recordsRangeEnd = computed(() =>
  Math.min(
    recordsCurrentPage.value * recordsRowsPerPage.value,
    filteredRecords.value.length
  )
);

const recordsPageNumbers = computed(() => {
  const total = totalRecordsPages.value;
  const current = recordsCurrentPage.value;
  const maxButtons = 5;
  let start = Math.max(1, current - Math.floor(maxButtons / 2));
  let end = Math.min(total, start + maxButtons - 1);
  start = Math.max(1, end - maxButtons + 1);
  const pages = [];
  for (let p = start; p <= end; p++) pages.push(p);
  return pages;
});

function goToRecordsPage(page) {
  recordsCurrentPage.value = Math.min(
    Math.max(1, page),
    totalRecordsPages.value
  );
}

function closeAllDropdowns() {
  showDatePicker.value = false;
  showUsersDropdown.value = false;
  showModulesDropdown.value = false;
}

function goToTypedRecordsPage() {
  const page = parseInt(recordsPageInput.value, 10);
  if (!isNaN(page)) goToRecordsPage(page);
  recordsPageInput.value = "";
}

watch(recordsRowsPerPage, () => {
  recordsCurrentPage.value = 1;
});
watch(filteredRecords, () => {
  if (recordsCurrentPage.value > totalRecordsPages.value) {
    recordsCurrentPage.value = totalRecordsPages.value;
  }
});

// ==================== CALENDAR - COPIED FROM PIP ====================
const currentMonth = ref(new Date().getMonth());
const currentYear = ref(new Date().getFullYear());

const currentMonthYear = computed(() => {
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  return `${months[currentMonth.value]} ${currentYear.value}`;
});

const calendarDays = computed(() => {
  const days = [];
  const startDay = new Date(currentYear.value, currentMonth.value, 1).getDay();
  const daysInMonth = new Date(
    currentYear.value,
    currentMonth.value + 1,
    0
  ).getDate();

  // Today in MM/DD/YY format to match the calendar cells
  const now = new Date();
  const todayStr = `${String(now.getMonth() + 1).padStart(2, "0")}/${String(
    now.getDate()
  ).padStart(2, "0")}/${String(now.getFullYear()).slice(-2)}`;

  for (let i = 0; i < startDay; i++) {
    days.push({ day: "", isCurrentMonth: false, date: null });
  }
  for (let i = 1; i <= daysInMonth; i++) {
    const dateStr = `${String(currentMonth.value + 1).padStart(
      2,
      "0"
    )}/${String(i).padStart(2, "0")}/${String(currentYear.value).slice(-2)}`;
    days.push({
      day: i,
      isCurrentMonth: true,
      date: dateStr,
      isSelected: selectedDate.value === dateStr,
      isToday: dateStr === todayStr,
    });
  }
  return days;
});

function prevMonth() {
  if (currentMonth.value === 0) {
    currentMonth.value = 11;
    currentYear.value--;
  } else currentMonth.value--;
}
function nextMonth() {
  if (currentMonth.value === 11) {
    currentMonth.value = 0;
    currentYear.value++;
  } else currentMonth.value++;
}
function selectDate(date) {
  if (date) {
    selectedDate.value = date;
    showDatePicker.value = false;
  }
}

function clearDateFilter() {
  selectedDate.value = "";
  showDatePicker.value = false;
}

// ==================== LIVE DATA ====================
// records is the shared, reactive audit-log store from composables/useAuditLog.js.
// Any component in the app that calls logAuditAction({ user, role, module, description })
// pushes a new entry into that same array, so this page updates instantly —
// no fetch, no polling, no mock data.

// If you later move audit logging to a real backend (e.g. so logs survive
// across devices/browsers, not just localStorage), replace the composable
// with an API-backed version and reintroduce a fetch on mount:
//
//   const isLoading = ref(true)
//   onMounted(async () => {
//     const response = await fetch('/api/audit-logs')
//     records.value = await response.json()
//     isLoading.value = false
//   })
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  -moz-appearance: textfield;
}

.custom-scroll::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: #f52c11;
  border-radius: 3px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #d9250e;
}

table th,
table td {
  border-left: none !important;
  border-right: none !important;
}
</style>
