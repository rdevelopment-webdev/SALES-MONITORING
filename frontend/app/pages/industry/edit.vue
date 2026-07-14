<template>
  <div
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-[1px]"
  >
    <div
      class="bg-white rounded-[6px] w-[560px] shadow-2xl flex flex-col overflow-hidden"
    >
      <!-- Modal Header -->
      <div
        class="flex items-center justify-between px-4 py-2 border-b border-gray-100 bg-white"
      >
        <div class="flex items-center gap-2">
          <div
            class="w-5 h-5 rounded-[4px] bg-[#F52C11]/10 flex items-center justify-center shrink-0"
          >
            <svg
              class="w-3 h-3 text-[#F52C11]"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              />
            </svg>
          </div>
          <div>
            <h3 class="text-[12px] font-bold text-[#1F2835] leading-tight">
              Edit record
            </h3>
            <p class="text-[9px] text-gray-400 leading-tight">
              {{ form.businessName || "—" }} – {{ form.industry || "—" }}
            </p>
          </div>
        </div>
        <button
          @click="close"
          class="text-[#F52C11] hover:text-[#d9250e] transition-colors"
        >
          <svg
            class="w-3.5 h-3.5"
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

      <!-- Save error -->
      <p
        v-if="displayError"
        class="px-4 pt-1.5 text-[9px] font-medium text-[#F52C11]"
      >
        {{ displayError }}
      </p>

      <!-- Centered "Business info" divider -->
      <div class="px-4 pt-2 pb-0">
        <div class="relative flex items-center justify-center">
          <div class="w-full border-t border-gray-200"></div>
          <span
            class="absolute bg-white px-2 text-[9px] text-gray-400 whitespace-nowrap"
            >Business info</span
          >
        </div>
      </div>

      <!-- Modal Body - Two Column Layout -->
      <div class="px-4 py-2.5 bg-white">
        <div class="grid grid-cols-2 gap-x-5 gap-y-2">
          <!-- Left Column -->
          <div class="space-y-2">
            <!-- Business name -->
            <div>
              <label
                class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
              >
                Business name
              </label>
              <input
                v-model="form.businessName"
                type="text"
                placeholder="Enter business name"
                class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                @keyup.enter="save"
              />
            </div>

            <!-- Contact person -->
            <div>
              <label
                class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
              >
                Contact person
              </label>
              <input
                v-model="form.contactPerson"
                type="text"
                placeholder="Enter a name"
                class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                @keyup.enter="save"
              />
            </div>

            <!-- Contact number - Philippine format, digits only, auto-dash, optional but must be complete if provided -->
            <div>
              <label
                class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
              >
                Contact number
              </label>
              <input
                v-model="form.contactNumber"
                type="tel"
                inputmode="numeric"
                maxlength="13"
                placeholder="09XX-XXX-XXXX"
                :class="[
                  'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                  errors.contactNumber
                    ? 'border-[#F52C11]'
                    : 'border-gray-200 focus:border-[#F52C11]',
                ]"
                @input="formatContactNumber"
                @keydown="handleContactKeydown"
                @blur="validateContactNumberField"
                @keyup.enter="save"
              />
              <p
                v-if="errors.contactNumber"
                class="text-[8px] text-[#F52C11] mt-0.5"
              >
                Enter the complete 11-digit number
              </p>
            </div>

            <!-- Service -->
            <div>
              <label
                class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
              >
                Service
              </label>
              <div class="relative">
                <select
                  v-model="form.service"
                  class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none focus:border-[#F52C11] transition-colors appearance-none cursor-pointer"
                  :class="form.service ? 'text-[#1F2835]' : 'text-gray-400'"
                >
                  <option value="">--</option>
                  <option
                    v-for="service in serviceOptions"
                    :key="service"
                    :value="service"
                  >
                    {{ service }}
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
            </div>

            <!-- Remarks -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
                >Remarks</label
              >
              <input
                v-model="form.remarks"
                type="text"
                placeholder="Notes about this lead, follow-up actions, outcomes..."
                class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                @keyup.enter="save"
              />
            </div>
          </div>

          <!-- Right Column -->
          <div class="space-y-2">
            <!-- Location -->
            <div>
              <label
                class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
              >
                Location
              </label>
              <input
                v-model="form.location"
                type="text"
                placeholder="Type a location"
                class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                @keyup.enter="save"
              />
            </div>

            <!-- Job position -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
                >Job position</label
              >
              <input
                v-model="form.jobPosition"
                type="text"
                placeholder="CEO, Owner, Manager..."
                class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                @keyup.enter="save"
              />
            </div>

            <!-- Email -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
                >Email</label
              >
              <input
                v-model="form.email"
                type="email"
                placeholder="example@company.com"
                :class="[
                  'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                  errors.email
                    ? 'border-[#F52C11]'
                    : 'border-gray-200 focus:border-[#F52C11]',
                ]"
                @blur="validateEmailField"
                @keyup.enter="save"
              />
              <p v-if="errors.email" class="text-[8px] text-[#F52C11] mt-0.5">
                Enter a valid email (must include @)
              </p>
            </div>

            <!-- Date -->
            <div>
              <label
                class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
              >
                Date
              </label>
              <div class="relative">
                <input
                  v-model="form.date"
                  type="text"
                  placeholder="mm/dd/yyyy"
                  readonly
                  class="w-full border border-gray-200 bg-white rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer"
                  @click="showDatePicker = true"
                />
                <button
                  @click="showDatePicker = true"
                  class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F52C11] transition-colors"
                  type="button"
                >
                  <svg
                    class="w-3.5 h-3.5"
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
                </button>
              </div>
            </div>

            <!-- Status -->
            <div>
              <div class="flex items-start justify-between mb-0.5">
                <div class="leading-tight">
                  <label class="text-[10.5px] font-bold text-[#1F2835]"
                    >Status</label
                  >
                  <p class="text-[8.7px] text-gray-400">
                    Progress bar updates automatically
                  </p>
                </div>
                <!-- Number + stepper share ONE rectangle -->
                <div class="flex items-center gap-1">
                  <div
                    class="flex items-center border border-gray-200 rounded-[4px] overflow-hidden"
                  >
                    <input
                      v-model.number="form.progress"
                      type="number"
                      min="0"
                      max="100"
                      step="10"
                      class="w-10 text-right text-[11px] font-semibold text-[#1F2835] bg-transparent border-none focus:outline-none p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                      @input="clampProgress"
                      @blur="clampProgress"
                      @keyup.enter="save"
                    />
                    <div class="flex flex-col">
                      <button
                        type="button"
                        @click="incrementProgress"
                        class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors"
                      >
                        <svg
                          class="w-2 h-2"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="3"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 15l7-7 7 7"
                          />
                        </svg>
                      </button>
                      <button
                        type="button"
                        @click="decrementProgress"
                        class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors"
                      >
                        <svg
                          class="w-2 h-2"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="3"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                          />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <span class="text-[11px] text-gray-400">%</span>
                </div>
              </div>
              <!-- Progress Bar -->
              <div class="w-full h-2 bg-gray-200 rounded-full relative">
                <div
                  class="absolute top-1/2 left-0 -translate-y-1/2 h-1 rounded-full transition-all duration-300"
                  :style="{
                    width: form.progress + '%',
                    backgroundColor: progressColor,
                  }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div
        class="px-4 py-2 border-t border-gray-100 flex items-center justify-end gap-2 bg-white"
      >
        <button
          type="button"
          @click="close"
          class="px-3 py-[4px] rounded-[4px] text-[10px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
        >
          Cancel
        </button>
        <button
          type="button"
          @click="save"
          :disabled="!isFormValid || displaySaving"
          :class="[
            'px-3 py-[4px] rounded-[4px] text-[10px] font-medium flex items-center gap-1 transition-colors',
            isFormValid && !displaySaving
              ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white'
              : 'bg-gray-300 text-gray-500 cursor-not-allowed',
          ]"
        >
          <svg
            v-if="displaySaving"
            class="w-3 h-3 animate-spin"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
          {{ displaySaving ? "Saving..." : "Save changes" }}
        </button>
      </div>
    </div>

    <!-- Date Picker Modal -->
    <div
      v-if="showDatePicker"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-[60]"
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

        <!-- Month/Year Navigation -->
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

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-0.5 mb-1">
          <div
            v-for="(day, i) in ['S', 'M', 'T', 'W', 'T', 'F', 'S']"
            :key="i"
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
              date.isSelected ? 'bg-[#F52C11] text-white' : 'hover:bg-gray-100',
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

