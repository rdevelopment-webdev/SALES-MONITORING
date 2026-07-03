<template>
  <div class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-white font-['Overpass'] text-[14px] text-[#1F2835]">

    <!-- Top Header: Breadcrumb only -->
    <div class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200">
      <div class="flex items-center text-[11px] text-gray-500 gap-1">
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span class="text-[#f52c11] cursor-pointer transition-colors">User Management</span>
      </div>
    </div>

    <!-- Title + Subtitle (same row) - COMPRESSED -->
    <div class="bg-white px-4 py-1 flex items-center justify-between shrink-0">
      <div>
        <h1 class="font-bold text-[16px] tracking-tight">System Users</h1>
        <span class="text-[11px] text-gray-500">{{ filteredUsers.length }} users total - {{ adminCount }} admins - {{ salesCount }} sales</span>
      </div>
    </div>

    <!-- Filters Row - Search & Role LEFT | View Archive & Add User RIGHT -->
    <div class="bg-white px-4 py-1 flex items-center justify-between gap-2 shrink-0">
      <!-- Left: Search + Role Filter -->
      <div class="flex items-center gap-1.5">
        <!-- Search -->
        <div class="relative flex items-center">
          <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-[4px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Search by name or email..." 
            class="pl-7 pr-2 py-[2px] w-56 bg-white border border-gray-300 rounded-[4px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
          >
        </div>

        <!-- Role Filter -->
        <div class="relative">
          <button 
  @click="showRoleDropdown = !showRoleDropdown"
  :class="selectedRole !== 'All roles' ? 'border-[#F52C11] text-[#F52C11]' : 'border-gray-300 text-[#1F2835]'"
  class="bg-white border px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-2 hover:border-gray-400 transition-colors"
>
  {{ selectedRole }}
  <svg class="w-2.5 h-2.5 text-gray" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
  </svg>
</button>
          <div v-if="showRoleDropdown" class="absolute top-full left-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[140px]">
            <button 
              v-for="role in roleOptions" 
              :key="role"
              @click="selectedRole = role; showRoleDropdown = false"
              :class="selectedRole === role ? 'bg-[#F52C11]/10 text-[#F52C11] font-medium' : 'text-[#1F2835] hover:bg-gray-50'"
              class="w-full text-left px-3 py-1.5 text-[11px] transition-colors"
            >
              {{ role }}
            </button>
          </div>
        </div>
      </div>

      <!-- Right: View Archive + Add User -->
      <div class="flex items-center gap-1.5">
        <button 
          @click="showArchiveModal = true"
          class="bg-white border border-gray-300 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-3 py-[4px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
        >
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
          </svg>
          View Archive
          <span v-if="archivedUsers.length > 0" class="bg-[#F52C11] text-white text-[9px] px-1.5 py-[1px] rounded-full font-bold ml-0.5">{{ archivedUsers.length }}</span>
        </button>

        <button 
          @click="showAddUserModal = true"
          class="bg-[#F52C11] hover:bg-[#d9250e] text-white px-3 py-[4px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
        >
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          Add user
        </button>
      </div>
    </div>

    <!-- Main Content: Table Section -->
    <main class="flex-1 flex p-2 gap-1.5 min-h-0 overflow-hidden">
      <section class="flex-1 flex flex-col min-w-0 bg-white border border-gray-200 overflow-hidden relative rounded-[6px]">
        
        <!-- Table -->
        <div class="flex-1 overflow-auto custom-scroll relative">
          <table class="w-full border-collapse text-left">
            <thead class="bg-[#f2f2f2] sticky top-0 z-20">
              <tr>
                <th class="w-6 px-1.5 py-[3px] border border-gray-200 text-center">
                  <input 
                    type="checkbox" 
                    :checked="isAllSelected"
                    @change="toggleAll"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  >
                </th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Full Name</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Email</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Role</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Date added</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11] sticky right-0 z-30 bg-[#f2f2f2] shadow-[-2px_0_4px_rgba(0,0,0,0.05)]">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="user in filteredUsers" 
                :key="user.id"
                class="transition-colors"
                :class="{
                  'bg-[#F52C11]/15': isSelected(user.id),
                  'bg-white hover:bg-[#F52C11]/10': !isSelected(user.id)
                }"
              >
                <td class="px-1.5 py-[3px] border border-gray-200 text-center">
                  <input 
                    type="checkbox" 
                    :checked="isSelected(user.id)"
                    @change="toggleSelection(user.id)"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  >
                </td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ user.fullName }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ user.email }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap">
                  <span 
  class="inline-flex items-center px-1.5 py-[1px] rounded-[8px] text-[10px] font-semibold"
  :class="getRoleBadgeClass(user.role)"
>
  {{ user.role }}
