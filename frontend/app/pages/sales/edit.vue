<template>
  <div
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-[1px]"
  >
    <div
      class="bg-white rounded-[6px] w-[690px] h-[450px] shadow-2xl flex flex-col overflow-hidden"
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
              class="w-3 h-3 text-black"
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
              Edit task
            </h3>
            <p class="text-[9px] text-gray-400 leading-tight">
              Update the details of your task
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

      <!-- Modal Body -->
      <div class="px-4 py-2.5 bg-white flex-1 flex flex-col min-h-0">
        <div class="grid grid-cols-2 gap-x-5 gap-y-2">
          <!-- Left Column: Date -->
          <div>
            <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5"
              >Date</label
            >
            <div class="relative">
              <input
                v-model="form.date"
                type="text"
                placeholder="mm/dd/yyyy"
                readonly
                class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer h-[28px]"
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

          <!-- Right Column: Status -->
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
              <!-- Number + stepper -->
              <div class="flex items-center gap-1">
                <div
                  class="flex items-center border border-gray-300 rounded-[4px] overflow-hidden bg-white"
                >
                  <input
                    v-model.number="computedProgress"
                    type="number"
                    min="0"
                    max="100"
                    readonly
                    class="w-10 text-right text-[11px] font-bold text-[#1F2835] bg-transparent border-none focus:outline-none p-0 py-[1px] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
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
                <span class="text-[10px] text-gray-400">%</span>
              </div>
            </div>
            <!-- Progress Bar -->
            <div class="w-full h-[10px] bg-gray-200 rounded-full relative">
              <div
                class="absolute top-1/2 left-0 -translate-y-1/2 h-[6px] rounded-full transition-all duration-300"
                :style="{
                  width: computedProgress + '%',
                  backgroundColor: progressColor,
                }"
              ></div>
            </div>
          </div>
        </div>

        <!-- Checklist Section -->
        <div
          class="mt-3 flex-1 flex flex-col min-h-0 border border-gray-200 rounded-[4px] overflow-hidden"
        >
          <div
            class="border border-gray-200 rounded-[4px] overflow-hidden flex flex-col h-full"
          >
            <!-- Title & Subtitle - Fixed Header -->
            <div
              class="px-3 pt-2 pb-1.5 border-b border-gray-100 bg-white shrink-0"
            >
              <h4 class="text-[11px] font-bold text-[#1F2835]">Checklist</h4>
              <p class="text-[9px] text-gray-400 mt-0.5">
                Add checklist item to track progress.
              </p>
            </div>

            <!-- Scrollable List -->
            <div class="flex-1 overflow-y-auto checklist-scroll min-h-0">
              <!-- Empty state -->
              <div
                v-if="form.checklist.length === 0"
                class="px-3 py-4 text-center text-[9px] text-gray-400"
              >
                No checklist items yet — type below and press Enter to add one.
              </div>

              <!-- Main Checklist items -->
              <div
                v-for="(item, index) in form.checklist"
                :key="item.id"
                class="border-b border-gray-100"
              >
                <!-- Main Item Row -->
                <div
                  class="group flex items-center gap-2 px-3 py-1.5 hover:bg-gray-50 transition-colors"
                >
                  <!-- Checkbox -->
                  <div
                    @click="toggleChecklistItem(index)"
                    :class="[
                      'w-3.5 h-3.5 rounded border flex items-center justify-center transition-colors cursor-pointer shrink-0',
                      item.completed
                        ? 'bg-[#F52C11] border-[#F52C11]'
                        : 'border-gray-300 hover:border-gray-400',
                    ]"
                  >
                    <svg
                      v-if="item.completed"
                      class="w-2.5 h-2.5 text-white"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="3"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                  </div>

                  <!-- Editable Text -->
                  <input
                    v-model="item.text"
                    type="text"
                    class="flex-1 text-[10px] bg-transparent border-none focus:outline-none focus:ring-0 p-0"
                    :class="[
                      item.completed
                        ? 'text-gray-400 line-through'
                        : 'text-[#1F2835]',
                    ]"
                    @keydown.enter.prevent="addItemBelow(index)"
                    @keydown.backspace="handleBackspace(index, $event)"
                    placeholder="Type here..."
                  />

                  <!-- Sub-item count badge -->
                  <span
                    v-if="item.subItems && item.subItems.length > 0"
                    class="text-[8px] px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-500 shrink-0"
                  >
                    {{ item.subItems.filter(s => s.completed).length }}/{{ item.subItems.length }}
                  </span>

                  <!-- Toggle sub-items button -->
                  <button
                    type="button"
                    @click="item.showSubItems = !item.showSubItems"
                    v-if="item.subItems && item.subItems.length > 0"
                    class="text-gray-400 hover:text-[#F52C11] transition-colors shrink-0 p-0.5 rounded hover:bg-gray-100"
                    :class="item.showSubItems ? 'rotate-180' : ''"
                    style="transition: transform 0.2s;"
                  >
                    <svg
                      class="w-3 h-3"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2.5"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 9l-7 7-7-7"
                      />
                    </svg>
                  </button>

                  <!-- Add sub-item button -->
                  <button
                    type="button"
                    @click="addSubItem(index)"
                    class="opacity-0 group-hover:opacity-100 text-gray-400 hover:text-[#F52C11] transition-all duration-200 shrink-0 p-0.5 rounded hover:bg-gray-100"
                    title="Add sub-item"
                  >
                    <svg
                      class="w-3 h-3"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2.5"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4"
                      />
                    </svg>
                  </button>

                  <!-- Delete X button -->
                  <button
                    type="button"
                    @click="deleteChecklistItem(index)"
                    class="opacity-0 group-hover:opacity-100 text-[#F52C11] hover:text-[#d9250e] transition-all duration-200 shrink-0 p-0.5 rounded hover:bg-red-50"
                    title="Delete item"
                  >
                    <svg
                      class="w-3 h-3"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2.5"
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

                <!-- Sub-items Container -->
                <div
                  v-if="item.showSubItems && item.subItems && item.subItems.length > 0"
                  class="bg-gray-50/50 border-t border-gray-100/50"
                >
                  <div
                    v-for="(subItem, subIndex) in item.subItems"
                    :key="subItem.id"
                    class="group flex items-center gap-2 pl-8 pr-3 py-1 hover:bg-gray-100/50 transition-colors border-b border-gray-100/30 last:border-b-0"
                  >
                    <!-- Sub-item checkbox -->
                    <div
                      @click="toggleSubItem(index, subIndex)"
                      :class="[
                        'w-3 h-3 rounded border flex items-center justify-center transition-colors cursor-pointer shrink-0',
                        subItem.completed
                          ? 'bg-[#F52C11] border-[#F52C11]'
                          : 'border-gray-300 hover:border-gray-400',
                      ]"
                    >
                      <svg
                        v-if="subItem.completed"
                        class="w-2 h-2 text-white"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="3"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5 13l4 4L19 7"
                        />
                      </svg>
                    </div>

                    <!-- Sub-item text -->
                    <input
                      v-model="subItem.text"
                      type="text"
                      class="flex-1 text-[9.5px] bg-transparent border-none focus:outline-none focus:ring-0 p-0"
                      :class="[
                        subItem.completed
                          ? 'text-gray-400 line-through'
                          : 'text-[#1F2835]',
                      ]"
                      @keydown.enter.prevent="addSubItemBelow(index, subIndex)"
                      @keydown.backspace="handleSubBackspace(index, subIndex, $event)"
                      placeholder="Sub task..."
                    />

                    <!-- Delete sub-item -->
                    <button
                      type="button"
                      @click="deleteSubItem(index, subIndex)"
                      class="opacity-0 group-hover:opacity-100 text-[#F52C11] hover:text-[#d9250e] transition-all duration-200 shrink-0 p-0.5 rounded hover:bg-red-50"
                      title="Delete sub-item"
                    >
                      <svg
                        class="w-2.5 h-2.5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Save Error -->
      <div
        v-if="errorMessage"
        class="px-4 py-1.5 border-t border-red-100 bg-red-50 text-[10px] text-red-600 font-medium shrink-0"
      >
        {{ errorMessage }}
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
          @click="saveChanges"
          :disabled="isSaving || !form.date"
          :class="[
            'px-3 py-[4px] rounded-[4px] text-[10px] font-medium flex items-center gap-1 transition-colors',
            !isSaving && form.date
              ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white'
              : 'bg-gray-300 text-gray-500 cursor-not-allowed',
          ]"
        >
          <svg
            v-if="isSaving"
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
          {{ isSaving ? "Saving..." : "Save changes" }}
        </button>
      </div>
    </div>

    <!-- Date Picker Modal -->
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
import { ref, computed, reactive, watch, onMounted, nextTick } from "vue";

