<template>
  <div class="flex h-full min-h-0 flex-col overflow-hidden bg-[#f4f6fa] text-[#1f2835]">
    <header class="shrink-0 border-b border-gray-200 bg-white px-6 py-5">
      <p class="text-[11px] uppercase tracking-[0.28em] text-gray-400">Module</p>
      <h1 class="mt-2 text-2xl font-semibold">Create Lead</h1>
      <p class="mt-1 text-sm text-gray-500">Save a new lead to local storage.</p>
    </header>

    <main class="min-h-0 flex-1 overflow-auto p-6">
      <form
        class="max-w-2xl space-y-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
        @submit.prevent="saveLead"
      >
        <label class="block">
          <span class="mb-2 block text-sm font-medium">Lead Name</span>
          <input v-model="form.name" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]" />
        </label>

        <label class="block">
          <span class="mb-2 block text-sm font-medium">Email</span>
          <input v-model="form.email" type="email" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]" />
        </label>

        <label class="block">
          <span class="mb-2 block text-sm font-medium">Status</span>
          <select v-model="form.status" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]">
            <option>New</option>
            <option>Contacted</option>
            <option>Qualified</option>
          </select>
        </label>

        <div class="flex items-center justify-end gap-3 pt-2">
          <button type="button" @click="navigateTo('/lead-tracker')" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">
            Cancel
          </button>
          <button type="submit" class="rounded-lg bg-[#f52c11] px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            Save Lead
          </button>
        </div>
      </form>
    </main>
  </div>
</template>

<script setup>
import { reactive } from "vue";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

const form = reactive({
  name: "",
  email: "",
  status: "New",
});

function saveLead() {
  const current = JSON.parse(localStorage.getItem("lead-tracker-records") || "[]");
  current.unshift({
    id: Date.now(),
    name: form.name || "New Lead",
    email: form.email || "",
    status: form.status,
    createdAt: new Date().toLocaleDateString(),
  });
  localStorage.setItem("lead-tracker-records", JSON.stringify(current));
  navigateTo("/lead-tracker");
}
</script>
