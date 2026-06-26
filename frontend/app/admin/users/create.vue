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
        
        <!-- Title -->
        <div class="mb-3 shrink-0">
          <h1 class="font-bold text-[18px]">Add User</h1>
          <p class="text-[11px] text-gray-500">Add a new user for your account</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white border border-gray-300 rounded-[8px] p-4 flex-1 flex flex-col min-h-0">
          <div class="space-y-2">

            <!-- Role -->
            <div>
              <label class="block text-[11px] text-black-600 font-extrabold mb-0 uppercase tracking-wide">Role</label>
              <div class="relative">
                <select 
                  v-model="form.role"
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all appearance-none cursor-pointer"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.role, 'text-gray-400': !form.role }"
                >
                  <option value="" disabled>Select Role</option>
                  <option>Admin</option>
                  <option>Sales</option>
                </select>
                <svg class="w-3.5 h-3.5 text-gray-400 absolute right-2 top-1.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
              </div>
              <p v-if="errors.role" class="text-[10px] text-red-500 mt-0">{{ errors.role }}</p>
            </div>

            <!-- Full Name -->
            <div>
              <label class="block text-[11px] text-black-600 font-bold mb-0 uppercase tracking-wide">Full Name</label>
              <input 
                v-model="form.fullName"
                type="text" 
                placeholder="Enter full name"
                class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                :class="{ 'border-red-500 ring-1 ring-red-200': errors.fullName }"
              >
              <p v-if="errors.fullName" class="text-[10px] text-red-500 mt-0">{{ errors.fullName }}</p>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-[11px] text-black-600 font-bold mb-0 uppercase tracking-wide">Email</label>
              <input 
                v-model="form.email"
                type="email" 
                placeholder="Enter email address"
                class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                :class="{ 'border-red-500 ring-1 ring-red-200': errors.email }"
              >
              <p v-if="errors.email" class="text-[10px] text-red-500 mt-0">{{ errors.email }}</p>
            </div>

            <!-- Contact Number -->
            <div>
              <label class="block text-[11px] text-black-600 font-bold mb-0 uppercase tracking-wide">Contact Number</label>
              <input 
                v-model="form.contactNumber"
                type="tel" 
                placeholder="Enter contact number"
                @input="onlyNumbers"
                class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                :class="{ 'border-red-500 ring-1 ring-red-200': errors.contactNumber }"
              >
              <p v-if="errors.contactNumber" class="text-[10px] text-red-500 mt-0">{{ errors.contactNumber }}</p>
            </div>

            <!-- Password & Confirm Password -->
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] text-black-600 font-bold mb-0 uppercase tracking-wide">Password</label>
                <div class="relative">
                  <input 
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'" 
                    placeholder="Enter password"
                    class="w-full px-2 pr-8 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                    :class="{ 'border-red-500 ring-1 ring-red-200': errors.password }"
                  >
                  <button 
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-2 top-1.5 text-gray-400 hover:text-gray-600"
                  >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path v-if="!showPassword" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path v-if="!showPassword" stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      <path v-if="showPassword" stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.974M9.88 9.88l3.29-3.29m2.476 2.476l3.29-3.29M3 3l18 18"/>
                    </svg>
                  </button>
                </div>
                <p v-if="errors.password" class="text-[10px] text-red-500 mt-0">{{ errors.password }}</p>
              </div>

              <div>
                <label class="block text-[11px] text-black-600 font-bold mb-0 uppercase tracking-wide">Confirm Password</label>
                <div class="relative">
                  <input 
                    v-model="form.confirmPassword"
                    :type="showConfirmPassword ? 'text' : 'password'" 
                    placeholder="Confirm password"
                    class="w-full px-2 pr-8 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                    :class="{ 'border-red-500 ring-1 ring-red-200': errors.confirmPassword }"
                  >
                  <button 
                    type="button"
                    @click="showConfirmPassword = !showConfirmPassword"
                    class="absolute right-2 top-1.5 text-gray-400 hover:text-gray-600"
                  >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path v-if="!showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path v-if="!showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      <path v-if="showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.974M9.88 9.88l3.29-3.29m2.476 2.476l3.29-3.29M3 3l18 18"/>
                    </svg>
                  </button>
                </div>
                <p v-if="errors.confirmPassword" class="text-[10px] text-red-500 mt-0">{{ errors.confirmPassword }}</p>
              </div>
            </div>

          </div>

          <!-- Buttons -->
          <div class="flex items-center justify-end gap-2 mt-4 pt-3 border-t border-gray-200 shrink-0">
            <button 
              @click="cancel"
              class="px-5 py-1.5 border border-gray-300 rounded-[4px] text-gray-700 hover:bg-gray-50 transition-colors font-medium text-[13px]"
            >
              Cancel
            </button>
            <button 
              @click="save"
              class="px-5 py-1.5 bg-[#f52c11] hover:bg-[#e5630e] active:bg-[#cc570d] text-white rounded-[4px] font-medium text-[13px] transition-colors"
            >
              Save User
            </button>
          </div>

        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
  role: '',
  fullName: '',
  email: '',
  contactNumber: '',
  password: '',
  confirmPassword: ''
})

const errors = ref({})
const showPassword = ref(false)
const showConfirmPassword = ref(false)

function onlyNumbers(e) {
  const val = e.target.value
  e.target.value = val.replace(/\D/g, '')
  form.value.contactNumber = e.target.value
}

function validateForm() {
  errors.value = {}
  let isValid = true

  const requiredFields = ['role', 'fullName', 'email', 'contactNumber', 'password', 'confirmPassword']

  requiredFields.forEach(field => {
    if (!form.value[field] || String(form.value[field]).trim() === '') {
      errors.value[field] = 'This field is required'
      isValid = false
    }
  })

  if (form.value.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
    errors.value.email = 'Please enter a valid email'
    isValid = false
  }

  if (form.value.password && form.value.confirmPassword && form.value.password !== form.value.confirmPassword) {
    errors.value.confirmPassword = 'Passwords do not match'
    isValid = false
  }

  return isValid
}

function save() {
  if (!validateForm()) return
  console.log('Saving user:', form.value)
  navigateTo('/admin/users')
}

function cancel() {
  navigateTo('/admin/users')
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&display=swap');

select {
  background-image: none;
}
</style>