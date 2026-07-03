<template>
  <div class="flex h-full min-h-0 flex-col overflow-hidden bg-[#f4f6fa] text-[#1f2835]">
    <header class="shrink-0 border-b border-gray-200 bg-white px-6 py-5">
      <p class="text-[11px] uppercase tracking-[0.28em] text-gray-400">Module</p>
      <h1 class="mt-2 text-2xl font-semibold">Edit User</h1>
      <p class="mt-1 text-sm text-gray-500">Update the selected user record.</p>
    </header>

    <main class="min-h-0 flex-1 overflow-auto p-6">
      <form class="max-w-2xl space-y-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm" @submit.prevent="saveUser">
        <label class="block">
          <span class="mb-2 block text-sm font-medium">Full Name</span>
          <input v-model="form.full_name" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]" />
        </label>
        <label class="block">
          <span class="mb-2 block text-sm font-medium">Email</span>
          <input v-model="form.email" type="email" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]" />
        </label>
        <label class="block">
          <span class="mb-2 block text-sm font-medium">Role</span>
          <input v-model="form.role_name" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]" />
        </label>

        <div class="flex items-center justify-end gap-3 pt-2">
          <button type="button" @click="navigateTo('/users')" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">
            Cancel
          </button>
          <button type="submit" class="rounded-lg bg-[#f52c11] px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            Save Changes
          </button>
        </div>
      </form>
    </main>
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

const form = reactive({
  full_name: "",
  email: "",
  role_name: "",
});

onMounted(() => {
  const storedUser = JSON.parse(localStorage.getItem("user") || "null");
  if (storedUser) {
    form.full_name = storedUser.full_name || storedUser.fullName || "";
    form.email = storedUser.email || "";
    form.role_name =
      storedUser.role?.role_name ||
      storedUser.role?.name ||
      storedUser.role_name ||
      storedUser.role ||
      "";
  }
});

function saveUser() {
  const current = JSON.parse(localStorage.getItem("user") || "null") || {};
  const updated = {
    ...current,
    full_name: form.full_name,
    email: form.email,
    role_name: form.role_name,
  };
  localStorage.setItem("user", JSON.stringify(updated));
  navigateTo("/users");
}
</script>
