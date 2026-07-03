<template>
  <div
    class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-white font-['Arimo'] text-[14px] text-black"
  >
    <!-- Top Header -->
    <header
      class="bg-white border-b border-gray-300 px-4 py-2 flex items-center justify-between shrink-0"
    >
      <span class="font-medium tracking-wide">User Management</span>
      <div class="flex items-center gap-3">
        <button
          class="text-gray-600 hover:text-black transition-colors relative"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
          />
        </button>
        <button class="text-gray-600 hover:text-black transition-colors">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
          />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
          />
        </button>
        <div
          class="flex items-center gap-2 pl-2 border-l border-gray-300"
        ></div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col p-4 min-h-0">
      <div class="max-w-6xl mx-auto w-full flex-1 flex flex-col min-h-0">
        <!-- Title & Controls -->
        <div class="flex items-center justify-between mb-3 shrink-0">
          <div class="flex items-center gap-2">
            <svg
              class="w-5 h-5 text-gray-800"
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
          </div>

          <button
            @click="openAddModal"
            class="bg-[#f52c11] hover:bg-[#e5630e] active:bg-[#cc570d] text-white px-4 py-1.5 rounded-[4px] font-medium text-[13px] transition-colors"
          >
            Add User
          </button>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="flex-1 flex items-center justify-center">
          <div
            class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#f52c11]"
          ></div>
          <span class="ml-2 text-gray-500">Loading users...</span>
        </div>

        <!-- Error -->
        <div
          v-else-if="error"
          class="flex-1 flex flex-col items-center justify-center text-red-600 gap-2"
        >
          <svg
            class="w-8 h-8"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <p>{{ error }}</p>
          <button
            @click="refreshData"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-[13px]"
          >
            Retry
          </button>
        </div>

        <!-- Users Table -->
        <div
          v-else
          class="flex-1 bg-white border border-gray-300 overflow-auto custom-scroll min-h-0"
        >
          <table class="min-w-full border-collapse text-left">
            <thead class="bg-[#f2f2f2] sticky top-0 z-20">
              <tr>
                <th
                  class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap"
                >
                  Full Name
                </th>
                <th
                  class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap"
                >
                  Email
                </th>
                <th
                  class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap"
                >
                  Role
                </th>
                <th
                  class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap text-center sticky right-0 bg-[#f2f2f2] z-30 shadow-[-2px_0_4px_rgba(0,0,0,0.1)]"
                >
                  Action
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="user in users"
                :key="user.id"
                class="bg-white hover:bg-[#f52c11]/15 transition-colors"
              >
                <td
                  class="px-3 py-2 border-b border-gray-300 whitespace-nowrap"
                >
                  {{ user.fullName }}
                </td>
                <td
                  class="px-3 py-2 border-b border-gray-300 whitespace-nowrap text-black-700 hover:underline cursor-pointer"
                >
                  {{ user.email }}
                </td>
                <td
                  class="px-3 py-2 border-b border-gray-300 whitespace-nowrap"
                >
                  <span
                    class="px-2 py-0.5 rounded-[4px] text-[12px] font-medium"
                    >{{ user.role_name }}</span
                  >
                </td>
                <td
                  class="px-3 py-2 border-b border-gray-300 whitespace-nowrap sticky right-0 bg-white"
                >
                  <div class="flex items-center justify-center gap-3">
                    <button
                      @click="openEditModal(user)"
                      class="text-gray-600 hover:text-blue-700 transition-colors"
                      title="Edit"
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
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                      </svg>
                    </button>
                    <button
                      @click="deleteUser(user.id)"
                      class="text-gray-600 hover:text-red-700 transition-colors"
                      title="Delete"
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
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="users.length === 0">
                <td
                  colspan="4"
                  class="px-4 py-8 text-center text-gray-500 border-b border-gray-300"
                >
                  No users found. Click "Add User" to create one.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Footer -->
        <div
          class="shrink-0 px-1 py-1.5 text-[12px] text-gray-500 border-t border-gray-300 bg-white"
        >
          <span
            >Showing {{ users.length }} user{{
              users.length !== 1 ? "s" : ""
            }}</span
          >
        </div>
      </div>
    </main>

    <!-- Add/Edit Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 m-4">
        <h2 class="text-lg font-bold mb-4">
          {{ editingUser ? "Edit User" : "Add User" }}
        </h2>
        <div class="space-y-3">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Full Name *</label
            >
            <input
              v-model="form.fullName"
              type="text"
              placeholder="John Doe"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-[#f52c11]"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Email *</label
            >
            <input
              v-model="form.email"
              type="email"
              placeholder="john@example.com"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-[#f52c11]"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Role *</label
            >
            <select
              v-model="form.role_name"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-[#f52c11]"
            ></select>
          </div>
        </div>
        <div class="flex justify-end gap-2 mt-6">
          <button
            @click="closeModal"
            class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50 transition-colors"
          >
            Cancel
          </button>
          <button
            @click="saveUser"
            :disabled="saving"
            class="px-4 py-2 bg-[#f52c11] text-white rounded hover:bg-[#e5630e] transition-colors disabled:opacity-50"
          >
            {{
              saving ? "Saving..." : (editingUser ? "Update" : "Add") + " User"
            }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

// ─── Config ───
const API_URL = "http://localhost:8000/api/users";

// ─── State ───
const users = ref([]);
const loading = ref(true);
const error = ref(null);
const showModal = ref(false);
const editingUser = ref(null);
const saving = ref(false);
const currentUser = ref(null);

const form = ref({
  fullName: "",
  email: "",
  role_name: "",
});

// ─── Helpers ───
function formatDate(dateStr) {
  if (!dateStr) return "";
  const date = new Date(dateStr);
  if (isNaN(date)) return dateStr;
  return date.toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
}

function mapUser(dbUser) {
  let roleName = "User"; // Default value

  // Handle if role_name is an object with role_name property
  if (dbUser.role_name) {
    if (typeof dbUser.role_name === "object" && dbUser.role_name.role_name) {
      roleName = dbUser.role_name.role_name; // ← Extract from nested object
    } else if (typeof dbUser.role_name === "string") {
      roleName = dbUser.role_name; // ← Use as-is if string
    }
  }
  // Handle if role is an object with name/role_name property
  else if (dbUser.role) {
    if (typeof dbUser.role === "object" && dbUser.role.role_name) {
      roleName = dbUser.role.role_name;
    } else if (typeof dbUser.role === "object" && dbUser.role.name) {
      roleName = dbUser.role.name;
    } else if (typeof dbUser.role === "string") {
      roleName = dbUser.role;
    }
  }

  return {
    id: dbUser.id,
    fullName: dbUser.full_name || dbUser.fullName || "",
    email: dbUser.email || "",
    role_name: roleName, // ← Now properly extracted
  };
}

// ─── API Calls ───
async function fetchUsers() {
  loading.value = true;
  error.value = null;
  try {
    const data = await $fetch(API_URL);
    users.value = data.map(mapUser);
  } catch (err) {
    error.value =
      "Failed to load users. Make sure XAMPP is running on port 80.";
    console.error("Fetch users error:", err);
  } finally {
    loading.value = false;
  }
}

function refreshData() {
  fetchUsers();
}

// ─── Actions ───

async function saveUser() {
  // Validate
  if (
    !form.value.fullName.trim() ||
    !form.value.email.trim() ||
    !form.value.role_name.trim()
  ) {
    alert("Full Name, Email, and Role are required.");
    return;
  }

  saving.value = true;
  try {
    if (editingUser.value) {
      await $fetch(`${API_URL}?id=${editingUser.value.id}`, {
        method: "PUT",
        body: form.value,
      });
    } else {
      await $fetch(API_URL, {
        method: "POST",
        body: form.value,
      });
    }
    closeModal();
    refreshData();
  } catch (err) {
    alert("Error saving user: " + (err.message || "Unknown error"));
  } finally {
    saving.value = false;
  }
}

async function deleteUser(id) {
  if (
    !confirm(
      "Are you sure you want to delete this user? This action cannot be undone."
    )
  )
    return;
  try {
    await $fetch(`${API_URL}?id=${id}`, { method: "DELETE" });
    await fetchUsers();
  } catch (err) {
    alert("Error deleting user: " + (err.message || "Unknown error"));
  }
}

// ─── Auth ───
onMounted(() => {
  if (!localStorage.getItem("token")) {
    navigateTo("/login");
    return;
  }

  // Get current user from localStorage or your auth store
  const stored = localStorage.getItem("user");
  if (stored) {
    try {
      const u = JSON.parse(stored);
      currentUser.value = {
        name: u.name || "Admin",
        initials: (u.name || "System Admin")
          .split(" ")
          .map((n) => n[0])
          .join("")
          .toUpperCase(),
      };
    } catch {
      currentUser.value = { name: "Admin", initials: "SA" };
    }
  } else {
    currentUser.value = { name: "Admin", initials: "SA" };
  }

  fetchUsers();
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&display=swap");

.custom-scroll::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f3f4f6;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: #c0c0c0;
  border-radius: 0;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #a0a0a0;
}
</style>