</span>
                </td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ user.dateAdded }}</td>
                <td 
                   class="px-2 py-[3px] border border-gray-200 whitespace-nowrap sticky right-0 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] transition-colors"
                   :class="isSelected(user.id) ? 'bg-[#F52C11]/0' : 'bg-white hover:bg-[#F52C11]/0'"
                  >
                  <div class="flex items-center gap-1.5">
                    <!-- Edit Icon -->
                    <button @click="openEditModal(user)" class="text-gray-400 hover:text-[#F52C11] transition-colors" title="Edit">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                    
                    <!-- Lock Icon with Red Notification Dot -->
                    <button 
                      @click="openResetPasswordModal(user)"
                      class="relative text-gray-400 hover:text-amber-500 transition-colors" 
                      :title="user.passwordChanged ? 'User changed password - Click to reset' : 'Reset password'"
                    >
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                      </svg>
                      <!-- Red notification dot -->
                      <span 
                        v-if="user.passwordChanged"
                        class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full border border-white"
                      ></span>
                    </button>
                  </div>
                </td>
              </tr>
              
              <tr v-if="filteredUsers.length === 0">
                <td colspan="6" class="px-4 py-12 text-center text-gray-400 border border-gray-200">
                  <div v-if="searchQuery">
                    No users found matching "<span class="font-semibold text-[#1F2835]">{{ searchQuery }}</span>"
                  </div>
                  <div v-else>No users available</div>
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
            <span class="font-medium">{{ selectedCount }} user(s) selected</span>
          </div>
          <button 
            @click="archiveSelectedUsers"
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

    <!-- Add User Modal -->
    <div v-if="showAddUserModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white rounded-[8px] w-[480px] shadow-xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-white">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            <div>
              <h3 class="text-[14px] font-bold text-[#1F2835]">Add new user</h3>
              <p class="text-[10px] text-gray-400">Create a new system user account</p>
            </div>
          </div>
          <button @click="closeAddUserModal" class="text-gray-400 hover:text-[#1F2835] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="px-5 py-4 bg-white space-y-3">
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Full Name <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="newUser.fullName"
              type="text" 
              placeholder="Enter full name..."
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Email <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="newUser.email"
              type="email" 
              placeholder="Enter email address..."
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Role <span class="text-[#F52C11]">*</span>
            </label>
            <div class="relative">
              <select 
                v-model="newUser.role"
                class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors appearance-none cursor-pointer"
              >
                <option value="" disabled>Select a role...</option>
                <option value="Admin">Admin</option>
                <option value="Sales">Sales</option>
              </select>
              <svg class="w-3 h-3 text-[#F52C11] absolute right-2.5 top-[9px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>
          </div>

          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Password <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="newUser.password"
              type="password" 
              placeholder="Enter password..."
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Confirm Password <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="newUser.confirmPassword"
              type="password" 
              placeholder="Confirm password..."
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>
        </div>

        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-end gap-2 bg-white">
          <button 
            @click="closeAddUserModal" 
            class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
          >
            Cancel
          </button>
          <button 
            @click="addUser"
            :disabled="!isAddUserValid"
            :class="isAddUserValid ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
            class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium transition-colors shadow-sm"
          >
            Add user
          </button>
        </div>
      </div>
    </div>
    
    <!-- Reset Password Modal -->
    <div v-if="showResetPasswordModal && resettingUser" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-[2px]">
      <div class="bg-white rounded-[8px] w-[480px] shadow-2xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-white">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <div>
              <h3 class="text-[14px] font-bold text-[#1F2835]">Reset Password</h3>
              <p class="text-[10px] text-gray-400">{{ resettingUser.fullName }} – {{ resettingUser.email }}</p>
            </div>
          </div>
          <button @click="closeResetPasswordModal" class="text-gray-400 hover:text-[#1F2835] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="px-5 py-4 bg-white space-y-3">
          <div v-if="resettingUser.passwordChanged" class="bg-red-50 border border-red-200 rounded-[4px] px-3 py-2 flex items-start gap-2">
            <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
              <p class="text-[11px] font-medium text-red-700">Password Change Detected</p>
              <p class="text-[10px] text-red-600">This user has recently changed their password. You can reset it below.</p>
            </div>
          </div>

          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              New Password <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="resetPasswordData.newPassword"
              type="password" 
              placeholder="Enter new password..."
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Confirm New Password <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="resetPasswordData.confirmPassword"
              type="password" 
              placeholder="Confirm new password..."
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>
        </div>

        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-end gap-2 bg-white">
          <button 
            @click="closeResetPasswordModal" 
            class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
          >
            Cancel
          </button>
          <button 
            @click="resetUserPassword"
            :disabled="!isResetPasswordValid"
            :class="isResetPasswordValid ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
            class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium transition-colors shadow-sm"
          >
            Reset Password
          </button>
        </div>
      </div>
    </div>

    <!-- View Archive Modal -->
    <div v-if="showArchiveModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white rounded-[8px] w-[600px] max-h-[80vh] shadow-xl flex flex-col overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-white shrink-0">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <div>
              <h3 class="text-[14px] font-bold text-[#1F2835]">Archived Users</h3>
              <p class="text-[10px] text-gray-400">{{ archivedUsers.length }} archived user(s)</p>
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
          <div v-if="archivedUsers.length === 0" class="text-center py-12 text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-[12px]">No archived users yet</p>
          </div>

          <table v-else class="w-full border-collapse text-left">
            <thead class="bg-[#f2f2f2] sticky top-0 z-10">
              <tr>
                <th class="px-3 py-[6px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Full Name</th>
                <th class="px-3 py-[6px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Email</th>
                <th class="px-3 py-[6px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Role</th>
                <th class="px-3 py-[6px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Date archived</th>
                <th class="px-3 py-[6px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11] text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="user in archivedUsers" 
                :key="user.id"
                class="bg-white hover:bg-gray-50 transition-colors"
              >
                <td class="px-3 py-[6px] border border-gray-200 whitespace-nowrap text-[11px] font-medium text-[#1F2835]">{{ user.fullName }}</td>
                <td class="px-3 py-[6px] border border-gray-200 whitespace-nowrap text-[11px] text-gray-600">{{ user.email }}</td>
                <td class="px-3 py-[6px] border border-gray-200 whitespace-nowrap">
                  <span 
                    class="inline-flex items-center px-2 py-[1px] rounded-[4px] text-[10px] font-semibold border"
                    :class="getRoleBadgeClass(user.role)"
                  >
                    {{ user.role }}
                  </span>
                </td>
                <td class="px-3 py-[6px] border border-gray-200 whitespace-nowrap text-[11px] text-gray-500">{{ user.dateArchived }}</td>
                <td class="px-3 py-[6px] border border-gray-200 whitespace-nowrap text-center">
                  <button 
                    @click="unarchiveUser(user.id)"
                    class="text-gray-400 hover:text-green-600 transition-colors inline-flex items-center gap-1 text-[11px] font-medium"
                    title="Restore user"
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

    <!-- Click outside to close dropdowns -->
    <div 
      v-if="showRoleDropdown"
      class="fixed inset-0 z-40"
      @click="showRoleDropdown = false"
    ></div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')
const selectedRole = ref('All roles')
const selectedIds = ref([])

const showRoleDropdown = ref(false)
const showAddUserModal = ref(false)
const showEditModal = ref(false)
const showArchiveModal = ref(false)
const showResetPasswordModal = ref(false)
const editingUser = ref(null)
const resettingUser = ref(null)

const roleOptions = ['All roles', 'Admin', 'Sales']

const newUser = ref({
  fullName: '',
  email: '',
  role: '',
  password: '',
  confirmPassword: ''
})

const resetPasswordData = ref({
  newPassword: '',
  confirmPassword: ''
})

// Active users (with passwordChanged flag for demo)
const users = ref([
  { id: 1, fullName: 'Mabby RWEB', email: 'mabby@rweb.com', role: 'Admin', dateAdded: 'Jan 10, 2026', passwordChanged: false },
  { id: 2, fullName: 'Kef RWEB', email: 'kef@rweb.com', role: 'Sales', dateAdded: 'Feb 3, 2026', passwordChanged: true },
  { id: 3, fullName: 'Kent RWEB', email: 'kent@rweb.com', role: 'Sales', dateAdded: 'Mar 15, 2026', passwordChanged: false },
  { id: 4, fullName: 'Queen RWEB', email: 'queen@rweb.com', role: 'Admin', dateAdded: 'Apr 1, 2026', passwordChanged: true }
])

// Archived users storage
const archivedUsers = ref([])

const filteredUsers = computed(() => {
  let result = users.value
  
  const q = searchQuery.value.trim().toLowerCase()
  if (q) {
    result = result.filter(u => 
      u.fullName.toLowerCase().includes(q) || 
      u.email.toLowerCase().includes(q)
    )
  }
  
  if (selectedRole.value !== 'All roles') {
    result = result.filter(u => u.role === selectedRole.value)
  }
  
  return result
})

const adminCount = computed(() => users.value.filter(u => u.role === 'Admin').length)
const salesCount = computed(() => users.value.filter(u => u.role === 'Sales').length)

const selectedCount = computed(() => selectedIds.value.length)
const isAllSelected = computed(() => {
  return filteredUsers.value.length > 0 && filteredUsers.value.every(u => selectedIds.value.includes(u.id))
})

const isAddUserValid = computed(() => {
  return newUser.value.fullName.trim() && 
         newUser.value.email.trim() && 
         newUser.value.role && 
         newUser.value.password.trim() && 
         newUser.value.confirmPassword.trim() &&
         newUser.value.password === newUser.value.confirmPassword
})

const isResetPasswordValid = computed(() => {
  return resetPasswordData.value.newPassword.trim() && 
         resetPasswordData.value.confirmPassword.trim() &&
         resetPasswordData.value.newPassword === resetPasswordData.value.confirmPassword
})

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
  const visibleIds = filteredUsers.value.map(u => u.id)
  const allVisibleSelected = visibleIds.every(id => selectedIds.value.includes(id))
  
  if (allVisibleSelected) {
    selectedIds.value = selectedIds.value.filter(id => !visibleIds.includes(id))
  } else {
    const newIds = visibleIds.filter(id => !selectedIds.value.includes(id))
    selectedIds.value.push(...newIds)
  }
}

