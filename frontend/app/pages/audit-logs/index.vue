<template>
  <div class="flex h-full min-h-0 flex-col overflow-hidden bg-[#f4f6fa] text-[#1f2835]">
    <header class="shrink-0 border-b border-gray-200 bg-white px-6 py-5">
      <p class="text-[11px] uppercase tracking-[0.28em] text-gray-400">Module</p>
      <h1 class="mt-2 text-2xl font-semibold">Audit Logs</h1>
      <p class="mt-1 text-sm text-gray-500">Review recent account activity.</p>
    </header>

    <main class="min-h-0 flex-1 overflow-auto p-6">
      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full text-left">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-5 py-4 text-sm font-semibold">Action</th>
              <th class="px-5 py-4 text-sm font-semibold">User</th>
              <th class="px-5 py-4 text-sm font-semibold">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="entry in entries" :key="entry.id" class="border-t border-gray-100">
              <td class="px-5 py-4">{{ entry.action }}</td>
              <td class="px-5 py-4 text-gray-600">{{ entry.user }}</td>
              <td class="px-5 py-4 text-gray-600">{{ entry.created_at }}</td>
            </tr>
            <tr v-if="entries.length === 0">
              <td colspan="3" class="px-5 py-10 text-center text-sm text-gray-500">
                No audit logs available.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

const entries = ref([]);
const { apiFetch } = useApi();

onMounted(async () => {
  try {
    const response = await apiFetch("/audit_logs");
    entries.value = response?.data || response || [];
  } catch {
    entries.value = [];
  }
});
</script>
