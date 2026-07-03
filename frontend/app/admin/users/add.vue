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
        <span class="text-[#F52C11] font-medium">Add User</span>
      </div>
    </div>

    <!-- Main Content - Aligned Left -->
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
                  placeholder="First name"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
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
                  placeholder="Last name"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
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
                  placeholder="example@company.com"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.email ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]'
                  ]"
                >
                <p v-if="errors.email" class="text-[8px] text-[#F52C11] mt-0.5">Email is required</p>
                <p v-else class="text-[8px] text-gray-400 mt-0.5">Changing the email will update the user's login credentials.</p>
              </div>

              <!-- Date added with clickable calendar icon -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Date added
                </label>
                <div class="relative">
                  <input 
                    v-model="form.dateAdded"
                    type="text" 
                    placeholder="-- -- ----"
                    readonly
                    class="w-full bg-gray-100 border border-gray-200 rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer"
                    @click="showDatePicker = true"
                  >
                  <button 
                    @click="showDatePicker = true"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F52C11] transition-colors"
                    type="button"
                  >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </button>
                </div>
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
              <!-- Create Password -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Create Password
                </label>
                <input 
                  v-model="form.password"
                  type="password" 
                  placeholder="Create a password"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.password ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]'
                  ]"
                >
                <p v-if="errors.password" class="text-[8px] text-[#F52C11] mt-0.5">Password is required</p>
                <p v-else-if="passwordReminder" class="text-[8px] text-[#F52C11] mt-0.5">Please create a password first</p>
              </div>

              <!-- Confirm Password -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Confirm Password <span class="text-[#F52C11]">*</span>
                </label>
                <input 
                  v-model="form.confirmPassword"
                  type="password" 
                  placeholder="Re-enter new password"
                  :disabled="!form.password"
                  :class="[
                    'w-full border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    !form.password ? 'bg-gray-100 cursor-not-allowed border-gray-200' : 'bg-white border-gray-200 focus:border-[#F52C11]',
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
              <!-- Assign role -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Assign role <span class="text-[#F52C11]">*</span>
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
                    <option value="" disabled>- Please select -</option>
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
              @click="cancel"
              class="px-3 py-[4px] rounded-[4px] text-[10px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
            >
              Cancel
            </button>
            <button 
              @click="createUser"
              :disabled="!isFormValid"
              :class="[
                'px-3 py-[4px] rounded-[4px] text-[10px] font-medium flex items-center gap-1 transition-colors shadow-sm',
                isFormValid ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'
              ]"
            >
              Create User
            </button>
          </div>
        </div>

      </div>
    </main>

    <!-- Date Picker Modal -->
    <div v-if="showDatePicker" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50" @click.self="showDatePicker = false">
      <div class="bg-white rounded-[8px] w-[280px] shadow-xl p-4">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-[13px] font-bold text-[#1F2835]">Select Date</h3>
          <button @click="showDatePicker = false" class="text-gray-400 hover:text-[#1F2835]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        
        <!-- Month/Year Navigation -->
        <div class="flex items-center justify-between mb-2">
          <button @click="prevMonth" class="p-1 hover:bg-gray-100 rounded text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          <span class="text-[12px] font-semibold text-[#1F2835]">{{ currentMonthYear }}</span>
          <button @click="nextMonth" class="p-1 hover:bg-gray-100 rounded text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-0.5 mb-1">
          <div v-for="day in ['S','M','T','W','T','F','S']" :key="day" class="text-center text-[9px] font-semibold text-gray-400 py-1">
            {{ day }}
          </div>
        </div>
        <div class="grid grid-cols-7 gap-0.5">
          <div 
            v-for="date in calendarDates" 
            :key="date.key"
            @click="selectDate(date)"
            :class="[
              'text-center text-[11px] py-1 rounded cursor-pointer transition-colors',
              date.isCurrentMonth ? 'text-[#1F2835]' : 'text-gray-300',
              date.isSelected ? 'bg-[#F52C11] text-white' : 'hover:bg-gray-100',
              date.isToday && !date.isSelected ? 'border border-[#F52C11] text-[#F52C11]' : ''
            ]"
          >
            {{ date.day }}
          </div>
        </div>

        <div class="flex items-center justify-end gap-2 mt-3 pt-2 border-t border-gray-100">
          <button 
            @click="showDatePicker = false"
            class="px-3 py-[4px] rounded-[4px] text-[10px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
          >
            Cancel
          </button>
          <button 
            @click="confirmDate"
            class="bg-[#F52C11] hover:bg-[#d9250e] text-white px-3 py-[4px] rounded-[4px] text-[10px] font-medium transition-colors"
          >
            OK
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  password: '',
  confirmPassword: '',
  role: '',
  dateAdded: ''
})