// ============================================
// PROPS
// ============================================
const props = defineProps({
  task: {
    type: Object,
    default: null,
  },
  // True while the parent (index.vue) is actually persisting the update
  // to the backend. Drives the button spinner/disabled state instead of
  // a fake local timer.
  saving: {
    type: Boolean,
    default: false,
  },
  // Set by the parent when the real save request fails, so we can show
  // the error without losing what the user typed.
  errorMessage: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["close", "save"]);

// ============================================
// SAMPLE TASK (matches the image exactly)
// ============================================
const sampleTask = {
  date: "06/22/2026",
  checklist: [
    {
      id: 1,
      text: "Send proposal email",
      completed: true,
      subItems: [
        { id: 101, text: "Draft email content", completed: true },
        { id: 102, text: "Attach pricing PDF", completed: true },
      ],
    },
    {
      id: 2,
      text: "Schedule discovery call",
      completed: false,
      subItems: [
        { id: 201, text: "Check calendar availability", completed: true },
        { id: 202, text: "Send invite to client", completed: false },
        { id: 203, text: "Prepare agenda", completed: false },
      ],
    },
    { id: 3, text: "Follow up on pricing", completed: true, subItems: [] },
    { id: 4, text: "Collect client requirements", completed: false, subItems: [] },
  ],
};
// ============================================
// FORM DATA
// ============================================
const form = reactive({
  date: "",
  checklist: [],
});

// ============================================
// UI STATE
// ============================================
const showDatePicker = ref(false);
const selectedDate = ref(null);
const viewDate = ref(new Date());
const isSaving = computed(() => props.saving);
const newItemText = ref("");
const newItemInput = ref(null);

// ============================================
// INITIALIZE FORM
// ============================================
function initializeForm() {
  const source = props.task || sampleTask;
  form.date = source.date || "";
  form.checklist = (source.checklist || []).map((item) => ({
    id: item.id || Date.now() + Math.random(),
    text: item.text || "",
    completed: item.completed || false,
    subItems: (item.subItems || []).map((sub) => ({
      id: sub.id || Date.now() + Math.random(),
      text: sub.text || "",
      completed: sub.completed || false,
    })),
    showSubItems: true,
  }));
}

onMounted(() => {
  initializeForm();
});

watch(
  () => props.task,
  () => {
    initializeForm();
  },
  { deep: true }
);

// ============================================
// COMPUTED - PROGRESS BASED ON CHECKLIST
// ============================================
const computedProgress = computed(() => {
  if (form.checklist.length === 0) return 0;

  let totalItems = 0;
  let completedItems = 0;

  form.checklist.forEach((item) => {
    if (item.subItems && item.subItems.length > 0) {
      totalItems += item.subItems.length;
      completedItems += item.subItems.filter((s) => s.completed).length;
    } else {
      totalItems += 1;
      if (item.completed) completedItems += 1;
    }
  });

  if (totalItems === 0) return 0;
  return Math.round((completedItems / totalItems) * 100);
});

const progressColor = computed(() => {
  const value = computedProgress.value;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return progressColorPalette[bucket - 1];
});

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

function incrementProgress() {
  for (const item of form.checklist) {
    if (item.subItems && item.subItems.length > 0) {
      const unchecked = item.subItems.find((s) => !s.completed);
      if (unchecked) {
        unchecked.completed = true;
        const allChecked = item.subItems.every((s) => s.completed);
        item.completed = allChecked;
        return;
      }
    } else if (!item.completed) {
      item.completed = true;
      return;
    }
  }
}

function decrementProgress() {
  for (let i = form.checklist.length - 1; i >= 0; i--) {
    const item = form.checklist[i];
    if (item.subItems && item.subItems.length > 0) {
      for (let j = item.subItems.length - 1; j >= 0; j--) {
        if (item.subItems[j].completed) {
          item.subItems[j].completed = false;
          item.completed = false;
          return;
        }
      }
    } else if (item.completed) {
      item.completed = false;
      return;
    }
  }
}

// ============================================
// CHECKLIST METHODS
// ============================================
// Toggle main item — also toggles ALL sub-items
function toggleChecklistItem(index) {
  const item = form.checklist[index];
  item.completed = !item.completed;

  if (item.subItems && item.subItems.length > 0) {
    item.subItems.forEach((sub) => {
      sub.completed = item.completed;
    });
  }
}

// Toggle sub-item — update main item based on all sub-items state
function toggleSubItem(index, subIndex) {
  const item = form.checklist[index];
  item.subItems[subIndex].completed = !item.subItems[subIndex].completed;

  // Main item is checked ONLY if ALL sub-items are checked
  const allChecked = item.subItems.every((s) => s.completed);
  item.completed = allChecked;
}

// Add sub-item to a main item (via + button)
function addSubItem(index) {
  const item = form.checklist[index];
  if (!item.subItems) item.subItems = [];
  item.showSubItems = true;
  const newSub = {
    id: Date.now() + Math.random(),
    text: "",
    completed: false,
  };
  item.subItems.push(newSub);
  if (item.subItems.length === 1) {
    item.completed = false;
  }
  nextTick(() => {
    const containers = document.querySelectorAll(".checklist-scroll > div");
    if (containers[index]) {
      const subInputs = containers[index].querySelectorAll('input[placeholder="Sub task..."]');
      if (subInputs.length > 0) {
        subInputs[subInputs.length - 1].focus();
      }
    }
  });
}

// Add sub-item below specific sub-item (when pressing Enter)
function addSubItemBelow(index, subIndex) {
  const item = form.checklist[index];
  const newSub = {
    id: Date.now() + Math.random(),
    text: "",
    completed: false,
  };
  item.subItems.splice(subIndex + 1, 0, newSub);

  nextTick(() => {
    const containers = document.querySelectorAll(".checklist-scroll > div");
    if (containers[index]) {
      const subInputs = containers[index].querySelectorAll('input[placeholder="Sub task..."]');
      if (subInputs[subIndex + 1]) {
        subInputs[subIndex + 1].focus();
      }
    }
  });
}

// Delete sub-item
function deleteSubItem(index, subIndex) {
  const item = form.checklist[index];
  item.subItems.splice(subIndex, 1);

  // Update main item completion after deletion
  if (item.subItems.length > 0) {
    const allChecked = item.subItems.every((s) => s.completed);
    item.completed = allChecked;
  }
}

// Handle backspace on empty sub-item
function handleSubBackspace(index, subIndex, event) {
  const item = form.checklist[index];
  const subItem = item.subItems[subIndex];
  if (subItem.text === "" && item.subItems.length > 0) {
    event.preventDefault();
    item.subItems.splice(subIndex, 1);

    nextTick(() => {
      const containers = document.querySelectorAll(".checklist-scroll > div");
      if (containers[index]) {
        const subInputs = containers[index].querySelectorAll('input[placeholder="Sub task..."]');
        if (subInputs.length > 0 && subIndex > 0) {
          const focusIndex = Math.min(subIndex - 1, subInputs.length - 1);
          subInputs[focusIndex].focus();
        } else if (subInputs.length > 0) {
          subInputs[0].focus();
        }
      }
    });
  }
}

// Add new item below a specific index
function addItemBelow(index) {
  const newItem = {
    id: Date.now() + Math.random(),
    text: "",
    completed: false,
    subItems: [],
    showSubItems: true,
    newSubText: "",
  };
  form.checklist.splice(index + 1, 0, newItem);

  nextTick(() => {
    const inputs = document.querySelectorAll(
      '.checklist-scroll input[type="text"]:not([placeholder="Sub task..."])'
    );
    if (inputs[index + 1]) {
      inputs[index + 1].focus();
    }
  });
}

// Handle backspace on empty main item
function handleBackspace(index, event) {
  const item = form.checklist[index];
  if (item.text === "" && form.checklist.length > 0) {
    event.preventDefault();
    deleteChecklistItem(index);

    nextTick(() => {
      const inputs = document.querySelectorAll(
        '.checklist-scroll input[type="text"]:not([placeholder="Sub task..."])'
      );
      if (inputs.length > 0 && index > 0) {
        const focusIndex = Math.min(index - 1, inputs.length - 1);
        inputs[focusIndex].focus();
      }
    });
  }
}

function deleteChecklistItem(index) {
  form.checklist.splice(index, 1);
}

// ============================================
// CALENDAR COMPUTED
// ============================================
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

// ============================================
// CALENDAR METHODS
// ============================================
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
    const formattedDate = selectedDate.value.toLocaleDateString("en-US", {
      month: "2-digit",
      day: "2-digit",
      year: "numeric",
    });
    form.date = formattedDate;
  }
  showDatePicker.value = false;
}

// ============================================
// ACTIONS
// ============================================
function close() {
  showDatePicker.value = false;
  emit("close");
}

function saveChanges() {
  if (isSaving.value || !form.date) return;

  const payload = {
    date: form.date,
    checklist: form.checklist.map((item) => ({
      id: item.id,
      text: item.text,
      completed: item.completed,
      subItems: item.subItems ? item.subItems.map((sub) => ({
        id: sub.id,
        text: sub.text,
        completed: sub.completed,
      })) : [],
    })),
    progress: computedProgress.value,
  };

  // Hand off to the parent, which makes the real API call. The parent
  // closes this modal on success or leaves it open and passes back
  // errorMessage on failure — we don't close ourselves here so a failed
  // save can never look like a success.
  emit("save", payload);
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

/* Custom scrollbar for checklist - Red (#F52C11) color */
.checklist-scroll::-webkit-scrollbar {
  width: 6px;
}
.checklist-scroll::-webkit-scrollbar-track {
  background: transparent;
}
.checklist-scroll::-webkit-scrollbar-thumb {
  background: #f52c11;
  border-radius: 3px;
}
.checklist-scroll::-webkit-scrollbar-thumb:hover {
  background: #d9250e;
}
</style>