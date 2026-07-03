<template>
  <div class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#e5e5e5] font-['Overpass'] text-[13px] text-[#1F2835]">

    <!-- Top Header: Breadcrumb -->
    <div class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200">
      <div class="flex items-center text-[10px] text-gray-500 gap-1">
        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span class="cursor-pointer transition-colors hover:text-[#F52C11]">User Management</span>
        <svg class="w-2.5 h-2.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#F52C11] font-medium">Edit User</span>
      </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-3 flex items-start justify-start overflow-hidden">
      <div class="w-full max-w-[860px] space-y-2">

        <!-- Account Information Card -->
        <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden">
          <!-- Card Header -->
          <div class="flex items-center gap-1.5 px-3 py-1.5">
            <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
              <svg class="w-2.5 h-2.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <div>
              <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">Account information</h2>
              <p class="text-[9px] text-gray-400 leading-tight">Basic profile details</p>
            </div>
          </div>

          <!-- Form Fields -->
          <div class="px-3 pb-2.5">
            <div class="grid grid-cols-2 gap-3">
              <!-- First name -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  First name <span class="text-[#F52C11]">*</span>
                </label>
                <input 
                  v-model="form.firstName"
                  type="text" 
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] focus:outline-none transition-colors',
                    errors.firstName ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]'
                  ]"
                >
                <p v-if="errors.firstName" class="text-[8px] text-[#F52C11] mt-0.5">First name is required</p>
              </div>

              <!-- Last name -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Last name <span class="text-[#F52C11]">*</span>
                </label>
                <input 
                  v-model="form.lastName"
                  type="text" 
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] focus:outline-none transition-colors',
                    errors.lastName ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]'
                  ]"
                >
                <p v-if="errors.lastName" class="text-[8px] text-[#F52C11] mt-0.5">Last name is required</p>
              </div>

              <!-- Email address -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Email address <span class="text-[#F52C11]">*</span>
                </label>
                <input 
                  v-model="form.email"
                  type="email" 
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] focus:outline-none transition-colors',
                    errors.email ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]'
                  ]"
                >
                <p v-if="errors.email" class="text-[8px] text-[#F52C11] mt-0.5">Email is required</p>
                <p v-else class="text-[8px] text-gray-400 mt-0.5">Changing the email will update the user's login credentials.</p>
              </div>

              <!-- Date added (read-only) -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Date added
                </label>
                <input 
  v-model="form.dateAdded"
  type="text" 
  :class="[
    'w-full bg-gray-100 border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] focus:outline-none transition-colors',
    errors.dateAdded ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]'
  ]"
