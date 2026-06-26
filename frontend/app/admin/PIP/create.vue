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
      <div class="max-w-5xl mx-auto w-full flex-1 flex flex-col min-h-0">
        
        <!-- Title -->
        <h1 class="font-bold text-[15px] mb-2 shrink-0">Add New Record</h1>

        <!-- Form Card -->
        <div class="bg-white border border-gray-300 rounded-[8px] p-3 flex-1 flex flex-col min-h-0">
          <div class="grid grid-cols-2 gap-x-5 gap-y-1.5 flex-1 min-h-0">

            <!-- Left Column -->
            <div class="space-y-1.5">
              
              <!-- Date Recorded -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Date Recorded</label>
                <input 
                  v-model="form.dateRecorded"
                  type="date" 
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all cursor-pointer"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.dateRecorded }"
                >
                <p v-if="errors.dateRecorded" class="text-[10px] text-red-500 mt-0">{{ errors.dateRecorded }}</p>
              </div>

              <!-- Client Name -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Client Name</label>
                <input 
                  v-model="form.clientName"
                  type="text" 
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.clientName }"
                >
                <p v-if="errors.clientName" class="text-[10px] text-red-500 mt-0">{{ errors.clientName }}</p>
              </div>

              <!-- Email -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Email</label>
                <input 
                  v-model="form.email"
                  type="email" 
                  placeholder="example@company.com"
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.email }"
                >
                <p v-if="errors.email" class="text-[10px] text-red-500 mt-0">{{ errors.email }}</p>
              </div>

              <!-- Service (6 options + Add at bottom) -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Service</label>
                <div class="relative">
                  <select 
                    v-model="form.service"
                    class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all appearance-none cursor-pointer"
                    :class="{ 'border-red-500 ring-1 ring-red-200': errors.service }"
                  >
                    <option value="" disabled>Select a service</option>
                    <option v-for="svc in services" :key="svc" :value="svc">{{ svc }}</option>
                    <option value="__add__" class="text-[#fa6f10] font-medium">+ Add new service</option>
                  </select>
                  <svg class="w-3.5 h-3.5 text-gray-400 absolute right-2 top-1.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </div>
                <!-- Inline Add Service Input -->
                <div v-if="showAddService" class="mt-1 flex gap-1.5">
                  <input 
                    v-model="newServiceName"
                    ref="serviceInput"
                    type="text" 
                    placeholder="Type new service..."
                    class="flex-1 px-2 py-1 bg-white border border-[#fa6f10] rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30"
                    @keyup.enter="confirmAddService"
                  >
                  <button @click="confirmAddService" class="px-2 py-1 bg-[#fa6f10] text-white rounded-[4px] text-[12px] font-medium">Add</button>
                  <button @click="cancelAddService" class="px-2 py-1 border border-gray-300 rounded-[4px] text-[12px]">✕</button>
                </div>
                <p v-if="errors.service" class="text-[10px] text-red-500 mt-0">{{ errors.service }}</p>
              </div>

              <!-- Status (Percentage Slider) -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Status</label>
                <div class="flex items-center gap-2">
                  <div class="flex-1 relative">
                    <input 
                      v-model.number="form.status"
                      type="range" 
                      min="0" 
                      max="100" 
                      class="w-full h-1.5 bg-gray-300 rounded-lg appearance-none cursor-pointer accent-[#fa6f10]"
                      :class="{ 'accent-red-500': errors.status }"
                    >
                  </div>
                  <div class="w-14 relative">
                    <input 
                      v-model.number="form.status"
                      type="number" 
                      min="0" 
                      max="100" 
                      class="w-full px-1 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] text-center focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                      :class="{ 'border-red-500 ring-1 ring-red-200': errors.status }"
                    >
                    <span class="absolute right-1 top-1 text-gray-500 text-[10px]">%</span>
                  </div>
                </div>
                <div class="w-full h-1 bg-gray-200 rounded-full mt-1 overflow-hidden border border-gray-300">
                  <div class="h-full bg-green-600 rounded-full transition-all duration-300" :style="{ width: (form.status || 0) + '%' }"></div>
                </div>
                <p v-if="errors.status" class="text-[10px] text-red-500 mt-0">{{ errors.status }}</p>
              </div>

              <!-- Area -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Area</label>
                <input 
                  v-model="form.area"
                  type="text" 
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.area }"
                >
                <p v-if="errors.area" class="text-[10px] text-red-500 mt-0">{{ errors.area }}</p>
              </div>

            </div>

            <!-- Right Column -->
            <div class="space-y-1.5">
              
              <!-- Sales Representative -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Sales Representative</label>
                <input 
                  v-model="form.salesRep"
                  type="text" 
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.salesRep }"
                >
                <p v-if="errors.salesRep" class="text-[10px] text-red-500 mt-0">{{ errors.salesRep }}</p>
              </div>

              <!-- Onboarding Date -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Onboarding Date</label>
                <input 
                  v-model="form.onboardingDate"
                  type="date" 
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all cursor-pointer"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.onboardingDate }"
                >
                <p v-if="errors.onboardingDate" class="text-[10px] text-red-500 mt-0">{{ errors.onboardingDate }}</p>
              </div>

              <!-- Remarks -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Remarks</label>
                <textarea 
                  v-model="form.remarks"
                  rows="2"
                  class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all resize-none"
                  :class="{ 'border-red-500 ring-1 ring-red-200': errors.remarks }"
                ></textarea>
                <p v-if="errors.remarks" class="text-[10px] text-red-500 mt-0">{{ errors.remarks }}</p>
              </div>

              <!-- Prospect Technique (10 options + Add at bottom) -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Prospect Technique</label>
                <div class="relative">
                  <select 
                    v-model="form.prospectTechnique"
                    class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all appearance-none cursor-pointer"
                    :class="{ 'border-red-500 ring-1 ring-red-200': errors.prospectTechnique }"
                  >
                    <option value="" disabled>Select technique</option>
                    <option v-for="tech in prospectTechniques" :key="tech" :value="tech">{{ tech }}</option>
                    <option value="__add__" class="text-[#fa6f10] font-medium">+ Add new technique</option>
                  </select>
                  <svg class="w-3.5 h-3.5 text-gray-400 absolute right-2 top-1.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </div>
                <!-- Inline Add Technique Input -->
                <div v-if="showAddTechnique" class="mt-1 flex gap-1.5">
                  <input 
                    v-model="newTechniqueName"
                    ref="techniqueInput"
                    type="text" 
                    placeholder="Type new technique..."
                    class="flex-1 px-2 py-1 bg-white border border-[#fa6f10] rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30"
                    @keyup.enter="confirmAddTechnique"
                  >
                  <button @click="confirmAddTechnique" class="px-2 py-1 bg-[#fa6f10] text-white rounded-[4px] text-[12px] font-medium">Add</button>
                  <button @click="cancelAddTechnique" class="px-2 py-1 border border-gray-300 rounded-[4px] text-[12px]">✕</button>
                </div>
                <p v-if="errors.prospectTechnique" class="text-[10px] text-red-500 mt-0">{{ errors.prospectTechnique }}</p>
              </div>

              <!-- Ways of Communication (7 options + Add at bottom) -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Ways of Communication</label>
                <div class="relative">
                  <select 
                    v-model="form.communication"
                    class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all appearance-none cursor-pointer"
                    :class="{ 'border-red-500 ring-1 ring-red-200': errors.communication }"
                  >
                    <option value="" disabled>Select communication</option>
                    <option v-for="comm in communications" :key="comm" :value="comm">{{ comm }}</option>
                    <option value="__add__" class="text-[#fa6f10] font-medium">+ Add new communication</option>
                  </select>
                  <svg class="w-3.5 h-3.5 text-gray-400 absolute right-2 top-1.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </div>
                <!-- Inline Add Communication Input -->
                <div v-if="showAddCommunication" class="mt-1 flex gap-1.5">
                  <input 
                    v-model="newCommunicationName"
                    ref="communicationInput"
                    type="text" 
                    placeholder="Type new communication..."
                    class="flex-1 px-2 py-1 bg-white border border-[#fa6f10] rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30"
                    @keyup.enter="confirmAddCommunication"
                  >
                  <button @click="confirmAddCommunication" class="px-2 py-1 bg-[#fa6f10] text-white rounded-[4px] text-[12px] font-medium">Add</button>
                  <button @click="cancelAddCommunication" class="px-2 py-1 border border-gray-300 rounded-[4px] text-[12px]">✕</button>
                </div>
                <p v-if="errors.communication" class="text-[10px] text-red-500 mt-0">{{ errors.communication }}</p>
              </div>

              <!-- Contact Person -->
              <div>
                <label class="block text-[11px] text-gray-600 font-medium mb-0">Contact Person</label>
                <div class="grid grid-cols-2 gap-1.5">
                  <div>
                    <input 
                      v-model="form.contactPerson"
                      type="text" 
                      placeholder="Contact Name"
                      class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                      :class="{ 'border-red-500 ring-1 ring-red-200': errors.contactPerson }"
                    >
                    <p v-if="errors.contactPerson" class="text-[10px] text-red-500 mt-0">{{ errors.contactPerson }}</p>
                  </div>
                  <div>
                    <input 
                      v-model="form.contactNumber"
                      type="tel" 
                      placeholder="Contact Number"
                      @input="onlyNumbers"
                      class="w-full px-2 py-1 bg-gray-50 border border-gray-300 rounded-[4px] text-[13px] focus:outline-none focus:ring-1 focus:ring-[#fa6f10]/30 focus:border-[#fa6f10] transition-all"
                      :class="{ 'border-red-500 ring-1 ring-red-200': errors.contactNumber }"
                    >
                    <p v-if="errors.contactNumber" class="text-[10px] text-red-500 mt-0">{{ errors.contactNumber }}</p>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Buttons -->
          <div class="flex items-center justify-end gap-2 mt-2 pt-2 border-t border-gray-200 shrink-0">
            <button 
              @click="cancel"
              class="px-4 py-1 border border-gray-300 rounded-[4px] text-gray-700 hover:bg-gray-50 transition-colors font-medium text-[13px]"
            >
              Cancel
            </button>
            <button 
              @click="save"
              class="px-4 py-1 bg-[#fa6f10] hover:bg-[#e5630e] active:bg-[#cc570d] text-white rounded-[4px] font-medium text-[13px] transition-colors"
            >
              Save
            </button>
          </div>

        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue'

