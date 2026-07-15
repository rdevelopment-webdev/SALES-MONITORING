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
              View record
            </h3>
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

      <!-- Modal Body - Single Column Layout -->
      <div class="px-4 py-3 bg-white">
        <div class="divide-y divide-gray-100">
          <!-- Date Recorded -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Date recorded</p>
            <p class="text-[12px] text-[#1F2835] font-bold">
              {{ displayRecord.dateRecorded || "—" }}
            </p>
          </div>

          <!-- Onboarding Date -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Onboarding date</p>
            <p class="text-[12px] text-[#1F2835] font-bold">
              {{ displayRecord.onboardingDate || "—" }}
            </p>
          </div>

          <!-- Client Name -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Client name</p>
            <p class="text-[12px] text-[#1F2835] font-bold">
              {{ displayRecord.clientName || "—" }}
            </p>
          </div>

          <!-- Location -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Location</p>
            <p class="text-[12px] text-[#1F2835] font-bold">
              {{ displayRecord.location || "—" }}
            </p>
          </div>

          <!-- Prospect Technique -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Prospect technique</p>
            <p class="text-[12px] text-[#1F2835] font-bold">
              {{ displayRecord.prospectTechnique || "—" }}
            </p>
          </div>

          <!-- Email -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Email</p>
            <p class="text-[12px] text-[#1F2835] font-bold break-all">
              {{ displayRecord.email || "—" }}
            </p>
          </div>

          <!-- Ways of Communication -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Ways of communication</p>
            <p class="text-[12px] text-[#1F2835] font-bold">
              {{ displayRecord.waysOfCommunication || "—" }}
            </p>
          </div>

          <!-- Service -->
          <div class="flex items-center justify-between py-1.5">
            <p class="text-[11px] text-gray-500">Service</p>
            <p class="text-[12px] text-[#1F2835] font-bold">
              {{ displayRecord.service || "—" }}
            </p>
          </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-100 my-3"></div>

        <!-- Contact Person Card -->
        <div class="border border-gray-100 rounded-[6px] p-2.5">
          <p class="text-[10.5px] font-bold text-[#1F2835] mb-1.5">
            Contact person
          </p>
          <div class="flex items-center gap-1.5">
            <svg
              class="w-3.5 h-3.5 text-gray-400 shrink-0"
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
            <div>
              <p class="text-[12px] text-[#1F2835] font-bold leading-tight">
                {{ displayRecord.contactPersonName || "—" }}
              </p>
              <p class="text-[12px] text-[#1F2835] font-bold leading-tight">
                {{ displayRecord.contactPersonPhone || "—" }}
              </p>
            </div>
          </div>
        </div>

        <!-- Remarks Card -->
        <div class="border border-gray-100 rounded-[6px] p-2.5 mt-2">
          <p class="text-[10.5px] font-bold text-[#1F2835] mb-1">Remarks</p>
          <p
            class="text-[12px] font-bold"
            :class="displayRecord.remarks ? 'text-[#1F2835]' : 'text-gray-400'"
          >
            {{ displayRecord.remarks || "No additional notes" }}
          </p>
        </div>

        <!-- Sales Representative -->
        <div class="border border-gray-100 rounded-[6px] p-2.5 mt-2">
          <p class="text-[10.5px] font-bold text-[#1F2835] mb-1.5">
            Sales representative
          </p>
          <div
            v-if="
              displayRecord.salesRepresentative &&
              displayRecord.salesRepresentative.length
            "
            class="flex flex-wrap items-center gap-1.5"
          >
            <span
              v-for="(rep, index) in displayRecord.salesRepresentative"
              :key="index"
              class="inline-flex items-center px-2 py-[3px] rounded-full bg-[#F52C11]/10 text-[#F52C11] text-[10px] font-semibold"
            >
              {{ rep }}
            </span>
          </div>
          <p v-else class="text-[12px] text-gray-400 font-medium">—</p>
        </div>

        <!-- Status and Progress -->
        <div class="border border-gray-100 rounded-[6px] p-2.5 mt-2">
          <div class="flex items-start justify-between mb-1.5">
            <div>
              <p class="text-[10.5px] font-bold text-[#1F2835] leading-tight">
                Status
              </p>
              <p class="text-[9px] text-gray-400 leading-tight">
                Progress bar updates automatically
              </p>
            </div>
            <div
              class="flex items-center gap-0.5 border border-gray-200 rounded-[4px] px-2 py-1"
            >
              <span class="text-[12px] font-bold text-[#1F2835]">{{
                displayRecord.status
              }}</span>
              <span class="text-[12px] font-bold text-[#1F2835]">%</span>
            </div>
          </div>
          <!-- Progress Bar -->
          <div class="w-full h-[6px] bg-gray-100 rounded-full relative">
            <div
              class="absolute top-0 left-0 h-[6px] rounded-full transition-all duration-300"
              :style="{
                width: displayRecord.status + '%',
                backgroundColor: progressColor,
              }"
            ></div>
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

const sampleRecord = {
  dateRecorded: "06/22/2026",
  onboardingDate: "06/22/2026",
  clientName: "Ana Smith",
  prospectTechnique: "Cold Calling",
  email: "anasmith@gmail.com",
  service: "Multimedia",
  location: "Davao",
  salesRepresentative: ["Sales Representative 1", "Sales Representative 2"],
  waysOfCommunication: "Messenger",
  remarks: "",
  contactPersonName: "Ana Smith",
  contactPersonPhone: "0909-326-4879",
  status: 20,
  leadStatus: "Prospect",
};

const displayRecord = computed(() => props.record || sampleRecord);

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
  const value = Number(displayRecord.value.status) || 0;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return progressColorPalette[bucket - 1];
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");
</style>