>
<p v-if="errors.dateAdded" class="text-[8px] text-[#F52C11] mt-0.5">Date added is required</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Password Settings Card -->
        <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden">
          <!-- Card Header -->
          <div class="flex items-center gap-1.5 px-3 py-1.5">
            <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
              <svg class="w-2.5 h-2.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <div>
              <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">Password settings</h2>
              <p class="text-[9px] text-gray-400 leading-tight">Password security details</p>
            </div>
          </div>
 
          <!-- Form Fields -->
          <div class="px-3 pb-2.5">
            <div class="grid grid-cols-2 gap-3">
              <!-- New Password -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  New Password
                </label>
                <input 
                  v-model="form.newPassword"
                  type="password" 
                  placeholder="Leave blank to keep current password"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.newPassword ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]'
                  ]"
                >
                <p v-if="errors.newPassword" class="text-[8px] text-[#F52C11] mt-0.5">Password is required</p>
                <p v-else-if="passwordReminder" class="text-[8px] text-[#F52C11] mt-0.5">Please create a password first</p>
              </div>

              <!-- Confirm New Password -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Confirm New Password <span class="text-[#F52C11]">*</span>
                </label>
                <input 
                  v-model="form.confirmPassword"
                  type="password" 
                  placeholder="Re-enter new password"
                  :disabled="!form.newPassword"
                  :class="[
                    'w-full border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    !form.newPassword ? 'bg-gray-100 cursor-not-allowed border-gray-200' : 'bg-white border-gray-200 focus:border-[#F52C11]',
                    errors.confirmPassword ? 'border-[#F52C11]' : ''
                  ]"
                  @focus="checkPasswordFirst"
                >
                <p v-if="errors.confirmPassword" class="text-[8px] text-[#F52C11] mt-0.5">Passwords do not match</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Role & Permissions Card -->
        <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden flex flex-col">
          <!-- Card Header -->
          <div class="flex items-center gap-1.5 px-3 py-1.5">
            <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
              <svg class="w-2.5 h-2.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
              </svg>
            </div>
            <div>
              <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">Role & permissions</h2>
              <p class="text-[9px] text-gray-400 leading-tight">Controls what this user can access and do</p>
            </div>
          </div>

          <!-- Form Fields -->
          <div class="px-3 pb-2">
            <div class="grid grid-cols-2 gap-4">
              <!-- Assigned role -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Assigned role <span class="text-[#F52C11]">*</span>
                </label>
                <div class="relative">
                  <select 
                    v-model="form.role"
                    :class="[
                      'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors appearance-none cursor-pointer',
                      errors.role ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                      form.role ? 'text-[#1F2835]' : 'text-gray-400'
                    ]"
                  >
                    <option value="Admin">Admin</option>
                    <option value="Sales">Sales</option>
                  </select>
                  <svg class="w-2.5 h-2.5 text-[#F52C11] absolute right-2.5 top-[7px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </div>
                <p v-if="errors.role" class="text-[8px] text-[#F52C11] mt-0.5">Role is required</p>
              </div>

              <!-- Permissions Table -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-1">
                  Permissions
                </label>
                <div class="border border-gray-200 rounded-[4px] overflow-hidden">
                  <table class="w-full border-collapse">
                    <thead>
                      <tr class="border-b border-gray-200">
                        <th class="text-left px-2 py-[3px] text-[9px] font-semibold text-[#F52C11]">Module</th>
                        <th class="text-center px-1.5 py-[3px] text-[9px] font-semibold text-[#F52C11] w-8">View</th>
                        <th class="text-center px-1.5 py-[3px] text-[9px] font-semibold text-[#F52C11] w-8">Edit</th>
                        <th class="text-center px-1.5 py-[3px] text-[9px] font-semibold text-[#F52C11] w-8">Add</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr 
                        v-for="module in permissions" 
                        :key="module.name"
                        class="border-b border-gray-100 last:border-b-0"
                      >
                        <td class="px-2 py-[3px] text-[10px] text-[#1F2835]">{{ module.name }}</td>
                        <td class="px-1.5 py-[3px] text-center">
                          <input 
                            type="checkbox" 
                            v-model="module.view"
                            class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                          >
                        </td>
                        <td class="px-1.5 py-[3px] text-center">
                          <input 
                            type="checkbox" 
                            v-model="module.edit"
                            class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                          >
                        </td>
                        <td class="px-1.5 py-[3px] text-center">
                          <input 
                            type="checkbox" 
                            v-model="module.add"
                            class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="px-3 py-2 border-t border-gray-100 flex items-center justify-end gap-2">
            <button 
              @click="discardChanges"
              class="px-3 py-[4px] rounded-[4px] text-[10px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
            >
              Discard
            </button>
            <button 
              @click="saveChanges"
              :disabled="!isFormValid"
              :class="[
                'px-3 py-[4px] rounded-[4px] text-[10px] font-medium flex items-center gap-1 transition-colors shadow-sm',
                isFormValid ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'
              ]"
            >
              <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              Save changes
            </button>
          </div>
        </div>

      </div>
    </main>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const form = ref({
  firstName: 'Mabby',
  lastName: 'RWEB',
  email: 'mabby@rweb.com',
  dateAdded: 'January 10, 2026',
  newPassword: '',
  confirmPassword: '',
  role: 'Admin'
})

const errors = ref({
  firstName: false,
  lastName: false,
  email: false,
  newPassword: false,
  confirmPassword: false,
  role: false,
  dateAdded: false  // <-- add this
})

const passwordReminder = ref(false)

const permissions = ref([
  { name: 'User Management', view: true, edit: true, add: true },
  { name: 'Industry', view: true, edit: true, add: true },
  { name: 'Performance Improvement Plan', view: true, edit: true, add: true },
  { name: 'Sales Task', view: true, edit: true, add: true },
  { name: 'Audit Logs', view: true, edit: true, add: true }
])

const isFormValid = computed(() => {
  return form.value.firstName.trim() &&
         form.value.lastName.trim() &&
         form.value.email.trim() &&
         form.value.role
})

function checkPasswordFirst() {
  if (!form.value.newPassword) {
    passwordReminder.value = true
    setTimeout(() => {
      passwordReminder.value = false
    }, 3000)
  }
}

function validateForm() {
  errors.value.firstName = !form.value.firstName.trim()
  errors.value.lastName = !form.value.lastName.trim()
  errors.value.email = !form.value.email.trim()
  errors.value.role = !form.value.role
  errors.value.dateAdded = !form.value.dateAdded.trim()
  
  // Password validation only if user is trying to change password
  if (form.value.newPassword || form.value.confirmPassword) {
    errors.value.newPassword = !form.value.newPassword.trim()
    errors.value.confirmPassword = !form.value.confirmPassword.trim() || form.value.newPassword !== form.value.confirmPassword
  } else {
    errors.value.newPassword = false
    errors.value.confirmPassword = false
  }
  
  return !Object.values(errors.value).some(error => error)
}

function resetErrors() {
  errors.value = {
    firstName: false,
    lastName: false,
    email: false,
    newPassword: false,
    confirmPassword: false,
    role: false
  }
}

function discardChanges() {
  console.log('Discarded')
}

function saveChanges() {
  if (!validateForm()) return
  console.log('Saved', form.value, permissions.value)
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap');

input[type="checkbox"] {
  accent-color: #F52C11;
}
</style>