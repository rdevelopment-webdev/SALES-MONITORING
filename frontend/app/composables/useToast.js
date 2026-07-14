import { ref } from "vue";

// Module-level state so every component sharing this composable
// reads/writes the same toast queue (singleton pattern).
const toasts = ref([]);
let nextId = 1;

const DEFAULT_DURATION = {
  success: 3500,
  error: 5000,
  info: 3500,
  warning: 4500,
};

function removeToast(id) {
  const index = toasts.value.findIndex((t) => t.id === id);
  if (index > -1) toasts.value.splice(index, 1);
}

function pushToast(type, message, options = {}) {
  const id = nextId++;
  const duration = options.duration ?? DEFAULT_DURATION[type] ?? 3500;

  toasts.value.push({
    id,
    type,
    message,
    duration,
  });

  if (duration > 0) {
    setTimeout(() => removeToast(id), duration);
  }

  return id;
}

export function useToast() {
  return {
    toasts,
    success: (message, options) => pushToast("success", message, options),
    error: (message, options) => pushToast("error", message, options),
    info: (message, options) => pushToast("info", message, options),
    warning: (message, options) => pushToast("warning", message, options),
    remove: removeToast,
  };
}
