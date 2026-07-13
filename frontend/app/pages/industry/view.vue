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
              View record
            </h3>
            <p class="text-[9px] text-gray-400 leading-tight">
              {{ displayRecord.businessName }} – {{ displayRecord.industry }}
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
      <div class="px-4 py-3 bg-white">
        <div class="grid grid-cols-2 gap-x-6 gap-y-3">
          <!-- Left Column -->
          <div class="space-y-3">
            <!-- Business name -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Business name
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.businessName || "—" }}
              </p>
            </div>

            <!-- Contact person -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Contact person
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.contactPerson || "—" }}
              </p>
            </div>

            <!-- Contact number -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Contact number
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.contactNo || "—" }}
              </p>
            </div>

            <!-- Service -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Service
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.service || "—" }}
              </p>
            </div>

            <!-- Remarks -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Remarks
              </p>
              <p
                class="text-[12px] font-medium"
                :class="
                  displayRecord.remarks ? 'text-[#1F2835]' : 'text-gray-400'
                "
              >
                {{ displayRecord.remarks || "No additional notes" }}
              </p>
            </div>
          </div>

          <!-- Right Column -->
          <div class="space-y-3">
            <!-- Location -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Location
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.location || "—" }}
              </p>
            </div>

            <!-- Job position -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Job position
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.jobPosition || "—" }}
              </p>
            </div>

            <!-- Email -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Email
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium break-all">
                {{ displayRecord.email || "—" }}
              </p>
            </div>

            <!-- Date -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Date
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.date || "—" }}
              </p>
            </div>

            <!-- Status -->
            <div>
              <div class="flex items-start justify-between mb-1">
                <p
                  class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400"
                >
                  Status
                </p>
                <span class="text-[12px] font-bold text-[#1F2835]">
                  {{ displayRecord.statusPercent }}%
                </span>
              </div>
              <!-- Progress Bar -->
              <div class="w-full h-[6px] bg-gray-100 rounded-full relative">
                <div
                  class="absolute top-0 left-0 h-[6px] rounded-full transition-all duration-300"
                  :style="{
                    width: displayRecord.statusPercent + '%',
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
          Back
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: "app",
  middleware: "auth",
});

import { computed } from "vue";

const props = defineProps({
  record: {
    type: Object,
    default: null,
  },
});

const displayRecord = computed(() => props.record || {});

const emit = defineEmits(["close"]);

function close() {
  emit("close");
}

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
  const value = Number(displayRecord.value.statusPercent) || 0;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return progressColorPalette[bucket - 1];
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");
</style>
