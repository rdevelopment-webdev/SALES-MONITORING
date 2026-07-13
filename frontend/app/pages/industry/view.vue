<template>
  <div
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-[1px]"
  >
    <div
      class="bg-white rounded-[10px] w-[440px] shadow-2xl flex flex-col overflow-hidden"
    >
      <!-- Modal Header -->
      <div
        class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-white"
      >
        <div class="flex items-center gap-2">
          <div
            class="w-7 h-7 rounded-[6px] bg-[#F52C11]/10 flex items-center justify-center shrink-0"
          >
            <svg
              class="w-3.5 h-3.5 text-[#F52C11]"
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
            <h3 class="text-[13px] font-bold text-[#1F2835] leading-tight">
              View record
            </h3>
            <p class="text-[10px] text-gray-400 leading-tight mt-0.5">
              {{ displayRecord.businessName }} — {{ displayRecord.industry }}
              industry
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
      <div class="px-4 pt-3 pb-1">
        <div class="relative flex items-center justify-center">
          <div class="w-full border-t border-gray-200"></div>
          <span
            class="absolute bg-white px-2 text-[10px] text-gray-400 whitespace-nowrap"
            >Business info</span
          >
        </div>
      </div>

      <!-- Modal Body - Single Column Rows -->
      <div class="px-4 pb-1 bg-white">
        <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
          <span class="text-[12px] text-gray-500">Business name</span>
          <span class="text-[12px] font-bold text-[#1F2835]">{{
            displayRecord.businessName || "—"
          }}</span>
        </div>

        <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
          <span class="text-[12px] text-gray-500">Contact person</span>
          <span class="text-[12px] font-bold text-[#1F2835]">{{
            displayRecord.contactPerson || "—"
          }}</span>
        </div>

        <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
          <span class="text-[12px] text-gray-500">Job position</span>
          <span class="text-[12px] font-bold text-[#1F2835]">{{
            displayRecord.jobPosition || "—"
          }}</span>
        </div>

        <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
          <span class="text-[12px] text-gray-500">Location</span>
          <span class="text-[12px] font-bold text-[#1F2835]">{{
            displayRecord.location || "—"
          }}</span>
        </div>

        <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
          <span class="text-[12px] text-gray-500">Contact number</span>
          <span class="text-[12px] font-bold text-[#1F2835]">{{
            displayRecord.contactNo || "—"
          }}</span>
        </div>

        <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
          <span class="text-[12px] text-gray-500">Email</span>
          <span class="text-[12px] font-bold text-[#1F2835] break-all">{{
            displayRecord.email || "—"
          }}</span>
        </div>

        <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
          <span class="text-[12px] text-gray-500">Service</span>
          <span class="text-[12px] font-bold text-[#1F2835]">{{
            displayRecord.service || "—"
          }}</span>
        </div>

        <div class="flex items-center justify-between py-1.5">
          <span class="text-[12px] text-gray-500">Date</span>
          <span class="text-[12px] font-bold text-[#1F2835]">{{
            displayRecord.date || "—"
          }}</span>
        </div>
      </div>

      <!-- Remarks box -->
      <div class="px-4 pt-2 pb-1 bg-white">
        <div class="border border-gray-200 rounded-[7px] px-3 py-2">
          <p class="text-[12px] text-gray-500 mb-0.5">Remarks</p>
          <p
            class="text-[12px] font-bold"
            :class="displayRecord.remarks ? 'text-[#1F2835]' : 'text-gray-400'"
          >
            {{ displayRecord.remarks || "No additional notes" }}
          </p>
        </div>
      </div>

      <!-- Status -->
      <div class="px-4 pt-2 pb-3.5 bg-white">
        <div class="flex items-start justify-between mb-1.5">
          <div>
            <p class="text-[12px] font-bold text-[#1F2835] leading-tight">
              Status
            </p>
            <p class="text-[10px] text-gray-400 leading-tight mt-0.5">
              Progress bar updates automatically
            </p>
          </div>
          <div class="flex items-center gap-1 shrink-0">
            <div
              class="w-10 h-7 rounded-[6px] border border-gray-200 flex items-center justify-center text-[12px] font-bold text-[#1F2835]"
            >
              {{ displayRecord.statusPercent }}
            </div>
            <span class="text-[12px] text-gray-400">%</span>
          </div>
        </div>
        <!-- Progress Bar -->
        <div class="w-full h-1.5 bg-gray-100 rounded-full relative overflow-hidden">
          <div
            class="absolute top-0 left-0 h-1.5 rounded-full transition-all duration-300"
            :style="{
              width: displayRecord.statusPercent + '%',
              backgroundColor: progressColor,
            }"
          ></div>
        </div>
      </div>

      <!-- Footer -->
      <div
        class="px-4 py-2.5 border-t border-gray-100 flex items-center justify-end gap-2 bg-white"
      >
        <button
          type="button"
          @click="close"
          class="px-3.5 py-1.5 rounded-[6px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
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