const errors = ref({
  firstName: false,
  lastName: false,
  email: false,
  password: false,
  confirmPassword: false,
  role: false
})

const showDatePicker = ref(false)
const selectedDate = ref(null)
const viewDate = ref(new Date())
const passwordReminder = ref(false)

const currentMonthYear = computed(() => {
  return viewDate.value.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
})

const calendarDates = computed(() => {
  const year = viewDate.value.getFullYear()
  const month = viewDate.value.getMonth()
  
  const firstDay = new Date(year, month, 1)
  const lastDay = new Date(year, month + 1, 0)
  const startDayOfWeek = firstDay.getDay()
  
  const dates = []
  const today = new Date()
  
  // Previous month padding
  const prevMonthLastDay = new Date(year, month, 0).getDate()
  for (let i = startDayOfWeek - 1; i >= 0; i--) {
    dates.push({
      key: `prev-${i}`,
      day: prevMonthLastDay - i,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false
    })
  }
  
  // Current month
  for (let day = 1; day <= lastDay.getDate(); day++) {
    const dateObj = new Date(year, month, day)
    const isToday = dateObj.toDateString() === today.toDateString()
    const isSelected = selectedDate.value && dateObj.toDateString() === selectedDate.value.toDateString()
    
    dates.push({
      key: `current-${day}`,
      day,
      isCurrentMonth: true,
      isSelected,
      isToday,
      dateObj
    })
  }
  
  // Next month padding
  const remaining = 42 - dates.length
  for (let day = 1; day <= remaining; day++) {
    dates.push({
      key: `next-${day}`,
      day,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false
    })
  }
  
  return dates
})

function prevMonth() {
  viewDate.value = new Date(viewDate.value.getFullYear(), viewDate.value.getMonth() - 1, 1)
}

function nextMonth() {
  viewDate.value = new Date(viewDate.value.getFullYear(), viewDate.value.getMonth() + 1, 1)
}

function selectDate(date) {
  if (!date.isCurrentMonth) {
    if (date.day > 20) {
      prevMonth()
    } else {
      nextMonth()
    }
    return
  }
  selectedDate.value = date.dateObj
}

function confirmDate() {
  if (selectedDate.value) {
    form.value.dateAdded = selectedDate.value.toLocaleDateString('en-US', { 
      month: 'long', 
      day: 'numeric', 
      year: 'numeric' 
    })
  }
  showDatePicker.value = false
}

function checkPasswordFirst() {
  if (!form.value.password) {
    passwordReminder.value = true
    setTimeout(() => {
      passwordReminder.value = false
    }, 3000)
  }
}

const permissions = ref([
  { name: 'User Management', view: false, edit: false, add: false },
  { name: 'Industry', view: false, edit: false, add: false },
  { name: 'Performance Improvement Plan', view: false, edit: false, add: false },
  { name: 'Sales Task', view: false, edit: false, add: false },
  { name: 'Audit Logs', view: false, edit: false, add: false }
])

const isFormValid = computed(() => {
  return form.value.firstName.trim() &&
         form.value.lastName.trim() &&
         form.value.email.trim() &&
         form.value.password.trim() &&
         form.value.confirmPassword.trim() &&
         form.value.password === form.value.confirmPassword &&
         form.value.role
})

function validateForm() {
  errors.value.firstName = !form.value.firstName.trim()
  errors.value.lastName = !form.value.lastName.trim()
  errors.value.email = !form.value.email.trim()
  errors.value.password = !form.value.password.trim()
  errors.value.confirmPassword = !form.value.confirmPassword.trim() || form.value.password !== form.value.confirmPassword
  errors.value.role = !form.value.role
  
  return !Object.values(errors.value).some(error => error)
}

function cancel() {
  form.value = {
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    confirmPassword: '',
    role: '',
    dateAdded: ''
  }
  selectedDate.value = null
  passwordReminder.value = false
  permissions.value.forEach(p => {
    p.view = false
    p.edit = false
    p.add = false
  })
  resetErrors()
}

function resetErrors() {
  errors.value = {
    firstName: false,
    lastName: false,
    email: false,
    password: false,
    confirmPassword: false,
    role: false
  }
}
 
function createUser() {
  if (!validateForm()) return
  console.log('Created', form.value, permissions.value)
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap');

input[type="checkbox"] {
  accent-color: #F52C11;
}
</style>