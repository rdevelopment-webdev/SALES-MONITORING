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
    <main class="flex-1 flex flex-col p-4 min-h-0">
      <div class="max-w-6xl mx-auto w-full flex-1 flex flex-col min-h-0">
        
        <!-- Title & Controls -->
        <div class="flex items-center justify-between mb-3 shrink-0">
          <div class="flex items-center gap-2">
            <svg v-if="!showArchivedView" class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <svg v-else class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <div>
              <h1 class="font-bold text-[16px] leading-tight">{{ showArchivedView ? 'Archived Users' : 'Users' }}</h1>
              <p class="text-[11px] text-gray-500">{{ showArchivedView ? 'Restore archived users' : 'Manage system roles' }}</p>
            </div>
          </div>
          
          <div class="flex items-center gap-2">

            <!-- Archive Button -->
            <button 
              @click="toggleArchiveView"
              class="relative flex items-center gap-1.5 px-3 py-1.5 border border-gray-300 rounded-[4px] text-gray-700 hover:bg-[#fa6f10]/10 transition-colors font-medium text-[13px]"
              :class="{ 'bg-gray-100 border-gray-400': showArchivedView }"
              title="View Archived Users"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
              </svg>
              Archive
              <span 
                v-if="archivedCount > 0" 
                class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm"
              >
                {{ archivedCount }}
              </span>
            </button>

            <button 
              v-if="!showArchivedView"
              @click="addUser"
              class="bg-[#f52c11] hover:bg-[#e5630e] active:bg-[#cc570d] text-white px-4 py-1.5 rounded-[4px] font-medium text-[13px] transition-colors"
            >
              Add User
            </button>
          </div>
        </div>

        <!-- Active Users Table -->
        <div v-if="!showArchivedView" class="flex-1 bg-white border border-gray-300 overflow-auto custom-scroll min-h-0">
          <table class="min-w-full border-collapse text-left">
            <thead class="bg-[#f2f2f2] sticky top-0 z-20">
              <tr>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Full Name</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Email</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Contact Number</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Role</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Date</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap text-center sticky right-0 bg-[#f2f2f2] z-30 shadow-[-2px_0_4px_rgba(0,0,0,0.1)]">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="user in users" 
                :key="user.id"
                class="bg-white hover:bg-[#f52c11]/15 transition-colors"
              >
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap">{{ user.fullName }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap text-blue-700 hover:underline cursor-pointer">{{ user.email }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap">{{ user.contactNumber }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap">
                  <span class="px-2 py-0.5 bg-gray-100 border border-gray-300 rounded-[4px] text-[12px] font-medium">{{ user.role }}</span>
                </td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap">{{ user.date }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap sticky right-0 bg-white">
                  <div class="flex items-center justify-center gap-3">
                    <button class="text-gray-600 hover:text-blue-700 transition-colors" title="Edit">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                    <button 
                      @click="archiveUser(user.id)" 
                      class="text-gray-600 hover:text-red-700 transition-colors" 
                      title="Archive"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="users.length === 0">
                <td colspan="6" class="px-4 py-8 text-center text-gray-500 border-b border-gray-300">
                  No users found
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Archived Users Table -->
        <div v-else class="flex-1 bg-white border border-gray-400 overflow-auto custom-scroll min-h-0">
          <table class="min-w-full border-collapse text-left">
            <thead class="bg-[#f2f2f2] sticky top-0 z-20">
              <tr>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Full Name</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Email</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Contact Number</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Role</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap">Date Archived</th>
                <th class="px-3 py-2 border-b border-gray-300 font-semibold whitespace-nowrap text-center sticky right-0 bg-[#f2f2f2] z-30 shadow-[-2px_0_4px_rgba(0,0,0,0.1)]">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="user in archivedUsers" 
                :key="user.id"
                class="bg-white hover:bg-[#fa6f10]/10 transition-colors"
              >
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap">{{ user.fullName }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap text-blue-700 hover:underline cursor-pointer">{{ user.email }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap">{{ user.contactNumber }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap">
                  <span class="px-2 py-0.5 bg-gray-100 border border-gray-300 rounded-[4px] text-[12px] font-medium">{{ user.role }}</span>
                </td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap text-gray-500">{{ user.archivedAt }}</td>
                <td class="px-3 py-2 border-b border-gray-300 whitespace-nowrap sticky right-0 bg-white hover:bg-[#fa6f10]/10 shadow-[-2px_0_4px_rgba(0,0,0,0.1)]">
                  <div class="flex items-center justify-center">
                    <button 
                      @click="unarchiveUser(user.id)" 
                      class="flex items-center gap-1.5 px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-[4px] text-[12px] font-medium transition-colors"
                      title="Restore to Users"
                    >
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                      </svg>
                      Unarchive
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="archivedUsers.length === 0">
                <td colspan="6" class="px-4 py-8 text-center text-gray-500 border-b border-gray-300">
                  No archived users
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Footer -->
        <div class="shrink-0 px-1 py-1.5 text-[12px] text-gray-500 border-t border-gray-300 bg-white">
          <span v-if="!showArchivedView">Showing {{ users.length }} user{{ users.length !== 1 ? 's' : '' }}</span>
          <span v-else>Showing {{ archivedUsers.length }} archived user{{ archivedUsers.length !== 1 ? 's' : '' }}</span>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const users = ref([
  { id: 1, fullName: 'Admin User', email: 'helloadmin@gmail.com', contactNumber: '09123456789', role: 'Admin', date: 'June 25, 2026' },
])

const archivedUsers = ref([])
const showArchivedView = ref(false)

const archivedCount = computed(() => archivedUsers.value.length)

function toggleArchiveView() {
  showArchivedView.value = !showArchivedView.value
}

function archiveUser(id) {
  const index = users.value.findIndex(u => u.id === id)
  if (index !== -1) {
    const user = users.value[index]
    archivedUsers.value.push({ 
      ...user, 
      archivedAt: new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) 
    })
    users.value.splice(index, 1)
  }
}

function unarchiveUser(id) {
  const index = archivedUsers.value.findIndex(u => u.id === id)
  if (index !== -1) {
    const user = archivedUsers.value[index]
    // Remove archivedAt property before restoring
    const { archivedAt, ...restoredUser } = user
    users.value.push(restoredUser)
    archivedUsers.value.splice(index, 1)
  }
}

function addUser() {
  navigateTo('/admin/users/create')
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