function getRoleBadgeClass(role) {
  const map = {
    'Admin': 'bg-red-100 text-red-600',
    'Sales': 'bg-green-100 text-green-600'
  }
  return map[role] || 'bg-gray-100 text-gray-700 border-gray-200'
}

function openEditModal(user) {
  editingUser.value = { ...user }
  showEditModal.value = true
}

function closeEditModal() {
  showEditModal.value = false
  editingUser.value = null
}

function saveEditChanges() {
  if (!editingUser.value) return
  
  const idx = users.value.findIndex(u => u.id === editingUser.value.id)
  if (idx > -1) {
    users.value[idx] = { ...editingUser.value }
  }
  closeEditModal()
}

// Open Reset Password Modal
function openResetPasswordModal(user) {
  resettingUser.value = { ...user }
  resetPasswordData.value = { newPassword: '', confirmPassword: '' }
  showResetPasswordModal.value = true
}

function closeResetPasswordModal() {
  showResetPasswordModal.value = false
  resettingUser.value = null
  resetPasswordData.value = { newPassword: '', confirmPassword: '' }
}

// Reset user password and clear the passwordChanged flag
function resetUserPassword() {
  if (!isResetPasswordValid.value || !resettingUser.value) return
  
  const idx = users.value.findIndex(u => u.id === resettingUser.value.id)
  if (idx > -1) {
    users.value[idx].passwordChanged = false
  }
  
  closeResetPasswordModal()
}