<script setup>
definePageMeta({
  layout: "app",
  middleware: "auth",
});

import { computed, reactive, ref, watch } from "vue";

const props = defineProps({
  record: {
    type: Object,
    default: null,
  },
  errorMessage: {
    type: String,
    default: "",
  },
  saving: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["close", "save"]);

const saveError = ref("");
const displayError = computed(() => props.errorMessage || saveError.value);
const displaySaving = computed(() => props.saving || isSaving.value);

// ============================================
// FORM DATA
// ============================================
const form = reactive({});

function initForm() {
  const source = props.record || {};

  Object.assign(form, {
    businessName: source.businessName || "",
    industry: source.industry || "",
    contactPerson: source.contactPerson || "",
    jobPosition: source.jobPosition || "",
    contactNumber: source.contactNumber || source.contactNo || "",
    email: source.email || "",
    service: source.service || "",
    date: source.date || "",
    remarks: source.remarks || "",
    location: source.location || "",
    progress: source.progress ?? source.statusPercent ?? 30,
  });
}

watch(() => props.record, initForm, { immediate: true });

// ============================================
// ERROR STATE
// Only fields with a format (not a presence) requirement remain here.
// ============================================
const errors = reactive({
  email: false,
  contactNumber: false,
});

function resetErrors() {
  errors.email = false;
  errors.contactNumber = false;
}

// ============================================
// OPTIONS
// ============================================
const serviceOptions = [
  "Website Development",
  "Custom Software",
  "Mobile Application",
  "Digital Marketing",
  "Multimedia",
  "Hosting & Server",
];

// ============================================
// CONTACT NUMBER - Philippine format 0917-123-4567
// Optional (nullable): empty is valid; if the user starts typing, it
// must resolve to a complete 11-digit number.
// ============================================
function formatContactNumber() {
  const digitsOnly = form.contactNumber.replace(/\D/g, "").slice(0, 11);
  let formatted = digitsOnly;
  if (digitsOnly.length > 4 && digitsOnly.length <= 7) {
    formatted = `${digitsOnly.slice(0, 4)}-${digitsOnly.slice(4)}`;
  } else if (digitsOnly.length > 7) {
    formatted = `${digitsOnly.slice(0, 4)}-${digitsOnly.slice(
      4,
      7
    )}-${digitsOnly.slice(7)}`;
  }
  form.contactNumber = formatted;
}

function handleContactKeydown(e) {
  const allowed = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];
  if (allowed.includes(e.key)) return;
  if (!/^[0-9]$/.test(e.key)) e.preventDefault();
}

