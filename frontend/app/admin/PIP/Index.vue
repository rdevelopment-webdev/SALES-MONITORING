<template>
  <div class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-white font-['Arimo'] text-[14px] text-black">

    <!-- Top Header -->
    <header class="bg-white border-b border-gray-300 px-4 py-2 flex items-center justify-between shrink-0">
      <span class="font-medium tracking-wide">PIP Dashboard</span>
      <div class="flex items-center gap-3">
        <button class="text-gray-600 hover:text-black transition-colors relative">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
          </svg>
        </button>
        <button class="text-gray-600 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.295 1.088.22l1.274-.254c.54-.108 1.098.138 1.316.63.218.494.026 1.068-.433 1.384l-1.09.753c-.29.2-.436.55-.397.898.007.062.01.125.01.19 0 .338-.147.663-.397.898l-1.09.753c-.46.317-.65.89-.433 1.384.218.492.775.738 1.316.63l1.273-.254c.368-.074.764.024 1.088.22.073.044.146.087.22.127.332.184.582.496.645.87l.213 1.28c.09.543.56.941 1.11.941h2.594c.55 0 1.02-.398 1.11-.94l.213-1.281c.063-.374.313-.686.645-.87.074-.04.147-.083.22-.127.324-.196.72-.295 1.088-.22l1.274.254c.54.108 1.098-.138 1.316-.63.218-.494.026-1.068-.433-1.384l-1.09-.753c-.29-.2-.436-.55-.397-.898-.007-.062-.01-.125-.01-.19 0-.338.147-.663.397-.898l1.09-.753c.46-.317.65-.89.433-1.384-.218-.492-.775-.738-1.316-.63l-1.273.254c-.368.074-.764-.024-1.088-.22-.073-.044-.146-.087-.22-.127-.332-.184-.582-.496-.645-.87l-.213-1.28c-.09-.543-.56-.941-1.11-.941h-2.594c-.55 0-1.02.398-1.11.94l-.213 1.281c-.063.374-.313.686-.645.87-.074.04-.147.083-.22.127-.324.196-.72.295-1.088.22l-1.274-.254c-.54-.108-1.098.138-1.316.63-.218.494-.026 1.068.433 1.384l1.09.753c.29.2.436.55.397.898.007.062.01.125.01.19 0 .338-.147.663-.397.898l-1.09.753c-.46.317-.65.89-.433 1.384.218.492.775.738 1.316.63l1.273-.254c.368-.074.764.024 1.088.22.073.044.146.087.22.127.332.184.582.496.645.87z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </button>
        <div class="flex items-center gap-2 pl-2 border-l border-gray-300">
          <div class="text-right hidden sm:block leading-tight">
            <p class="text-gray-500 text-[12px]">Logged in as</p>
            <p class="font-semibold">Admin</p>
          </div>
          <div class="w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center text-xs font-bold">SA</div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col p-3 min-h-0">
      
      <!-- Title & Controls -->
      <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-3 shrink-0">
        <h1 class="font-bold text-[16px]">Performance Improvement Plan (PIP)</h1>
        
        <div class="flex items-center gap-2">
          <!-- Search -->
          <div class="relative flex items-center">
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Search records..." 
              class="pl-3 pr-16 py-1.5 w-72 bg-white border border-gray-400 rounded-[8px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
            >
            <button 
              v-if="searchQuery" 
              @click="clearSearch"
              class="absolute right-8 text-gray-400 hover:text-red-600 px-1"
              title="Clear"
            >
              ✕
            </button>
            <svg class="w-4 h-4 text-gray-500 absolute right-2.5 top-2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>

          <button 
            @click="addRecord" 
            class="bg-[#fa6f10] hover:bg-[#e5630e] active:bg-[#cc570d] text-white px-3 py-1.5 rounded-[8px] font-medium flex items-center gap-1 transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Record
          </button>
        </div>
      </div>

      <!-- Excel-like Table -->
      <div class="flex-1 bg-white border border-gray-400 overflow-auto custom-scroll min-h-0">
        <table class="min-w-full border-collapse text-left">
          
          <thead class="bg-[#f2f2f2] sticky top-0 z-20">
            <tr>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Date Recorded</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Client Name</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Prospect Technique</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Email</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Service</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Status (%)</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Area</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Sales Representative</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Onboarding Date</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Remarks</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Contact Person</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Contact Number</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap">Ways of Communication</th>
              <th class="px-2 py-1.5 border border-gray-300 font-semibold whitespace-nowrap sticky right-0 z-30">Action</th>
            </tr>
          </thead>

          <tbody>
            <tr 
              v-for="record in filteredRecords" 
              :key="record.id"
              class="bg-white hover:bg-[#fa6f10]/20 transition-colors"
            >
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.dateRecorded }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.clientName }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.prospectTechnique }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap text-blue-700 hover:underline cursor-pointer">{{ record.email }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.service }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">
                <div class="flex items-center gap-1.5">
                  <div class="w-16 h-1.5 border-gray-400">
                    <div class="h-full" :style="{ width: record.status + '%' }"></div>
                  </div>
                  <span class="text-xs">{{ record.status }}%</span>
                </div>
              </td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.area }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.salesRep }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.onboardingDate }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap text-gray-600">{{ record.remarks || '-' }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.contactPerson }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.contactNumber }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap">{{ record.communication }}</td>
              <td class="px-2 py-1.5 border border-gray-300 whitespace-nowrap sticky right-0 bg-white shadow-[-2px_0_4px_rgba(0,0,0,0.1)]">
                <div class="flex items-center gap-2">
                  <button class="text-gray-600 hover:text-blue-700 transition-colors" title="View">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                  </button>
                  <button class="text-gray-600 hover:text-green-700 transition-colors" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button @click="deleteRecord(record.id)" class="text-gray-600 hover:text-red-700 transition-colors" title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            
            <!-- Empty state -->
            <tr v-if="filteredRecords.length === 0">
              <td colspan="14" class="px-4 py-8 text-center text-gray-500 border border-gray-300">
                <div v-if="searchQuery">
                  No records found matching "<span class="font-semibold text-black">{{ searchQuery }}</span>"
                  <br>
                  <button @click="clearSearch" class="mt-2 text-[#fa6f10] hover:underline text-sm">Clear search</button>
                </div>
                <div v-else>No records available</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')
