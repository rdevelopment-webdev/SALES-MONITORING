<template>
  <teleport to="body">
    <div
      class="fixed top-4 left-1/2 -translate-x-1/2 z-[9999] flex flex-col items-center gap-2 pointer-events-none"
    >
      <transition-group name="toast">
        <div
          v-for="toast in toasts"
          :key="toast.id"
          class="pointer-events-auto flex items-center gap-2.5 min-w-[280px] max-w-[420px] px-4 py-3 rounded-[8px] shadow-lg border text-[13px] font-medium bg-white"
          :class="containerClass(toast.type)"
        >
          <span class="shrink-0 self-start mt-[1px]">
            <!-- success -->
            <svg
              v-if="toast.type === 'success'"
              class="w-4.5 h-4.5 text-green-600"
              fill="none"
              stroke="currentColor"
              stroke-width="2.2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 13l4 4L19 7"
              />
            </svg>
            <!-- error -->
            <svg
              v-else-if="toast.type === 'error'"
              class="w-4.5 h-4.5 text-[#F52C11]"
              fill="none"
              stroke="currentColor"
              stroke-width="2.2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14.14A1 1 0 003 19.5h18a1 1 0 00.89-1.5L13.71 3.86a1 1 0 00-1.72 0z"
              />
            </svg>
            <!-- warning -->
            <svg
              v-else-if="toast.type === 'warning'"
              class="w-4.5 h-4.5 text-amber-500"
              fill="none"
              stroke="currentColor"
              stroke-width="2.2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14.14A1 1 0 003 19.5h18a1 1 0 00.89-1.5L13.71 3.86a1 1 0 00-1.72 0z"
              />
            </svg>
            <!-- info -->
            <svg
              v-else
              class="w-4.5 h-4.5 text-blue-500"
              fill="none"
              stroke="currentColor"
              stroke-width="2.2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </span>

          <span class="flex-1 leading-snug text-[#1F2835]">{{
            toast.message
          }}</span>

          <button
            @click="remove(toast.id)"
            class="shrink-0 text-gray-350 hover:text-gray-500 transition-colors"
            aria-label="Dismiss notification"
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
      </transition-group>
    </div>
  </teleport>
</template>

<script setup>
import { useToast } from "~/composables/useToast";

const { toasts, remove } = useToast();

function containerClass(type) {
  switch (type) {
    case "success":
      return "border-green-200";
    case "error":
      return "border-[#F52C11]/30";
    case "warning":
      return "border-amber-200";
    default:
      return "border-blue-200";
  }
}
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.25s ease;
}
.toast-enter-from {
  opacity: 0;
  transform: translateY(-12px) scale(0.97);
}
.toast-leave-to {
  opacity: 0;
  transform: translateY(-8px) scale(0.97);
}
.toast-leave-active {
  position: absolute;
}
</style>
