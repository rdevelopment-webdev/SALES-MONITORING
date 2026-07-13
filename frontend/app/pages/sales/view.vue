<template>
  <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div
      class="bg-white rounded-[8px] w-[520px] max-h-[85vh] shadow-xl flex flex-col overflow-hidden"
    >
      <!-- Header -->
      <div
        class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-white shrink-0"
      >
        <div class="flex items-center gap-2">
          <svg
            class="w-4 h-4 text-[#F52C11]"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
            />
          </svg>
          <div>
            <h3 class="text-[14px] font-bold text-[#1F2835]">Record Details</h3>
            <p class="text-[10px] text-gray-400">
              {{ record?.clientName || "—" }}
            </p>
          </div>
        </div>
        <button
          @click="$emit('close')"
          class="text-gray-400 hover:text-[#1F2835] transition-colors"
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

      <!-- Body -->
      <div class="flex-1 overflow-auto custom-scroll px-5 py-4">
        <div class="grid grid-cols-2 gap-x-4 gap-y-3">
          <div>
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Client Name
            </p>
            <p class="text-[12px] font-medium text-[#1F2835] mt-0.5">
              {{ record?.clientName || "—" }}
            </p>
          </div>
          <div>
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Date Recorded
            </p>
            <p class="text-[12px] font-medium text-[#1F2835] mt-0.5">
              {{ record?.dateRecorded || "—" }}
            </p>
          </div>
          <div>
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Service
            </p>
            <p class="text-[12px] font-medium text-[#1F2835] mt-0.5">
              {{ record?.service || "—" }}
            </p>
          </div>
          <div>
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Onboarding Date
            </p>
            <p class="text-[12px] font-medium text-[#1F2835] mt-0.5">
              {{ record?.onboardingDate || "—" }}
            </p>
          </div>

          <!-- These only render if present on the record -->
          <div v-if="record?.prospectTechnique">
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Prospect Technique
            </p>
            <p class="text-[12px] font-medium text-[#1F2835] mt-0.5">
              {{ record.prospectTechnique }}
            </p>
          </div>
          <div v-if="record?.salesRep">
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Sales Rep
            </p>
            <p class="text-[12px] font-medium text-[#1F2835] mt-0.5">
              {{ record.salesRep }}
            </p>
          </div>
          <div v-if="record?.communication">
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Communication
            </p>
            <p class="text-[12px] font-medium text-[#1F2835] mt-0.5">
              {{ record.communication }}
            </p>
          </div>

          <div class="col-span-2">
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Status
            </p>
            <div class="flex items-center gap-2 mt-1">
              <div
                class="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden"
              >
                <div
                  class="h-full rounded-full"
                  :style="{
                    width: (record?.status ?? 0) + '%',
                    backgroundColor: getStatusColor(record?.status ?? 0),
                  }"
                ></div>
              </div>
              <span
                class="text-[10px] font-semibold"
                :style="{ color: getStatusColor(record?.status ?? 0) }"
                >{{ record?.status ?? 0 }}%</span
              >
            </div>
          </div>

          <div v-if="record?.remarks || record?.notes" class="col-span-2">
            <p
              class="text-[10px] font-medium text-gray-400 uppercase tracking-wide"
            >
              Remarks
            </p>
            <p class="text-[12px] text-[#1F2835] mt-0.5 whitespace-pre-wrap">
              {{ record.remarks || record.notes }}
            </p>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div
        class="px-5 py-3 border-t border-gray-100 flex items-center justify-end bg-white shrink-0"
      >
        <button
          @click="$emit('close')"
          class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
        >
          Close
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  record: {
    type: Object,
    default: null,
  },
});

defineEmits(["close"]);

function getStatusColor(status) {
  if (status === 100) return "#006400";
  if (status >= 90) return "#90ee90";
  if (status >= 80) return "#7fffd4";
  if (status >= 70) return "#ffd700";
  if (status >= 60) return "#daa520";
  if (status >= 50) return "#ff8c00";
  if (status >= 40) return "#ba55d3";
  if (status >= 30) return "#4b0082";
  if (status >= 20) return "#800000";
  if (status >= 10) return "#000000";
  return "#9ca3af";
}
</script>
