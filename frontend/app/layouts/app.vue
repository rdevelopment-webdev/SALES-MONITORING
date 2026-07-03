<template>
  <div class="flex h-screen overflow-hidden bg-[#f4f6fa]">
    <aside
      class="flex h-screen w-64 shrink-0 flex-col bg-[#1f2835] text-white font-overpass select-none"
    >
      <div class="shrink-0 p-4 flex items-center gap-3">
        <img
          src="/Rweb logo.png"
          alt="RWEB Solutions Logo"
          class="h-10 w-10 rounded bg-white object-contain p-0.5"
        />
        <div>
          <h2 class="text-xs font-bold uppercase tracking-wider leading-tight">
            RWEB SOLUTIONS INC.
          </h2>
          <p class="mt-0.5 text-[10px] font-medium tracking-wide text-gray-400">
            Sales & Marketing MS
          </p>
        </div>
      </div>

      <nav class="flex-1 overflow-y-auto px-3 py-2">
        <div class="mb-5">
          <span
            class="mb-2 block px-3 text-[10px] font-bold uppercase tracking-widest text-gray-500"
          >
            My Modules
          </span>

          <ul class="space-y-0.5">
            <li>
              <button
                type="button"
                @click="goTo('/users')"
                :class="[
                  'flex w-full items-center gap-3 rounded px-3 py-2 text-sm transition-colors',
                  isUserManagementActive
                    ? 'bg-[#f52c11]/20 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white',
                ]"
              >
                <svg
                  class="h-4 w-4"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                  />
                </svg>
                <span class="font-medium">User Management</span>
              </button>
            </li>

            <li>
              <button
                type="button"
                @click="toggleLeadsTracker"
                :class="[
                  'flex w-full items-center justify-between rounded px-3 py-2 text-sm transition-colors',
                  isLeadTrackerActive
                    ? 'bg-[#f52c11]/20 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white',
                ]"
              >
                <span class="flex items-center gap-3">
                  <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                  </svg>
                  <span class="font-medium">Leads Tracker</span>
                </span>
                <svg
                  :class="isLeadsTrackerOpen ? 'rotate-180' : ''"
                  class="h-3.5 w-3.5 transition-transform duration-200"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M5 15l7-7 7 7" />
                </svg>
              </button>

              <ul v-show="isLeadsTrackerOpen" class="mt-0.5 space-y-0">
                <li>
                  <button
                    type="button"
                    @click="goTo('/lead-tracker')"
                    :class="[
                      'ml-7 flex w-[calc(100%-1.75rem)] items-center justify-between rounded px-3 py-1.5 text-xs transition-colors',
                      route.path === '/lead-tracker'
                        ? 'bg-[#f52c11]/20 text-white'
                        : 'text-gray-400 hover:bg-white/5 hover:text-white',
                    ]"
                  >
                    <span class="font-medium">Leads</span>
                  </button>
                </li>

                <li>
                  <button
                    type="button"
                    @click="goTo('/lead-tracker/create')"
                    :class="[
                      'ml-12 flex w-[calc(100%-3rem)] items-center rounded px-3 py-1.5 text-xs transition-colors',
                      route.path === '/lead-tracker/create'
                        ? 'bg-[#f52c11]/20 text-white'
                        : 'text-gray-400 hover:bg-white/5 hover:text-white',
                    ]"
                  >
                    Industry
                  </button>
                </li>

                <li>
                  <button
                    type="button"
                    @click="goTo('/PIP')"
                    :class="[
                      'ml-7 block w-[calc(100%-1.75rem)] rounded px-3 py-1.5 text-left text-xs leading-snug transition-colors',
                      isPipActive
                        ? 'bg-[#f52c11]/20 text-white'
                        : 'text-gray-400 hover:bg-white/5 hover:text-white',
                    ]"
                  >
                    Performance Improvement Plan
                  </button>
                </li>
              </ul>
            </li>

            <li>
              <button
                type="button"
                @click="goTo('/sales')"
                :class="[
                  'flex w-full items-center gap-3 rounded px-3 py-2 text-sm transition-colors',
                  isSalesTaskActive
                    ? 'bg-[#f52c11]/20 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white',
                ]"
              >
                <svg
                  class="h-4 w-4"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <span>Sales Task</span>
              </button>
            </li>
          </ul>
        </div>

        <div>
          <span
            class="mb-2 block px-3 text-[10px] font-bold uppercase tracking-widest text-gray-500"
          >
            Others
          </span>
          <ul class="space-y-0.5">
            <li>
              <button
                type="button"
                @click="goTo('/audit-logs')"
                :class="[
                  'flex w-full items-center gap-3 rounded px-3 py-2 text-sm transition-colors',
                  isAuditLogsActive
                    ? 'bg-[#f52c11]/20 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white',
                ]"
              >
                <svg
                  class="h-4 w-4"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                  />
                </svg>
                <span>Audit Logs</span>
              </button>
            </li>
          </ul>
        </div>
      </nav>

      <div
        ref="adminFooter"
        @click.stop="isAdminMenuOpen = !isAdminMenuOpen"
        class="shrink-0 relative flex cursor-pointer items-center gap-3 border-t border-white/10 px-4 py-3 transition-colors hover:bg-white/5"
      >
        <div
          class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-xs font-bold text-[#CC3300]"
        >
          {{ userInitials }}
        </div>
        <div class="min-w-0">
          <p class="truncate text-[13px] font-medium text-white">
            {{ profileUser.full_name }}
          </p>
          <p class="truncate text-[10px] text-gray-400">
            {{ profileUser.email }}
          </p>
        </div>

        <ul
          v-show="isAdminMenuOpen"
          class="absolute bottom-full left-3 z-50 mb-2 w-56 rounded-lg border border-[#2d3748] bg-[#1F2835] py-1 shadow-xl"
        >
          <li>
            <a
              href="#"
              class="block px-4 py-2 text-sm text-gray-300 transition-colors hover:bg-white/10 hover:text-white"
              @click.prevent="openProfileModal"
            >
              Profile
            </a>
          </li>
          <li>
            <a
              href="#"
              class="block px-4 py-2 text-sm text-gray-300 transition-colors hover:bg-white/10 hover:text-white"
              @click.prevent="openSettingsModal"
            >
              Settings
            </a>
          </li>
          <li class="my-1 border-t border-white/10"></li>
          <li>
            <a
              href="#"
              class="block px-4 py-2 text-sm text-red-400 transition-colors hover:bg-white/10 hover:text-red-300"
              @click.prevent="handleLogout"
            >
              Logout
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <main class="min-w-0 flex-1 overflow-hidden bg-[#f4f6fa]">
      <slot />
    </main>

    <div
      v-if="isProfileModalOpen"
      class="fixed inset-0 z-[60] flex items-center justify-center px-4 py-6"
    >
      <div
        class="absolute inset-0 bg-black/60"
        @click="closeProfileModal"
      ></div>

      <div
        class="relative w-full max-w-md overflow-hidden rounded-2xl border border-white/10 bg-[#1f2835] text-white shadow-2xl"
      >
        <div class="border-b border-white/10 px-6 py-5">
          <p class="text-[11px] uppercase tracking-[0.28em] text-gray-400">
            Profile
          </p>
          <h3 class="mt-2 text-2xl font-semibold">
            {{ profileUser.full_name }}
          </h3>
          <p class="mt-1 text-sm text-gray-300">
            {{ profileUser.role || "No role assigned" }}
          </p>
        </div>

        <div class="px-6 py-6">
          <div class="mb-6 flex items-center gap-4">
            <div
              class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-lg font-bold text-[#CC3300]"
            >
              {{ userInitials }}
            </div>
            <div>
              <p class="text-sm text-gray-400">Signed in as</p>
              <p class="text-lg font-semibold">{{ profileUser.full_name }}</p>
              <p class="text-sm text-gray-300">{{ profileUser.email }}</p>
            </div>
          </div>

          <div class="grid gap-3">
            <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
              <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">
                Full Name
              </p>
              <p class="mt-1 text-sm font-medium">
                {{ profileUser.full_name }}
              </p>
            </div>

            <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
              <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">
                Email
              </p>
              <p class="mt-1 text-sm font-medium">{{ profileUser.email }}</p>
            </div>

            <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
              <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">
                Role
              </p>
              <p class="mt-1 text-sm font-medium">{{ profileUser.role }}</p>
            </div>
          </div>
        </div>

        <div
          class="flex items-center justify-end gap-3 border-t border-white/10 px-6 py-4"
        >
          <button
            type="button"
            @click="closeProfileModal"
            class="rounded-lg border border-white/10 px-4 py-2 text-sm text-gray-200 transition-colors hover:bg-white/10"
          >
            Close
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="isSettingsModalOpen"
      class="fixed inset-0 z-[70] flex items-center justify-center px-4 py-6"
    >
      <div
        class="absolute inset-0 bg-black/60"
        @click="closeSettingsModal"
      ></div>

      <div
        class="relative w-full max-w-md overflow-hidden rounded-2xl border border-white/10 bg-[#1f2835] text-white shadow-2xl"
      >
        <div class="border-b border-white/10 px-6 py-5">
          <p class="text-[11px] uppercase tracking-[0.28em] text-gray-400">
            Settings
          </p>
          <h3 class="mt-2 text-2xl font-semibold">Change Password</h3>
          <p class="mt-1 text-sm text-gray-300">
            Update the password for {{ profileUser.full_name }}
          </p>
        </div>

        <form class="px-6 py-6" @submit.prevent="submitPasswordChange">
          <div
            v-if="settingsMessage"
            class="mb-4 rounded-lg px-4 py-3 text-sm"
            :class="
              settingsMessageType === 'success'
                ? 'border border-emerald-500/20 bg-emerald-500/15 text-emerald-200'
                : 'border border-red-500/20 bg-red-500/15 text-red-200'
            "
          >
            {{ settingsMessage }}
          </div>

          <div
            class="mb-4 rounded-xl border border-white/10 bg-white/5 px-4 py-3"
          >
            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">
              Account
            </p>
            <p class="mt-1 text-sm font-medium">{{ profileUser.full_name }}</p>
            <p class="text-sm text-gray-300">{{ profileUser.email }}</p>
            <p class="mt-1 text-xs text-gray-400">
              Role: {{ profileUser.role || "No role assigned" }}
            </p>
          </div>

          <div class="grid gap-4">
            <label class="block">
              <span class="mb-2 block text-sm font-medium text-gray-200">
                Current Password
              </span>
              <input
                v-model="settingsForm.current_password"
                type="password"
                class="w-full rounded-lg border border-white/10 bg-[#101722] px-4 py-3 text-sm text-white outline-none transition-colors placeholder:text-gray-500 focus:border-[#f52c11]"
                placeholder="Enter current password"
                :disabled="settingsSaving"
              />
            </label>

            <label class="block">
              <span class="mb-2 block text-sm font-medium text-gray-200">
                New Password
              </span>
              <input
                v-model="settingsForm.password"
                type="password"
                class="w-full rounded-lg border border-white/10 bg-[#101722] px-4 py-3 text-sm text-white outline-none transition-colors placeholder:text-gray-500 focus:border-[#f52c11]"
                placeholder="Enter new password"
                :disabled="settingsSaving"
              />
            </label>

            <label class="block">
              <span class="mb-2 block text-sm font-medium text-gray-200">
                Confirm New Password
              </span>
              <input
                v-model="settingsForm.password_confirmation"
                type="password"
                class="w-full rounded-lg border border-white/10 bg-[#101722] px-4 py-3 text-sm text-white outline-none transition-colors placeholder:text-gray-500 focus:border-[#f52c11]"
                placeholder="Confirm new password"
                :disabled="settingsSaving"
              />
            </label>
          </div>

          <div
            class="mt-6 flex items-center justify-end gap-3 border-t border-white/10 pt-4"
          >
            <button
              type="button"
              @click="closeSettingsModal"
              class="rounded-lg border border-white/10 px-4 py-2 text-sm text-gray-200 transition-colors hover:bg-white/10"
              :disabled="settingsSaving"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="rounded-lg bg-[#f52c11] px-4 py-2 text-sm font-semibold text-white transition-colors hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60"
              :disabled="settingsSaving"
            >
              {{ settingsSaving ? "Saving..." : "Save Password" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from "vue";

const route = useRoute();
const { apiFetch } = useApi();

const isLeadsTrackerOpen = ref(false);
const isAdminMenuOpen = ref(false);
const isProfileModalOpen = ref(false);
const isSettingsModalOpen = ref(false);
const settingsSaving = ref(false);
const settingsMessage = ref("");
const settingsMessageType = ref("success");
const settingsForm = ref({
  current_password: "",
  password: "",
  password_confirmation: "",
});
const adminFooter = ref(null);
const profileUser = ref({
  full_name: "Super Admin",
  email: "super@company.com",
  role: "Admin",
  role_id: null,
});

function normalizeUser(rawUser) {
  if (!rawUser || typeof rawUser !== "object") {
    return null;
  }

  const rawRole = rawUser.role || rawUser.Role || null;

  return {
    full_name:
      rawUser.full_name || rawUser.fullName || rawUser.name || "Super Admin",
    email: rawUser.email || "super@company.com",
    role:
      typeof rawRole === "object"
        ? rawRole.role_name || rawRole.name || "Admin"
        : rawUser.role ||
          rawUser.role_name ||
          rawUser.Role?.role_name ||
          rawUser.Role?.name ||
          "Admin",
    role_id: rawUser.role_id ?? rawUser.roleId ?? null,
  };
}

const userInitials = computed(() => {
  const name = profileUser.value.full_name || "User";
  return (
    name
      .split(/\s+/)
      .filter(Boolean)
      .slice(0, 2)
      .map((part) => part[0]?.toUpperCase())
      .join("") || "U"
  );
});

const isUserManagementActive = computed(() => route.path.startsWith("/users"));
const isLeadTrackerActive = computed(
  () => route.path.startsWith("/lead-tracker") || route.path.startsWith("/PIP")
);
const isPipActive = computed(() => route.path.startsWith("/PIP"));
const isSalesTaskActive = computed(() => route.path.startsWith("/sales"));
const isAuditLogsActive = computed(() => route.path.startsWith("/audit-logs"));

watch(
  () => route.path,
  (path) => {
    const inLeadSection =
      path.startsWith("/lead-tracker") || path.startsWith("/PIP");
    isLeadsTrackerOpen.value = inLeadSection;
  },
  { immediate: true }
);

function goTo(path) {
  isAdminMenuOpen.value = false;
  navigateTo(path);
}

function toggleLeadsTracker() {
  isLeadsTrackerOpen.value = !isLeadsTrackerOpen.value;
  if (isLeadsTrackerOpen.value) {
    navigateTo("/lead-tracker");
  }
}

function openProfileModal() {
  isAdminMenuOpen.value = false;
  isProfileModalOpen.value = true;
}

function closeProfileModal() {
  isProfileModalOpen.value = false;
}

function openSettingsModal() {
  isAdminMenuOpen.value = false;
  settingsMessage.value = "";
  settingsForm.value.current_password = "";
  settingsForm.value.password = "";
  settingsForm.value.password_confirmation = "";
  isSettingsModalOpen.value = true;
}

function closeSettingsModal() {
  isSettingsModalOpen.value = false;
  settingsMessage.value = "";
}

async function submitPasswordChange() {
  settingsSaving.value = true;
  settingsMessage.value = "";

  try {
    if (
      !settingsForm.value.current_password ||
      !settingsForm.value.password ||
      !settingsForm.value.password_confirmation
    ) {
      throw new Error("Please fill in all password fields.");
    }

    if (
      settingsForm.value.password !== settingsForm.value.password_confirmation
    ) {
      throw new Error("New password and confirmation do not match.");
    }

    const response = await apiFetch("/change-password", {
      method: "POST",
      body: {
        current_password: settingsForm.value.current_password,
        password: settingsForm.value.password,
        password_confirmation: settingsForm.value.password_confirmation,
      },
    });

    settingsMessageType.value = "success";
    settingsMessage.value =
      response?.message || "Password updated successfully.";
    settingsForm.value.current_password = "";
    settingsForm.value.password = "";
    settingsForm.value.password_confirmation = "";
  } catch (err) {
    settingsMessageType.value = "error";
    settingsMessage.value =
      err?.data?.message ||
      err?.message ||
      "Unable to update password. Please try again.";
  } finally {
    settingsSaving.value = false;
  }
}

async function handleLogout() {
  isAdminMenuOpen.value = false;
  localStorage.removeItem("token");
  localStorage.removeItem("user");
  await navigateTo("/login");
}

function handleClickOutside(event) {
  if (adminFooter.value && !adminFooter.value.contains(event.target)) {
    isAdminMenuOpen.value = false;
  }
}

onMounted(() => {
  try {
    const storedUser = JSON.parse(localStorage.getItem("user") || "null");
    const normalizedUser = normalizeUser(storedUser);

    if (normalizedUser) {
      profileUser.value = normalizedUser;
    }
  } catch {
    // Keep fallback profile values when storage is unavailable or malformed.
  }

  apiFetch("/me")
    .then((response) => {
      const apiUser = response?.data?.user || response?.user;
      const normalizedUser = normalizeUser(apiUser);

      if (normalizedUser) {
        profileUser.value = normalizedUser;
        localStorage.setItem("user", JSON.stringify(normalizedUser));
      }
    })
    .catch(() => {
      // Keep the cached user if the profile request fails.
    });

  document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>
