<template>
  <div class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-white font-['Overpass'] text-[14px] text-[#1F2835]">

    <!-- Top Header: Breadcrumb -->
    <div class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200">
      <div class="flex items-center text-[11px] text-gray-500 gap-1">
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span class="cursor-pointer transition-colors">Leads Tracker</span>
        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#f52c11] font-medium">Performance Improvement Plan</span>
      </div>
    </div>

    <!-- Title + Search + View Archive + Add Record — ALL IN ONE ROW -->
    <div class="bg-white px-4 py-2 flex items-center justify-between gap-4 shrink-0">
      <!-- Left: Title -->
      <h1 class="font-bold text-[16px] tracking-tight whitespace-nowrap">Performance Improvement Plan (PIP)</h1>

      <!-- Right: Search + View Archive + Add Record -->
      <div class="flex items-center gap-1.5">
        <!-- Search -->
        <div class="relative flex items-center">
          <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-[4px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Search..." 
            class="pl-7 pr-2 py-[2px] w-56 bg-white border border-gray-300 rounded-[4px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
          >
        </div>

        <button 
          @click="showArchiveModal = true"
          class="bg-white border border-gray-300 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-3 py-[4px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
        >
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
          </svg>
          View archive
        </button>

        <button 
          @click="handleAddRecord"
          class="bg-[#F52C11] hover:bg-[#d9250e] text-white px-3 py-[4px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
        >
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          Add record
        </button>
      </div>
    </div>

    <!-- Main Content: Table Section -->
    <main class="flex-1 flex p-2 gap-1.5 min-h-0 overflow-hidden">
      <section class="flex-1 flex flex-col min-w-0 bg-white border border-gray-200 overflow-hidden relative rounded-[6px]">
        
        <!-- Table -->
        <div class="flex-1 overflow-auto custom-scroll relative">
          <table class="w-full border-collapse text-left">
            <thead class="bg-white sticky top-0 z-20">
              <tr class="border-b border-gray-200">
                <th class="w-6 px-1.5 py-[3px] text-center">
                  <input 
                    type="checkbox" 
                    :checked="isAllSelected"
                    @change="toggleAll"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  >
                </th>
                <th class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Date Recorded</th>
                <th class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Client Name</th>
                <th class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Service</th>
                <th class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Onboarding Date</th>
                <th class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Status</th>
                <th class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11] sticky right-0 z-30 bg-white shadow-[-2px_0_4px_rgba(0,0,0,0.05)]">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(record, index) in filteredRecords" 
                :key="record.id"
                class="transition-colors"
                :class="{
                  'bg-[#F52C11]/15': isSelected(record.id),
                  'bg-white hover:bg-[#F52C11]/10': !isSelected(record.id),
                  'border-b border-gray-100': index !== filteredRecords.length - 1
                }"
              >
                <td class="px-1.5 py-[3px] text-center">
                  <input 
                    type="checkbox" 
                    :checked="isSelected(record.id)"
                    @change="toggleSelection(record.id)"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  >
                </td>
                <td class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ record.dateRecorded }}</td>
                <td class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ record.clientName }}</td>
                <td class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ record.service }}</td>
                <td class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ record.onboardingDate }}</td>
                <td class="px-2 py-[3px] whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                      <div 
                        class="h-full rounded-full"
                        :style="{ width: record.status + '%', backgroundColor: getStatusColor(record.status) }"
                      ></div>
                    </div>
                    <span class="text-[10px] font-semibold" :style="{ color: getStatusColor(record.status) }">{{ record.status }}%</span>
                  </div>
                </td>
                <td 
                   class="px-2 py-[3px] whitespace-nowrap sticky right-0 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] transition-colors"
                   :class="isSelected(record.id) ? 'bg-[#F52C11]/0' : 'bg-white hover:bg-[#F52C11]/0'"
                  >
                  <div class="flex items-center gap-1.5">
                    <button @click="openViewModal(record)" class="text-gray-400 hover:text-[#F52C11] transition-colors" title="View">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </button>
                    
                    <button @click="openEditModal(record)" class="text-gray-400 hover:text-[#F52C11] transition-colors" title="Edit">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              
              <tr v-if="filteredRecords.length === 0">
                <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                  <div v-if="searchQuery">
                    No records found matching "<span class="font-semibold text-[#1F2835]">{{ searchQuery }}</span>"
                  </div>
                  <div v-else>No records available</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Bottom Selection Bar - ARCHIVE SELECTED -->
        <div 
          v-if="selectedCount > 0"
          class="shrink-0 bg-white border-t border-gray-200 px-3 py-[3px] flex items-center justify-between"
        >
          <div class="flex items-center gap-2 text-[11px] text-[#1F2835]">
            <svg class="w-3.5 h-3.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ selectedCount }} record(s) selected</span>
          </div>
          <button 
            @click="archiveSelectedRecords"
            class="bg-[#F52C11] hover:bg-[#F52C11] text-white px-2.5 py-[2px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
          >
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            Archive selected
          </button>
        </div>
      </section>
    </main>

    <!-- View Archive Modal - PERMANENT/STEADY SHAPE -->
    <div v-if="showArchiveModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white rounded-[8px] w-[900px] max-h-[80vh] shadow-xl flex flex-col overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-white shrink-0">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <div>
              <h3 class="text-[14px] font-bold text-[#1F2835]">Archived Records</h3>
              <p class="text-[10px] text-gray-400">{{ archivedRecords.length }} archived record(s)</p>
            </div>
          </div>
          <button @click="showArchiveModal = false" class="text-gray-400 hover:text-[#1F2835] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="flex-1 overflow-auto custom-scroll p-4">
          <div v-if="archivedRecords.length === 0" class="text-center py-12 text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-[12px]">No archived records yet</p>
          </div>

          <table v-else class="w-full border-collapse text-left">
            <thead class="bg-white sticky top-0 z-10">
              <tr class="border-b border-gray-200">
                <th class="px-3 py-[6px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Date Recorded</th>
                <th class="px-3 py-[6px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Client Name</th>
                <th class="px-3 py-[6px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Service</th>
                <th class="px-3 py-[6px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Onboarding Date</th>
                <th class="px-3 py-[6px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Status</th>
                <th class="px-3 py-[6px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11] text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(record, index) in archivedRecords" 
                :key="record.id"
                class="bg-white hover:bg-gray-50 transition-colors"
                :class="{ 'border-b border-gray-100': index !== archivedRecords.length - 1 }"
              >
                <td class="px-3 py-[6px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ record.dateRecorded }}</td>
                <td class="px-3 py-[6px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ record.clientName }}</td>
                <td class="px-3 py-[6px] whitespace-nowrap text-[11px] text-gray-600">{{ record.service }}</td>
                <td class="px-3 py-[6px] whitespace-nowrap text-[11px] text-gray-500">{{ record.onboardingDate }}</td>
                <td class="px-3 py-[6px] whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                      <div 
                        class="h-full rounded-full"
                        :style="{ width: record.status + '%', backgroundColor: getStatusColor(record.status) }"
                      ></div>
                    </div>
                    <span class="text-[10px] font-semibold" :style="{ color: getStatusColor(record.status) }">{{ record.status }}%</span>
                  </div>
                </td>
                <td class="px-3 py-[6px] whitespace-nowrap text-center">
                  <button 
                    @click="unarchiveRecord(record.id)"
                    class="text-gray-400 hover:text-green-600 transition-colors inline-flex items-center gap-1 text-[11px] font-medium"
                    title="Restore record"
                  >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Restore
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Modal Footer -->
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-end bg-white shrink-0">
          <button 
            @click="showArchiveModal = false" 
            class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
          >
            Close
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')
const selectedIds = ref([])
const showArchiveModal = ref(false)

// Active records
const records = ref([
  { id: 1, dateRecorded: '06/19/26', clientName: 'Rowan Ellis', service: 'Website Development', onboardingDate: '06/19/26', status: 15 },
  { id: 2, dateRecorded: '06/19/26', clientName: 'Zara Ellison', service: 'Website Development', onboardingDate: '06/19/26', status: 100 },
  { id: 3, dateRecorded: '06/19/26', clientName: 'Rowan Ellis', service: 'Website Development', onboardingDate: '06/19/26', status: 12 },
  { id: 4, dateRecorded: '06/19/26', clientName: 'Jordan Vale', service: 'Website Development', onboardingDate: '06/19/26', status: 90 },
  { id: 5, dateRecorded: '06/19/26', clientName: 'Rowan Ellis', service: 'Website Development', onboardingDate: '06/19/26', status: 75 },
  { id: 6, dateRecorded: '06/19/26', clientName: 'Morgan Reese', service: 'Website Development', onboardingDate: '06/19/26', status: 10 },
  { id: 7, dateRecorded: '06/19/26', clientName: 'Zara Ellison', service: 'Website Development', onboardingDate: '06/19/26', status: 100 },
  { id: 8, dateRecorded: '06/19/26', clientName: 'Zara Ellison', service: 'Website Development', onboardingDate: '06/19/26', status: 100 },
  { id: 9, dateRecorded: '06/19/26', clientName: 'Layra Dawson', service: 'Website Development', onboardingDate: '06/19/26', status: 40 },
  { id: 10, dateRecorded: '06/19/26', clientName: 'Layra Dawson', service: 'Website Development', onboardingDate: '06/19/26', status: 30 },
  { id: 11, dateRecorded: '06/19/26', clientName: 'Dyros Solen', service: 'Website Development', onboardingDate: '06/19/26', status: 60 },
  { id: 12, dateRecorded: '06/19/26', clientName: 'Lucian Mercer', service: 'Website Development', onboardingDate: '06/19/26', status: 10 },
  { id: 13, dateRecorded: '06/19/26', clientName: 'Lucian Mercer', service: 'Website Development', onboardingDate: '06/19/26', status: 10 },
  { id: 14, dateRecorded: '06/19/26', clientName: 'Dyros Solen', service: 'Website Development', onboardingDate: '06/19/26', status: 50 }
])

// Archived records storage
const archivedRecords = ref([])

const filteredRecords = computed(() => {
  let result = records.value
  
  const q = searchQuery.value.trim().toLowerCase()
  if (q) {
    result = result.filter(r => 
      r.clientName.toLowerCase().includes(q) || 
      r.service.toLowerCase().includes(q)
    )
  }
  
  return result
})

const selectedCount = computed(() => selectedIds.value.length)
const isAllSelected = computed(() => {
  return filteredRecords.value.length > 0 && filteredRecords.value.every(r => selectedIds.value.includes(r.id))
})

function getStatusColor(status) {
  if (status >= 80) return '#22c55e'
  if (status >= 50) return '#3b82f6'
  if (status >= 30) return '#f97316'
  return '#ef4444'
}

function isSelected(id) {
  return selectedIds.value.includes(id)
}

function toggleSelection(id) {
  const idx = selectedIds.value.indexOf(id)
  if (idx > -1) {
    selectedIds.value.splice(idx, 1)
  } else {
    selectedIds.value.push(id)
  }
}

function toggleAll() {
  const visibleIds = filteredRecords.value.map(r => r.id)
  const allVisibleSelected = visibleIds.every(id => selectedIds.value.includes(id))
  
  if (allVisibleSelected) {
    selectedIds.value = selectedIds.value.filter(id => !visibleIds.includes(id))
  } else {
    const newIds = visibleIds.filter(id => !selectedIds.value.includes(id))
    selectedIds.value.push(...newIds)
  }
}

function openViewModal(record) {
  console.log('View record:', record)
}

function openEditModal(record) {
  console.log('Edit record:', record)
}

function handleAddRecord() {
  // Add record logic without modal — wire this to your own flow (e.g., navigate to a create page)
  console.log('Add record clicked — implement your own add flow here')
}

function archiveRecord(id) {
  const idx = records.value.findIndex(r => r.id === id)
  if (idx > -1) {
    const record = records.value[idx]
    const now = new Date()
    const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
    
    archivedRecords.value.push({
      ...record,
      dateArchived: dateStr
    })
    
    records.value.splice(idx, 1)
    selectedIds.value = selectedIds.value.filter(sid => sid !== id)
  }
}

function archiveSelectedRecords() {
  const idsToArchive = new Set(selectedIds.value)
  const recordsToArchive = records.value.filter(r => idsToArchive.has(r.id))
  
  const now = new Date()
  const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
  
  recordsToArchive.forEach(record => {
    archivedRecords.value.push({
      ...record,
      dateArchived: dateStr
    })
  })
  
  records.value = records.value.filter(r => !idsToArchive.has(r.id))
  selectedIds.value = []
}

function unarchiveRecord(id) {
  const idx = archivedRecords.value.findIndex(r => r.id === id)
  if (idx > -1) {
    const record = archivedRecords.value[idx]
    const { dateArchived, ...restoredRecord } = record
    
    records.value.push(restoredRecord)
    archivedRecords.value.splice(idx, 1)
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap');

.custom-scroll::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: #F52C11;
  border-radius: 3px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #d9250e;
}

input[type="checkbox"] {
  accent-color: #F52C11;
}

table th,
table td {
  border-left: none !important;
  border-right: none !important;
}
</style>