let nextId = 1

const records = ref([
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'lilms.sweetie', prospectTechnique: 'Cold Emailing', email: '@gmail.com', service: 'Website Development', status: 100, area: 'Area jsgjahfsffffffffffffffffff', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 28, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 28, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 28, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 28, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 100, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 50, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 50, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 50, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 50, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 100, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 75, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 75, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 75, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
  { id: nextId++, dateRecorded: '06/19/2026', clientName: 'First Middle Last', prospectTechnique: 'Cold Calling', email: 'firstmiddlelast@gmail.com', service: 'Website Development', status: 75, area: 'Area', salesRep: 'First Middle Last', onboardingDate: '06/19/2026', remarks: '', contactPerson: 'First Middle Last', contactNumber: '0123456789', communication: 'Messenger' },
])

// 🔍 SEARCH FILTER — updates table instantly as you type
const filteredRecords = computed(() => {
  const query = searchQuery.value.trim().toLowerCase()
  
  if (!query) return records.value
  
  return records.value.filter(record => {
    return Object.entries(record).some(([key, val]) => {
      if (key === 'id') return false
      if (val === null || val === undefined) return false
      return String(val).toLowerCase().includes(query)
    })
  })
})

function clearSearch() {
  searchQuery.value = ''
}

const comms = ['Messenger', 'Email', 'Phone', 'WhatsApp', 'Viber']

function addRecord() {
  const randomPercent = Math.floor(Math.random() * 100)
  const comm = comms[Math.floor(Math.random() * comms.length)]
  
  records.value.push({
    id: nextId++,
    dateRecorded: '06/19/2026',
    clientName: 'First Middle Last',
    prospectTechnique: 'Cold Calling',
    email: 'firstmiddlelast@gmail.com',
    service: 'Website Development',
    status: randomPercent,
    area: 'Area',
    salesRep: 'First Middle Last',
    onboardingDate: '06/19/2026',
    remarks: '',
    contactPerson: 'First Middle Last',
    contactNumber: '0123456789',
    communication: comm,
  })
}

function deleteRecord(id) {
  const index = records.value.findIndex(r => r.id === id)
  if (index !== -1) records.value.splice(index, 1)
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&display=swap');

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