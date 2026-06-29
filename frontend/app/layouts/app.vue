<template>
  <aside
    class="w-64 h-screen bg-[#1f2835] text-white flex flex-col font-overpass select-none"
  >
    <!-- Header -->
    <div class="p-4 flex items-center gap-3 shrink-0">
      <img
        src="/Rweb logo.png"
        alt="RWEB Solutions Logo"
        class="w-10 h-10 object-contain rounded bg-white p-0.5"
      />
      <div>
        <h2
          class="text-white text-xs font-bold tracking-wider uppercase leading-tight"
        >
          RWEB SOLUTIONS INC.
        </h2>
        <p class="text-[10px] text-gray-400 font-medium tracking-wide mt-0.5">
          Sales & Marketing MS
        </p>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-2 px-3">
      <!-- My Modules -->
      <div class="mb-5">
        <span
          class="px-3 text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2"
          >My Modules</span
        >
        <ul class="space-y-0.5">
          <!-- User Management -->
          <li>
            <div
              @click="toggleUserManagement"
              :class="
                activeItem === 'user-management'
                  ? 'bg-[#f52c11]/20 text-white'
                  : 'text-gray-300 hover:text-white hover:bg-white/5'
              "
              class="flex items-center justify-between px-3 py-2 rounded text-sm cursor-pointer transition-colors"
            >
              <div class="flex items-center gap-3">
                <svg
                  class="w-4 h-4"
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
              </div>
              <svg
                :class="isUserManagementOpen ? 'rotate-180' : ''"
                class="w-3.5 h-3.5 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path d="M5 15l7-7 7 7" />
              </svg>
            </div>

            <!-- User Management Sub-menu -->
            <ul v-show="isUserManagementOpen" class="mt-0.5 space-y-0">
              <li>
                <a
                  href="#"
                  @click.prevent="activeItem = 'users'"
                  :class="
                    activeItem === 'users'
                      ? 'bg-[#f52c11]/20 text-white'
                      : 'text-gray-400 hover:text-white hover:bg-white/5'
                  "
                  class="block px-3 py-1.5 rounded text-xs transition-colors ml-7"
                >
                  Users
                </a>
              </li>
              <li>
                <a
                  href="#"
                  @click.prevent="activeItem = 'roles'"
                  :class="
                    activeItem === 'roles'
                      ? 'bg-[#f52c11]/20 text-white'
                      : 'text-gray-400 hover:text-white hover:bg-white/5'
                  "
                  class="block px-3 py-1.5 rounded text-xs transition-colors ml-7"
                >
                  Roles
                </a>
              </li>
              <li>
                <a
                  href="#"
                  @click.prevent="activeItem = 'permissions'"
                  :class="
                    activeItem === 'permissions'
                      ? 'bg-[#f52c11]/20 text-white'
                      : 'text-gray-400 hover:text-white hover:bg-white/5'
                  "
                  class="block px-3 py-1.5 rounded text-xs transition-colors ml-7"
                >
                  Permissions
                </a>
              </li>
            </ul>
          </li>

          <!-- Leads Tracker -->
          <li>
            <div
              @click="toggleLeadsTracker"
              :class="
                activeItem === 'leads-tracker'
                  ? 'bg-[#f52c11]/20 text-white'
                  : 'text-gray-300 hover:text-white hover:bg-white/5'
              "
              class="flex items-center justify-between px-3 py-2 rounded text-sm cursor-pointer transition-colors"
            >
              <div class="flex items-center gap-3">
                <svg
                  class="w-4 h-4"
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
              </div>
              <svg
                :class="isLeadsTrackerOpen ? 'rotate-180' : ''"
                class="w-3.5 h-3.5 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path d="M5 15l7-7 7 7" />
              </svg>
            </div>

            <!-- Leads Tracker Sub-menu -->
            <ul v-show="isLeadsTrackerOpen" class="mt-0.5 space-y-0">
              <!-- Leads (nested toggle) -->
              <li>
                <div
                  @click="
                    isLeadsOpen = !isLeadsOpen;
                    activeItem = 'leads';
                  "
                  :class="
                    activeItem === 'leads'
                      ? 'bg-[#f52c11]/20 text-white'
                      : 'text-gray-400 hover:text-white hover:bg-white/5'
                  "
                  class="flex items-center justify-between px-3 py-1.5 rounded text-xs cursor-pointer transition-colors ml-7"
                >
                  <span>Leads</span>
                  <svg
                    :class="isLeadsOpen ? 'rotate-180' : ''"
                    class="w-3 h-3 transition-transform duration-200"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path d="M5 15l7-7 7 7" />
                  </svg>
                </div>

                <!-- Leads Sub-menu (Industry) -->
                <ul v-show="isLeadsOpen" class="mt-0 space-y-0">
                  <li>
                    <a
                      href="#"
                      @click.prevent="activeItem = 'industry'"
                      :class="
                        activeItem === 'industry'
                          ? 'bg-[#f52c11]/20 text-white'
                          : 'text-gray-400 hover:text-white hover:bg-white/5'
                      "
                      class="block px-3 py-1.5 rounded text-xs transition-colors ml-12"
                    >
                      Industry
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Performance Improvement Plan -->
              <li>
                <a
                  href="#"
                  @click.prevent="activeItem = 'performance-improvement'"
                  :class="
                    activeItem === 'performance-improvement'
                      ? 'bg-[#f52c11]/20 text-white'
                      : 'text-gray-400 hover:text-white hover:bg-white/5'
                  "
                  class="block px-3 py-1.5 rounded text-xs transition-colors ml-7 leading-snug"
                >
                  Performance Improvement Plan
                </a>
              </li>
            </ul>
          </li>

          <!-- Sales Task -->
          <li>
            <a
              href="#"
              @click.prevent="activeItem = 'sales-task'"
              :class="
                activeItem === 'sales-task'
                  ? 'bg-[#f52c11]/20 text-white'
                  : 'text-gray-300 hover:text-white hover:bg-white/5'
              "
              class="flex items-center gap-3 px-3 py-2 rounded text-sm transition-colors"
            >
              <svg
                class="w-4 h-4"
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
            </a>
          </li>
        </ul>
      </div>

      <!-- Others -->
      <div>
        <span
          class="px-3 text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2"
          >Others</span
        >
        <ul class="space-y-0.5">
          <li>
            <a
              href="#"
              @click.prevent="activeItem = 'audit-logs'"
              :class="
                activeItem === 'audit-logs'
                  ? 'bg-[#f52c11]/20 text-white'
                  : 'text-gray-300 hover:text-white hover:bg-white/5'
              "
              class="flex items-center gap-3 px-3 py-2 rounded text-sm transition-colors"
            >
              <svg
                class="w-4 h-4"
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
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Admin Account Footer -->
    <div
      ref="adminFooter"
      @click.stop="isAdminMenuOpen = !isAdminMenuOpen"
      class="px-4 py-3 border-t border-white/10 flex items-center gap-3 cursor-pointer hover:bg-white/5 transition-colors relative shrink-0"
    >
      <div
        class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[#CC3300] font-bold text-xs shrink-0"
      >
        {{ userInitials }}
      </div>
      <div class="min-w-0">
        <p class="text-white text-[13px] font-medium truncate">{{ userDisplayName }}</p>
        <p class="text-[10px] text-gray-400 truncate">{{ userEmail }}</p>
      </div>

      <!-- Dropdown Menu -->
      <ul
        v-show="isAdminMenuOpen"
        class="absolute bottom-full left-3 mb-2 w-56 bg-[#1F2835] border border-[#2d3748] rounded-lg shadow-xl py-1 z-50"
      >
        <li>
          <a
            href="#"
            @click.prevent.stop="openProfile"
            class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors"
          >
            Profile
          </a>
        </li>
        <li>
          <a
            href="#"
            @click.prevent.stop="openSettings"
            class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors"
          >
            Settings
          </a>
        </li>
        <li class="border-t border-white/10 my-1"></li>
        <li>
          <a
            href="#"
            @click.prevent.stop="handleLogout"
            class="block px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-white/10 transition-colors"
          >
            Logout
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <div
    v-if="isProfileOpen"
    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 px-4"
    @click.self="isProfileOpen = false"
  >
    <section
      class="w-full max-w-sm rounded-lg border border-gray-200 bg-white shadow-xl"
    >
      <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
        <h2 class="text-base font-bold text-[#1f2835]">Profile</h2>
        <button
          type="button"
          class="text-2xl leading-none text-gray-400 hover:text-gray-700"
          @click="isProfileOpen = false"
          aria-label="Close profile"
        >
          &times;
        </button>
      </div>

      <div class="px-5 py-5">
        <div class="flex items-center gap-4">
          <div
            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#1f2835] text-lg font-bold text-white"
          >
            {{ userInitials }}
          </div>
          <div class="min-w-0">
            <p class="truncate text-lg font-bold text-[#1f2835]">{{ userDisplayName }}</p>
            <p class="truncate text-sm text-gray-500">{{ userEmail }}</p>
          </div>
        </div>

        <dl class="mt-5 space-y-3 text-sm">
          <div class="flex justify-between gap-4 border-t border-gray-100 pt-3">
            <dt class="font-semibold text-gray-500">Role</dt>
            <dd class="text-right text-[#1f2835]">{{ userRole }}</dd>
          </div>
          <div class="flex justify-between gap-4 border-t border-gray-100 pt-3">
            <dt class="font-semibold text-gray-500">Email</dt>
            <dd class="truncate text-right text-[#1f2835]">{{ userEmail }}</dd>
          </div>
        </dl>
      </div>
    </section>
  </div>

  <div
    v-if="isSettingsOpen"
    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 px-4 py-6 text-[#1f2835]"
    @click.self="isSettingsOpen = false"
  >
    <section class="flex h-[620px] max-h-[90vh] w-full max-w-5xl overflow-hidden rounded-lg bg-white shadow-2xl">
      <aside class="w-[270px] shrink-0 border-r border-gray-200 bg-white px-6 py-6">
        <div class="mb-5 flex items-center justify-between">
          <h2 class="text-lg font-bold text-black">Settings</h2>
          <button
            type="button"
            class="text-2xl leading-none text-gray-400 hover:text-gray-700"
            @click="isSettingsOpen = false"
            aria-label="Close settings"
          >
            &times;
          </button>
        </div>

        <nav class="space-y-2">
          <button
            type="button"
            @click="settingsTab = 'profile'"
            :class="settingsTab === 'profile' ? 'bg-[#fff3d6] text-black' : 'text-black hover:bg-gray-50'"
            class="block w-full rounded-lg px-5 py-3 text-left text-[18px] font-semibold transition-colors"
          >
            Profile
          </button>
          <button
            type="button"
            @click="settingsTab = 'security'"
            :class="settingsTab === 'security' ? 'bg-[#fff3d6] text-black' : 'text-black hover:bg-gray-50'"
            class="block w-full rounded-lg px-5 py-3 text-left text-[18px] font-semibold transition-colors"
          >
            Security
          </button>
        </nav>
      </aside>

      <main class="flex-1 overflow-y-auto px-12 py-8">
        <section v-if="settingsTab === 'profile'" class="max-w-[805px]">
          <h1 class="text-[24px] font-semibold leading-tight text-black">Profile information</h1>
          <p class="mt-2 text-[18px] text-[#587163]">Update your name and email address</p>

          <form class="mt-8 space-y-7" @submit.prevent="saveSettingsProfile">
            <div>
              <label for="settings-name" class="block text-[18px] font-semibold text-black">Name</label>
              <input
                id="settings-name"
                v-model="settingsName"
                type="text"
                class="mt-4 h-[52px] w-full rounded-[10px] border border-[#dbe8df] bg-white px-4 text-[18px] text-black shadow-sm outline-none focus:border-[#F59E0B] focus:ring-2 focus:ring-[#F59E0B]/20"
              />
            </div>

            <div>
              <label for="settings-email" class="block text-[18px] font-semibold text-black">Email address</label>
              <input
                id="settings-email"
                v-model="settingsEmail"
                type="email"
                class="mt-4 h-[52px] w-full rounded-[10px] border border-[#dbe8df] bg-white px-4 text-[18px] text-black shadow-sm outline-none focus:border-[#F59E0B] focus:ring-2 focus:ring-[#F59E0B]/20"
              />
            </div>

            <div class="flex items-center gap-4 pt-1">
              <button
                type="submit"
                class="rounded-[10px] bg-[#F59E0B] px-6 py-3 text-[18px] font-bold text-white transition-colors hover:bg-[#EA7A11]"
              >
                Save
              </button>
              <span v-if="settingsSavedMessage" class="text-sm font-medium text-[#EA7A11]">{{ settingsSavedMessage }}</span>
            </div>
          </form>
        </section>
        <section v-else class="max-w-[805px]">
          <h1 class="text-[24px] font-semibold leading-tight text-black">Security</h1>
          <p class="mt-2 text-[18px] text-[#587163]">Update your password</p>

          <form class="mt-8 space-y-7" @submit.prevent="saveSecuritySettings">
            <div>
              <label for="current-password" class="block text-[18px] font-semibold text-black">Current password</label>
              <input
                id="current-password"
                v-model="currentPassword"
                type="password"
                autocomplete="current-password"
                class="mt-4 h-[52px] w-full rounded-[10px] border border-[#dbe8df] bg-white px-4 text-[18px] text-black shadow-sm outline-none focus:border-[#F59E0B] focus:ring-2 focus:ring-[#F59E0B]/20"
              />
            </div>

            <div>
              <label for="new-password" class="block text-[18px] font-semibold text-black">New password</label>
              <input
                id="new-password"
                v-model="newPassword"
                type="password"
                autocomplete="new-password"
                class="mt-4 h-[52px] w-full rounded-[10px] border border-[#dbe8df] bg-white px-4 text-[18px] text-black shadow-sm outline-none focus:border-[#F59E0B] focus:ring-2 focus:ring-[#F59E0B]/20"
              />
            </div>

            <div>
              <label for="confirm-password" class="block text-[18px] font-semibold text-black">Confirm password</label>
              <input
                id="confirm-password"
                v-model="confirmPassword"
                type="password"
                autocomplete="new-password"
                class="mt-4 h-[52px] w-full rounded-[10px] border border-[#dbe8df] bg-white px-4 text-[18px] text-black shadow-sm outline-none focus:border-[#F59E0B] focus:ring-2 focus:ring-[#F59E0B]/20"
              />
            </div>

            <div class="flex items-center gap-4 pt-1">
              <button
                type="submit"
                class="rounded-[10px] bg-[#F59E0B] px-6 py-3 text-[18px] font-bold text-white transition-colors hover:bg-[#EA7A11]"
              >
                Save password
              </button>
              <span
                v-if="securityMessage"
                :class="securityMessageType === 'error' ? 'text-red-600' : 'text-[#EA7A11]'"
                class="text-sm font-medium"
              >
                {{ securityMessage }}
              </span>
            </div>
          </form>
        </section>
      </main>
    </section>
  </div>
</template>

<script setup>
import { computed, ref, onMounted, onUnmounted } from "vue";

const isUserManagementOpen = ref(false);
const isLeadsTrackerOpen = ref(false);
const isLeadsOpen = ref(false);
const isAdminMenuOpen = ref(false);
const isProfileOpen = ref(false);
const isSettingsOpen = ref(false);
const settingsTab = ref("profile");
const settingsName = ref("");
const settingsEmail = ref("");
const settingsSavedMessage = ref("");
const currentPassword = ref("");
const newPassword = ref("");
const confirmPassword = ref("");
const securityMessage = ref("");
const securityMessageType = ref("success");
const activeItem = ref("user-management");
const adminFooter = ref(null);
const currentUser = ref({});

const userDisplayName = computed(() => {
  const user = currentUser.value || {};
  const firstName = user.first_name || user.firstName || "";
  const lastName = user.last_name || user.lastName || "";
  const combinedName = `${firstName} ${lastName}`.trim();

  return (
    user.fullName ||
    user.full_name ||
    user.name ||
    combinedName ||
    "User"
  );
});

const userEmail = computed(() => currentUser.value?.email || "No email saved");
const userRole = computed(() => currentUser.value?.role || currentUser.value?.role_name || "User");
const userInitials = computed(() => {
  const nameParts = userDisplayName.value.split(" ").filter(Boolean);

  if (nameParts.length >= 2) {
    return `${nameParts[0][0]}${nameParts[1][0]}`.toUpperCase();
  }

  return userDisplayName.value.slice(0, 2).toUpperCase();
});

function loadCurrentUser() {
  try {
    currentUser.value = JSON.parse(localStorage.getItem("user") || "{}");
  } catch (error) {
    currentUser.value = {};
  }
}

function openProfile() {
  loadCurrentUser();
  isProfileOpen.value = true;
  isAdminMenuOpen.value = false;
}
function resetSecurityForm() {
  currentPassword.value = "";
  newPassword.value = "";
  confirmPassword.value = "";
  securityMessage.value = "";
  securityMessageType.value = "success";
}

function syncSettingsForm() {
  settingsName.value = userDisplayName.value === "User" ? "" : userDisplayName.value;
  settingsEmail.value = userEmail.value === "No email saved" ? "" : userEmail.value;
  settingsSavedMessage.value = "";
}

function openSettings() {
  loadCurrentUser();
  syncSettingsForm();
  settingsTab.value = "profile";
  resetSecurityForm();
  isSettingsOpen.value = true;
  isAdminMenuOpen.value = false;
}

function saveSettingsProfile() {
  const updatedUser = {
    ...(currentUser.value || {}),
    name: settingsName.value.trim(),
    email: settingsEmail.value.trim(),
  };

  currentUser.value = updatedUser;
  localStorage.setItem("user", JSON.stringify(updatedUser));
  settingsSavedMessage.value = "Saved";
}

async function saveSecuritySettings() {
  securityMessage.value = "";

  if (!currentPassword.value || !newPassword.value || !confirmPassword.value) {
    securityMessage.value = "Fill in all password fields.";
    securityMessageType.value = "error";
    return;
  }

  if (newPassword.value.length < 8) {
    securityMessage.value = "New password must be at least 8 characters.";
    securityMessageType.value = "error";
    return;
  }

  if (newPassword.value !== confirmPassword.value) {
    securityMessage.value = "New passwords do not match.";
    securityMessageType.value = "error";
    return;
  }

  const config = useRuntimeConfig();
  const token = localStorage.getItem("token");

  try {
    await $fetch(`${config.public.apiBase}/user/password`, {
      method: "PUT",
      headers: {
        Authorization: token ? `Bearer ${token}` : "",
        Accept: "application/json",
      },
      body: {
        current_password: currentPassword.value,
        password: newPassword.value,
        password_confirmation: confirmPassword.value,
      },
    });

    resetSecurityForm();
    securityMessage.value = "Password updated.";
    securityMessageType.value = "success";
  } catch (error) {
    securityMessage.value =
      error.data?.message ||
      "Password update endpoint is not ready yet.";
    securityMessageType.value = "error";
  }
}

function toggleUserManagement() {
  isUserManagementOpen.value = !isUserManagementOpen.value;
  activeItem.value = "user-management";
}

function toggleLeadsTracker() {
  isLeadsTrackerOpen.value = !isLeadsTrackerOpen.value;
  if (!isLeadsTrackerOpen.value) {
    isLeadsOpen.value = false;
  }
  activeItem.value = "leads-tracker";
}

function handleClickOutside(event) {
  if (adminFooter.value && !adminFooter.value.contains(event.target)) {
    isAdminMenuOpen.value = false;
  }
}

async function handleLogout() {
  const config = useRuntimeConfig();
  const token = localStorage.getItem("token");

  try {
    if (token) {
      await $fetch(`${config.public.apiBase}/logout`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
      });
    }
  } catch (error) {
    console.warn("Logout request failed, clearing local session instead.", error);
  } finally {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    isAdminMenuOpen.value = false;
    isSettingsOpen.value = false;
    await navigateTo("/login");
  }
}
onMounted(() => {
  loadCurrentUser();
  document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>
