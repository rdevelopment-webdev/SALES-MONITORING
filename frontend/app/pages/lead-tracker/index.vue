<template>
  <div class="flex h-full min-h-0 flex-col overflow-hidden bg-[#f4f6fa] text-[#1f2835]">
    <header class="shrink-0 border-b border-gray-200 bg-white px-6 py-5">
      <div class="flex items-center justify-between gap-4">
        <div>
          <p class="text-[11px] uppercase tracking-[0.28em] text-gray-400">
            Module
          </p>
          <h1 class="mt-2 text-2xl font-semibold">Leads Tracker</h1>
          <p class="mt-1 text-sm text-gray-500">
            Track incoming leads and move them through the pipeline.
          </p>
        </div>

        <button
          type="button"
          @click="navigateTo('/lead-tracker/create')"
          class="rounded-lg bg-[#f52c11] px-4 py-2 text-sm font-semibold text-white transition-colors hover:opacity-90"
        >
          + New Lead
        </button>
      </div>
    </header>

    <main class="min-h-0 flex-1 overflow-auto p-6">
      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full text-left">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-5 py-4 text-sm font-semibold">Lead Name</th>
              <th class="px-5 py-4 text-sm font-semibold">Email</th>
              <th class="px-5 py-4 text-sm font-semibold">Status</th>
              <th class="px-5 py-4 text-sm font-semibold">Created</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="lead in leads" :key="lead.id" class="border-t border-gray-100">
              <td class="px-5 py-4">{{ lead.name }}</td>
              <td class="px-5 py-4 text-gray-600">{{ lead.email }}</td>
              <td class="px-5 py-4">
                <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700">
                  {{ lead.status }}
                </span>
              </td>
              <td class="px-5 py-4 text-gray-600">{{ lead.createdAt }}</td>
            </tr>

            <tr v-if="leads.length === 0">
              <td colspan="4" class="px-5 py-10 text-center text-sm text-gray-500">
                No leads yet. Add one to get started.
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

const leads = ref([]);

onMounted(() => {
  try {
    leads.value = JSON.parse(localStorage.getItem("lead-tracker-records") || "[]");
  } catch {
    leads.value = [];
  }
});
</script>