function isValidContactNumber(value) {
  if (!value || !value.trim()) return true; // nullable
  const digits = (value || "").replace(/\D/g, "");
  return digits.length === 11;
}

function validateContactNumberField() {
  errors.contactNumber = !isValidContactNumber(form.contactNumber);
}

// ============================================
// EMAIL VALIDATION
// ============================================
function isValidEmail(value) {
  if (!value || !value.trim()) return true; // nullable
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
}

function validateEmailField() {
  errors.email = !isValidEmail(form.email);
}

// ============================================
// STATUS / PROGRESS
// ============================================
const progressColorPalette = [
  "#f52c11",
  "#fa6f10",
  "#ffb300",
  "#ffd60a",
  "#888888",
  "#6b7a8f",
  "#7fb069",
  "#5e8c31",
  "#4f772d",
  "#639922",
];

const progressColor = computed(() => {
  const value = Number(form.progress) || 0;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return progressColorPalette[bucket - 1];
});

function clampProgress() {
  let value = Number(form.progress);
  if (isNaN(value)) value = 0;
  form.progress = Math.min(100, Math.max(0, Math.round(value)));
}

function incrementProgress() {
  const current = Number(form.progress) || 0;
  form.progress = Math.min(100, current + 10);
}

function decrementProgress() {
  const current = Number(form.progress) || 0;
  form.progress = Math.max(0, current - 10);
}

// ============================================
// DATE PICKER
// ============================================
const showDatePicker = ref(false);
const selectedDate = ref(null);
const viewDate = ref(new Date());

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

  // Previous month padding
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

  // Current month
  for (let day = 1; day <= lastDay.getDate(); day++) {
    const dateObj = new Date(year, month, day);
    const isToday = dateObj.toDateString() === today.toDateString();
    const isSelected =
      selectedDate.value &&
      dateObj.toDateString() === selectedDate.value.toDateString();

    dates.push({
      key: `current-${day}`,
      day,
      isCurrentMonth: true,
      isSelected,
      isToday,
      dateObj,
    });
  }

  // Next month padding
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
    form.date = selectedDate.value.toLocaleDateString("en-US", {
      month: "2-digit",
      day: "2-digit",
      year: "numeric",
    });
  }
  showDatePicker.value = false;
}

// Pre-select date when opening picker if form.date exists
watch(showDatePicker, (val) => {
  if (val && form.date) {
    const parts = form.date.split("/");
    if (parts.length === 3) {
      const month = parseInt(parts[0]) - 1;
      const day = parseInt(parts[1]);
      const year = parseInt(parts[2]);
      selectedDate.value = new Date(year, month, day);
      viewDate.value = new Date(year, month, 1);
    }
  }
});

// ============================================
// VALIDATION
// All fields are now nullable (optional). Only format-based checks
// remain: email and contact number must be well-formed *if* provided.
// ============================================
function validateForm() {
  errors.email = !isValidEmail(form.email);
  errors.contactNumber = !isValidContactNumber(form.contactNumber);

  return !Object.values(errors).some((error) => error);
}

const isFormValid = computed(() => {
  return isValidEmail(form.email) && isValidContactNumber(form.contactNumber);
});

// ============================================
// ACTIONS
// ============================================
const isSaving = ref(false);

function close() {
  resetErrors();
  emit("close");
}

async function save() {
  if (!validateForm()) return;

  isSaving.value = true;
  saveError.value = "";

  try {
    emit("save", { ...form });
  } catch (error) {
    console.error("Failed to save record:", error);
    saveError.value = error?.message || "Unable to save this record.";
  } finally {
    isSaving.value = false;
  }
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

/* Remove number input spinners */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  -webkit-appearance: none;
  -moz-appearance: textfield;
  appearance: textfield;
}
</style>