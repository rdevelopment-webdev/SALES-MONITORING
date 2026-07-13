import { ref } from "vue";

const STORAGE_KEY = "audit_logs";

// Module-level singleton — every component that calls useAuditLog() shares
// the SAME reactive array, so logging an action from anywhere in the app
// instantly shows up on the Audit Logs page.
const logs = ref(loadLogs());

function loadLogs() {
  if (typeof window === "undefined") return [];
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    return raw ? JSON.parse(raw) : [];
  } catch (e) {
    console.error("Failed to load audit logs from storage", e);
    return [];
  }
}

function persist() {
  if (typeof window === "undefined") return;
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(logs.value));
  } catch (e) {
    console.error("Failed to persist audit logs", e);
  }
}

function formatNow() {
  const now = new Date();
  const date = `${String(now.getMonth() + 1).padStart(2, "0")}/${String(
    now.getDate()
  ).padStart(2, "0")}/${String(now.getFullYear()).slice(-2)}`;
  let hour = now.getHours();
  const minute = String(now.getMinutes()).padStart(2, "0");
  const ampm = hour < 12 ? "AM" : "PM";
  hour = hour % 12 === 0 ? 12 : hour % 12;
  const time = `${hour}:${minute} ${ampm}`;
  return { date, time };
}

/**
 * Reads the logged-in user out of localStorage (key "user"), matching
 * how this app actually stores the session — confirmed via devtools to
 * look like { full_name: "Super Admin", email: "...", role: ... }.
 * ADJUST THIS if your "user" object's role field is shaped differently.
 */
function getCurrentUser() {
  if (typeof window === "undefined")
    return { user: "Unknown user", role: "Unknown" };
  try {
    const raw = localStorage.getItem("user");
    if (!raw) return { user: "Unknown user", role: "Unknown" };

    const parsed = JSON.parse(raw);
    return {
      user: parsed?.full_name || parsed?.name || "Unknown user",
      role: parsed?.role?.role_name || parsed?.role || "Unknown",
    };
  } catch (e) {
    console.error("Failed to read current user from localStorage", e);
    return { user: "Unknown user", role: "Unknown" };
  }
}

/**
 * Call this the moment a real action happens anywhere in the app —
 * e.g. inside the "save" handler of your User Management, Industry,
 * PIP, or Sales Task pages. user/role are auto-filled from the auth
 * cookie, so you normally only need to pass module + description:
 *
 *   import { useAuditLog } from '~/composables/useAuditLog'
 *   const { logAuditAction } = useAuditLog()
 *
 *   logAuditAction({
 *     module: 'User Management',     // must match one of moduleOptions
 *     description: `Created new user account for ${newUser.name}`,
 *   })
 *
 * You can still override user/role explicitly if you already have them
 * on hand, e.g. logAuditAction({ user, role, module, description }).
 */
function logAuditAction({ user, role, module, description }) {
  const current = getCurrentUser();
  const { date, time } = formatNow();
  logs.value.unshift({
    id: `${Date.now()}-${Math.random().toString(36).slice(2, 8)}`,
    date,
    time,
    user: user || current.user,
    role: role || current.role,
    module,
    description,
  });
  persist();
}

function clearAuditLogs() {
  logs.value = [];
  persist();
}

export function useAuditLog() {
  return { logs, logAuditAction, clearAuditLogs };
}
