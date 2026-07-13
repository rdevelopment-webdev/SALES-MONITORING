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

      <!-- Modal Body - Two Column Layout -->
      <div class="px-4 py-3 bg-white">
        <div class="grid grid-cols-2 gap-x-6 gap-y-3">
          <!-- Left Column -->
          <div class="space-y-3">
            <!-- Date Recorded -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Date Recorded
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.dateRecorded || "—" }}
              </p>
            </div>

            <!-- Client Name -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Client Name
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.clientName || "—" }}
              </p>
            </div>

            <!-- Prospect Technique -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Prospect Technique
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.prospectTechnique || "—" }}
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
          </div>

          <!-- Right Column -->
          <div class="space-y-3">
            <!-- Onboarding Date -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Onboarding Date
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.onboardingDate || "—" }}
              </p>
            </div>

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

            <!-- Sales Representative -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Sales Representative
              </p>
              <div
                v-if="
                  displayRecord.salesRepresentative &&
                  displayRecord.salesRepresentative.length
                "
                class="flex flex-wrap items-center gap-1"
              >
                <span
                  v-for="(rep, index) in displayRecord.salesRepresentative"
                  :key="index"
                  class="inline-flex items-center px-1.5 py-[2px] rounded-[3px] bg-[#F52C11]/10 text-[#1F2835] text-[9.5px] font-medium"
                >
                  {{ rep }}
                </span>
              </div>
              <p v-else class="text-[12px] text-[#1F2835] font-medium">—</p>
            </div>

            <!-- Ways of Communication -->
            <div>
              <p
                class="text-[9.5px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5"
              >
                Ways of Communication
              </p>
              <p class="text-[12px] text-[#1F2835] font-medium">
                {{ displayRecord.waysOfCommunication || "—" }}
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
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-100 my-3"></div>

        <!-- Bottom Cards Row -->
        <div class="grid grid-cols-2 gap-x-6">
          <!-- Contact Person Card -->
          <div>
            <div class="flex items-center gap-1.5 mb-2">
              <div
                class="w-4 h-4 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
              >
                <svg
                  class="w-2.5 h-2.5 text-black"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                  />
                </svg>
              </div>
              <div>
                <p class="text-[10.5px] font-bold text-[#1F2835] leading-tight">
                  Contact Person
                </p>
                <p class="text-[8.7px] text-gray-400 leading-tight">
                  Primary point of contact
                </p>
              </div>
            </div>
            <div class="space-y-2 pl-[22px]">
              <!-- Contact Person Name -->
              <div class="flex items-center gap-1.5">
                <svg
                  class="w-3 h-3 text-gray-400 shrink-0"
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
                <p class="text-[12px] text-[#1F2835] font-medium">
                  {{ displayRecord.contactPersonName || "—" }}
                </p>
              </div>
              <!-- Contact Number -->
              <div class="flex items-center gap-1.5">
                <svg
                  class="w-3 h-3 text-gray-400 shrink-0"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                  />
                </svg>
                <p class="text-[12px] text-[#1F2835] font-medium">
                  {{ displayRecord.contactPersonPhone || "—" }}
                </p>
              </div>
            </div>
          </div>

          <!-- Status and Progress Card -->
          <div>
            <div class="flex items-center gap-1.5 mb-2">
              <div
                class="w-4 h-4 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
              >
                <svg
                  class="w-2.5 h-2.5 text-black"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                  />
                </svg>
              </div>
              <div>
                <p class="text-[10.5px] font-bold text-[#1F2835] leading-tight">
                  Status and progress
                </p>
                <p class="text-[8.7px] text-gray-400 leading-tight">
                  Current lead stage
                </p>
              </div>
            </div>
            <div class="pl-[22px]">
              <div class="flex items-start justify-between mb-1">
                <p class="text-[12px] text-[#1F2835] font-medium">
                  {{ displayRecord.leadStatus || "—" }}
                </p>
                <span class="text-[12px] font-bold text-[#1F2835]"
                  >{{ displayRecord.status }}%</span
                >
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
