<template>
  <div class="flex h-full min-h-0 flex-col overflow-hidden bg-[#f4f6fa] text-[#1f2835]">
    <header class="shrink-0 border-b border-gray-200 bg-white px-6 py-5">
      <p class="text-[11px] uppercase tracking-[0.28em] text-gray-400">Module</p>
      <h1 class="mt-2 text-2xl font-semibold">Create Sales Task</h1>
    </header>

    <main class="min-h-0 flex-1 overflow-auto p-6">
      <form class="max-w-2xl space-y-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm" @submit.prevent="saveTask">
        <label class="block">
          <span class="mb-2 block text-sm font-medium">Task Title</span>
          <input v-model="form.title" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]" />
        </label>
        <label class="block">
          <span class="mb-2 block text-sm font-medium">Assignee</span>
          <input v-model="form.assignee" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]" />
        </label>
        <label class="block">
          <span class="mb-2 block text-sm font-medium">Status</span>
          <select v-model="form.status" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-[#f52c11]">
            <option>Open</option>
            <option>In Progress</option>
            <option>Done</option>
          </select>
        </label>

        <div class="flex items-center justify-end gap-3 pt-2">
          <button type="button" @click="navigateTo('/sales')" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">
            Cancel
          </button>
          <button type="submit" class="rounded-lg bg-[#f52c11] px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            Save Task
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
  title: "",
  assignee: "",
  status: "Open",
});

function saveTask() {
  const current = JSON.parse(localStorage.getItem("sales-task-records") || "[]");
  current.unshift({
    id: Date.now(),
    title: form.title || "New Task",
    assignee: form.assignee || "Unassigned",
    status: form.status,
  });
  localStorage.setItem("sales-task-records", JSON.stringify(current));
  navigateTo("/sales");
}
</script>