function deleteUser(id) {
  const idx = users.value.findIndex(u => u.id === id)
  if (idx > -1) {
    users.value.splice(idx, 1)
  }
  selectedIds.value = selectedIds.value.filter(sid => sid !== id)
}

// Archive single user
function archiveUser(id) {
  const idx = users.value.findIndex(u => u.id === id)
  if (idx > -1) {
    const user = users.value[idx]
    const now = new Date()
    const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
    
    archivedUsers.value.push({
      ...user,
      dateArchived: dateStr
    })
    
    users.value.splice(idx, 1)
    selectedIds.value = selectedIds.value.filter(sid => sid !== id)
  }
}

// Archive selected users
function archiveSelectedUsers() {
  const idsToArchive = new Set(selectedIds.value)
  const usersToArchive = users.value.filter(u => idsToArchive.has(u.id))
  
  const now = new Date()
  const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
  
  usersToArchive.forEach(user => {
    archivedUsers.value.push({
      ...user,
      dateArchived: dateStr
    })
  })
  
  users.value = users.value.filter(u => !idsToArchive.has(u.id))
  selectedIds.value = []
}

// Unarchive / Restore user
function unarchiveUser(id) {
  const idx = archivedUsers.value.findIndex(u => u.id === id)
  if (idx > -1) {
    const user = archivedUsers.value[idx]
    const { dateArchived, ...restoredUser } = user
    
    users.value.push(restoredUser)
    archivedUsers.value.splice(idx, 1)
  }
}

function closeAddUserModal() {
  showAddUserModal.value = false
  newUser.value = {
    fullName: '',
    email: '',
    role: '',
    password: '',
    confirmPassword: ''
  }
}

function addUser() {
  if (!isAddUserValid.value) return
  
  const now = new Date()
  const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
  
  const newId = Math.max(...users.value.map(u => u.id), ...archivedUsers.value.map(u => u.id), 0) + 1
  
  users.value.push({
    id: newId,
    fullName: newUser.value.fullName.trim(),
    email: newUser.value.email.trim(),
    role: newUser.value.role,
    dateAdded: dateStr,
    passwordChanged: false
  })
  
  closeAddUserModal()
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap');

.custom-scroll::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
table th,
table td {
  border-left: none !important;
  border-right: none !important;
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
</style>