const form = ref({
  dateRecorded: '',
  clientName: '',
  email: '',
  service: '',
  status: 0,
  area: '',
  salesRep: '',
  onboardingDate: '',
  remarks: '',
  prospectTechnique: '',
  communication: '',
  contactPerson: '',
  contactNumber: ''
})

const errors = ref({})

// Service add
const showAddService = ref(false)
const newServiceName = ref('')
const serviceInput = ref(null)

// Technique add
const showAddTechnique = ref(false)
const newTechniqueName = ref('')
const techniqueInput = ref(null)

// Communication add
const showAddCommunication = ref(false)
const newCommunicationName = ref('')
const communicationInput = ref(null)

const services = ref([
  'Website Development',
  'SEO Optimization',
  'Mobile App',
  'Cloud Hosting',
  'UI/UX Design',
  'Digital Marketing'
])

const prospectTechniques = ref([
  'Cold Calling',
  'Referral',
  'Social Media',
  'Walk-in',
  'Email Campaign',
  'Trade Show',
  'Webinar',
  'LinkedIn Outreach',
  'Paid Ads',
  'Content Marketing'
])

const communications = ref([
  'Messenger',
  'Email',
  'Phone',
  'WhatsApp',
  'Viber',
  'Telegram',
  'Zoom Meeting'
])

// Watch Service "+ Add"
watch(() => form.value.service, (val) => {
  if (val === '__add__') {
    form.value.service = ''
    showAddService.value = true
    nextTick(() => serviceInput.value?.focus())
  }
})

// Watch Prospect Technique "+ Add"
watch(() => form.value.prospectTechnique, (val) => {
  if (val === '__add__') {
    form.value.prospectTechnique = ''
    showAddTechnique.value = true
    nextTick(() => techniqueInput.value?.focus())
  }
})

// Watch Communication "+ Add"
watch(() => form.value.communication, (val) => {
  if (val === '__add__') {
    form.value.communication = ''
    showAddCommunication.value = true
    nextTick(() => communicationInput.value?.focus())
  }
})

// Service functions
function confirmAddService() {
  const name = newServiceName.value.trim()
  if (name) {
    services.value.push(name)
    form.value.service = name
  }
  showAddService.value = false
  newServiceName.value = ''
}

function cancelAddService() {
  showAddService.value = false
  newServiceName.value = ''
}

// Technique functions
function confirmAddTechnique() {
  const name = newTechniqueName.value.trim()
  if (name) {
    prospectTechniques.value.push(name)
    form.value.prospectTechnique = name
  }
  showAddTechnique.value = false
  newTechniqueName.value = ''
}

function cancelAddTechnique() {
  showAddTechnique.value = false
  newTechniqueName.value = ''
}

// Communication functions
function confirmAddCommunication() {
  const name = newCommunicationName.value.trim()
  if (name) {
    communications.value.push(name)
    form.value.communication = name
  }
  showAddCommunication.value = false
  newCommunicationName.value = ''
}

function cancelAddCommunication() {
  showAddCommunication.value = false
  newCommunicationName.value = ''
}

function onlyNumbers(e) {
  const val = e.target.value
  e.target.value = val.replace(/\D/g, '')
  form.value.contactNumber = e.target.value
}

function validateForm() {
  errors.value = {}
  let isValid = true

  const requiredFields = [
    'dateRecorded', 'clientName', 'email', 'service', 'status',
    'area', 'salesRep', 'onboardingDate', 'remarks', 'prospectTechnique',
    'communication', 'contactPerson', 'contactNumber'
  ]

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

  return isValid
}

function save() {
  if (!validateForm()) return
  
  const existing = JSON.parse(localStorage.getItem('pipRecords') || '[]')
  existing.push({ ...form.value, id: Date.now() })
  localStorage.setItem('pipRecords', JSON.stringify(existing))
  
  navigateTo('/admin/pip')
}

function cancel() {
  navigateTo('/admin/pip')
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&display=swap');

select {
  background-image: none;
}

input[type="range"] {
  -webkit-appearance: none;
  appearance: none;
  height: 5px;
  background: #e5e7eb;
  border-radius: 3px;
  outline: none;
}

input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 14px;
  height: 14px;
  border-radius: 50%;
  background: #fa6f10;
  cursor: pointer;
  border: 2px solid white;
  box-shadow: 0 1px 2px rgba(0,0,0,0.15);
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  -moz-appearance: textfield;
}
</style>