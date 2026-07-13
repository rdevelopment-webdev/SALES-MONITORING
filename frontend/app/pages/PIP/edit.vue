<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-[1px]">
    <div class="bg-white rounded-[6px] w-[560px] shadow-2xl flex flex-col overflow-hidden">

      <!-- Modal Header -->
      <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100 bg-white">
        <div class="flex items-center gap-2">
          <div class="w-5 h-5 rounded-[4px] bg-[#F52C11]/10 flex items-center justify-center shrink-0">
            <svg class="w-3 h-3 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-[12px] font-bold text-[#1F2835] leading-tight">Edit record</h3>
          </div>
        </div>
        <button @click="close" class="text-[#F52C11] hover:text-[#d9250e] transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Modal Body - Two Column Layout -->
      <div class="px-4 py-2.5 bg-white">
        <div class="grid grid-cols-2 gap-x-5 gap-y-2">

          <!-- Left Column -->
          <div class="space-y-2">
            <!-- Date Recorded -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Date Recorded</label>
              <div class="relative">
                <input 
                  v-model="form.dateRecorded"
                  type="text" 
                  placeholder="mm/dd/yyyy"
                  readonly
                  class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer h-[28px]"
                  @click="showDatePickerFor = 'dateRecorded'"
                >
                <button 
                  @click="showDatePickerFor = 'dateRecorded'"
                  class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F52C11] transition-colors"
                  type="button"
                >
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Client Name -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Client Name <span class="text-[#F52C11]">*</span></label>
              <input 
                v-model="form.clientName"
                type="text" 
                placeholder="Enter a name"
                :class="[
                  'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors h-[28px]',
                  errors.clientName ? 'border-[#F52C11]' : 'border-gray-300 focus:border-[#F52C11]'
                ]"
              >
              <p v-if="errors.clientName" class="text-[8px] text-[#F52C11] mt-0.5">Client name is required</p>
            </div>

            <!-- Prospect Technique (Select Dropdown) -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Prospect Technique <span class="text-[#F52C11]">*</span></label>
              <div class="relative">
                <select 
                  v-model="form.prospectTechnique"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors appearance-none cursor-pointer h-[28px]',
                    errors.prospectTechnique ? 'border-[#F52C11]' : 'border-gray-300 focus:border-[#F52C11]',
                    form.prospectTechnique ? 'text-[#1F2835]' : 'text-gray-400'
                  ]"
                >
                  <option value="" disabled class="text-gray-400">Select a prospect technique</option>
                  <option v-for="technique in prospectTechniqueOptions" :key="technique.id" :value="technique.id" class="text-[#1F2835]">{{ technique.name }}</option>
                </select>
                <svg class="w-2.5 h-2.5 text-[#F52C11] absolute right-2.5 top-[7px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
              </div>
              <p v-if="errors.prospectTechnique" class="text-[8px] text-[#F52C11] mt-0.5">Prospect technique is required</p>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Email <span class="text-[#F52C11]">*</span></label>
              <input 
                v-model="form.email"
                type="email" 
                placeholder="example@company.com"
                :class="[
                  'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors h-[28px]',
                  errors.email ? 'border-[#F52C11]' : 'border-gray-300 focus:border-[#F52C11]'
                ]"
                @blur="validateEmailField"
              >
              <p v-if="errors.email" class="text-[8px] text-[#F52C11] mt-0.5">Enter a valid email (must include @)</p>
            </div>

            <!-- Service (Select Dropdown) -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Service <span class="text-[#F52C11]">*</span></label>
              <div class="relative">
                <select 
                  v-model="form.service"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors appearance-none cursor-pointer h-[28px]',
                    errors.service ? 'border-[#F52C11]' : 'border-gray-300 focus:border-[#F52C11]',
                    form.service ? 'text-[#1F2835]' : 'text-gray-400'
                  ]"
                >
                  <option value="" disabled class="text-gray-400">Select a service</option>
                  <option v-for="service in serviceOptions" :key="service.id" :value="service.id" class="text-[#1F2835]">{{ service.name }}</option>
                </select>
                <svg class="w-2.5 h-2.5 text-[#F52C11] absolute right-2.5 top-[7px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
              </div>
              <p v-if="errors.service" class="text-[8px] text-[#F52C11] mt-0.5">Service is required</p>
            </div>

            <!-- Lead Status (Select Dropdown) -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Lead Status <span class="text-[#F52C11]">*</span></label>
              <div class="relative">
                <select 
                  v-model="form.leadStatus"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors appearance-none cursor-pointer h-[28px]',
                    errors.leadStatus ? 'border-[#F52C11]' : 'border-gray-300 focus:border-[#F52C11]',
                    form.leadStatus ? 'text-[#1F2835]' : 'text-gray-400'
                  ]"
                >
                  <option value="" disabled class="text-gray-400">Select a lead status</option>
                  <option v-for="statusOption in statusOptions" :key="statusOption" :value="statusOption" class="text-[#1F2835]">{{ statusOption }}</option>
                </select>
                <svg class="w-2.5 h-2.5 text-[#F52C11] absolute right-2.5 top-[7px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
              </div>
              <p v-if="errors.leadStatus" class="text-[8px] text-[#F52C11] mt-0.5">Lead status is required</p>
            </div>
          </div>

          <!-- Right Column -->
          <div class="space-y-2">
            <!-- Onboarding Date -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Onboarding Date</label>
              <div class="relative">
                <input 
                  v-model="form.onboardingDate"
                  type="text" 
                  placeholder="mm/dd/yyyy"
                  readonly
                  class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer h-[28px]"
                  @click="showDatePickerFor = 'onboardingDate'"
                >
                <button 
                  @click="showDatePickerFor = 'onboardingDate'"
                  class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F52C11] transition-colors"
                  type="button"
                >
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Location -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Location</label>
              <input 
                v-model="form.location"
                type="text" 
                placeholder="Enter a location"
                class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors h-[28px]"
              >
            </div>

            <!-- Sales Representative (Multi-select with checkboxes) -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Sales Representative</label>
              <div class="relative">
                <button
                  type="button"
                  @click="toggleSalesRepDropdown"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[3px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between h-[28px]',
                    errors.salesRepresentative ? 'border-[#F52C11]' : 'border-gray-300 focus:border-[#F52C11]',
                    form.salesRepresentative.length > 0 ? 'text-[#1F2835]' : 'text-gray-400'
                  ]"
                >
                  <span v-if="form.salesRepresentative.length === 0" class="text-gray-400">Select sales representatives</span>
                  <span v-else class="flex items-center gap-1 overflow-x-auto whitespace-nowrap scrollbar-hide pr-1" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <span 
                      v-for="repId in form.salesRepresentative" 
                      :key="repId"
                      class="inline-flex items-center gap-0.5 bg-[#F52C11]/10 text-[#1F2835] px-1.5 py-[1px] rounded-[3px] text-[9px] font-medium shrink-0"
                    >
                      {{ salesRepName(repId) }}
                      <button 
                        type="button"
                        @click.stop="removeSalesRep(repId)"
                        class="text-[#f52c11] hover:text-[#d9250e]"
                      >
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                      </button>
                    </span>
                  </span>
                  <svg 
                    :class="['w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1', showSalesRepDropdown ? 'rotate-180' : '']" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>

                <!-- Dropdown Menu -->
                <div 
                  v-if="showSalesRepDropdown"
                  class="absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-[4px] shadow-lg py-1 max-h-40 overflow-auto"
                >
                  <div 
                    v-for="rep in salesRepOptions" 
                    :key="rep.id"
                    @click="toggleSalesRep(rep.id)"
                    class="flex items-center gap-2 px-2.5 py-1.5 hover:bg-gray-50 cursor-pointer transition-colors"
                  >
                    <div :class="[
                      'w-3.5 h-3.5 rounded border flex items-center justify-center transition-colors shrink-0',
                      form.salesRepresentative.includes(rep.id) ? 'bg-[#F52C11] border-[#F52C11]' : 'border-gray-300'
                    ]">
                      <svg v-if="form.salesRepresentative.includes(rep.id)" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                      </svg>
                    </div>
                    <span class="text-[11px] text-[#1F2835]">{{ rep.name }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Ways of Communication (Select Dropdown) -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Ways of Communication <span class="text-[#F52C11]">*</span></label>
              <div class="relative">
                <select 
                  v-model="form.waysOfCommunication"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors appearance-none cursor-pointer h-[28px]',
                    errors.waysOfCommunication ? 'border-[#F52C11]' : 'border-gray-300 focus:border-[#F52C11]',
                    form.waysOfCommunication ? 'text-[#1F2835]' : 'text-gray-400'
                  ]"
                >
                  <option value="" disabled class="text-gray-400">Select a way of communication</option>
                  <option v-for="way in communicationOptions" :key="way.id" :value="way.id" class="text-[#1F2835]">{{ way.name }}</option>
                </select>
                <svg class="w-2.5 h-2.5 text-[#F52C11] absolute right-2.5 top-[7px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
              </div>
              <p v-if="errors.waysOfCommunication" class="text-[8px] text-[#F52C11] mt-0.5">Way of communication is required</p>
            </div>

            <!-- Remarks -->
            <div>
              <label class="block text-[10.5px] font-bold text-[#1F2835] mb-0.5">Remarks</label>
              <input 
                v-model="form.remarks"
                type="text" 
                placeholder="Enter any additional notes"
                class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors h-[28px]"
              >
            </div>
          </div>
        </div>

        <!-- Bottom Cards Row -->
        <div class="grid grid-cols-2 gap-x-5 mt-3">

          <!-- Contact Person Card -->
          <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="flex items-center gap-1.5 px-3 py-1.5 border-b border-gray-100">
              <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
                <svg class="w-2.5 h-2.5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">Contact Person</h2>
                <p class="text-[9px] text-gray-400 leading-tight">Identify the primary point of contact</p>
              </div>
            </div>

            <!-- Contact Person Inputs -->
            <div class="px-3 pb-2.5 pt-1 space-y-1.5">
              <div class="flex items-center gap-1.5">
                <div class="w-7 h-7 rounded-[4px] bg-gray-50 flex items-center justify-center shrink-0">
                  <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                </div>
                <input
                  v-model="form.contactPersonName"
                  type="text"
                  placeholder="Type contact name"
                  class="flex-1 bg-white border border-gray-200 rounded-[4px] px-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                >
              </div>
              <div class="flex items-center gap-1.5">
                <div class="w-7 h-7 rounded-[4px] bg-gray-50 flex items-center justify-center shrink-0">
                  <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                  </svg>
                </div>
                <input
                  v-model="form.contactPersonPhone"
                  type="tel"
                  placeholder="09XX-XXX-XXXX"
                  class="flex-1 bg-white border border-gray-200 rounded-[4px] px-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                  @input="formatContactPersonPhone"
                  @keydown="handleContactKeydown"
                >
              </div>
            </div>
          </div>

          <!-- Status and Progress Card -->
          <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="flex items-center gap-1.5 px-3 py-1.5 border-b border-gray-100">
              <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
                <svg class="w-2.5 h-2.5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">Status and progress</h2>
                <p class="text-[9px] text-gray-400 leading-tight">Set the current lead stage</p>
              </div>
            </div>

            <!-- Progress -->
            <div class="px-3 pb-2.5 pt-1">
              <div class="flex items-start justify-between mb-0.5 border-b border-gray-100 pb-2">
                <div class="leading-tight">
                  <label class="text-[10.5px] font-bold text-[#1F2835]">Status</label>
                  <p class="text-[8.7px] text-gray-400">Progress bar updates automatically</p>
                </div>
                <!-- Number + stepper -->
                <div class="flex items-center gap-1">
                  <div class="flex items-center border border-gray-300 rounded-[4px] overflow-hidden bg-white">
                    <input 
                      v-model.number="form.status"
                      type="number" 
                      min="0" 
                      max="100"
                      step="10"
                      class="w-10 text-right text-[11px] font-bold text-[#1F2835] bg-transparent border-none focus:outline-none p-0 py-[1px] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                      @input="clampProgress"
                      @blur="clampProgress"
                    >
                    <div class="flex flex-col">
                      <button
                        type="button"
                        @click="incrementProgress"
                        class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors"
                      >
                        <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                        </svg>
                      </button>
                      <button
                        type="button"
                        @click="decrementProgress"
                        class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors"
                      >
                        <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                  <span class="text-[10px] text-gray-400">%</span>
                </div>
              </div>
              <!-- Progress Bar -->
              <div class="w-full h-[10px] bg-gray-200 rounded-full relative">
                <div 
                  class="absolute top-1/2 left-0 -translate-y-1/2 h-[6px] rounded-full transition-all duration-300"
                  :style="{ width: form.status + '%', backgroundColor: progressColor }"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Save error banner -->
        <div v-if="saveError" class="flex items-start gap-2 px-3 py-2 mt-2 rounded-[4px] bg-[#F52C11]/10 border border-[#F52C11]/30 text-[#F52C11] text-[10.5px]">
          <svg class="w-3.5 h-3.5 mt-[1px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
          </svg>
          <span>{{ saveError }}</span>
        </div>
      </div>

      <!-- Footer -->
      <div class="px-4 py-2 border-t border-gray-100 flex items-center justify-end gap-2 bg-white">
        <button
          type="button"
          @click="close"
          class="px-3 py-[4px] rounded-[4px] text-[10px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
        >
          Cancel
        </button>
        <button
          type="button"
          @click="saveChanges"
          :disabled="!isFormValid || isSaving"
          :class="[
            'px-3 py-[4px] rounded-[4px] text-[10px] font-medium flex items-center gap-1 transition-colors',
            isFormValid && !isSaving ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'
          ]"
        >
          <svg v-if="isSaving" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          {{ isSaving ? 'Saving...' : 'Save changes' }}
        </button>
      </div>
    </div>

    <!-- Date Picker Modal -->
    <div v-if="showDatePickerFor" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50" @click.self="showDatePickerFor = null">
      <div class="bg-white rounded-[8px] w-[280px] shadow-xl p-4">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-[13px] font-bold text-[#1F2835]">Select Date</h3>
          <button @click="showDatePickerFor = null" class="text-gray-400 hover:text-[#1F2835]">
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
          <div v-for="(day, i) in ['S','M','T','W','T','F','S']" :key="i" class="text-center text-[9px] font-semibold text-gray-400 py-1">
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
            @click="showDatePickerFor = null"
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
definePageMeta({
  layout: "app",
  middleware: "auth",
});

import { ref, computed, reactive, watch, onMounted, onBeforeUnmount } from 'vue'

// ============================================
// PROPS - Accept existing record for editing
// ============================================
const props = defineProps({
  record: {
    type: Object,
    default: null,
  },
  prospectTechniqueOptions: { type: Array, default: () => [] }, // [{id, name}]
  salesRepOptions: { type: Array, default: () => [] },          // [{id, name}]
  communicationOptions: { type: Array, default: () => [] },     // [{id, name}]
  serviceOptions: { type: Array, default: () => [] },           // [{id, name}]
  statusOptions: { type: Array, default: () => [] },            // ['Emailed', 'Called', ...]
  saveError: { type: String, default: '' },                     // error message from parent's failed save attempt
})

const emit = defineEmits(['close', 'save'])

// ============================================
// SAMPLE RECORD (fallback if no prop passed)
// ============================================
const sampleRecord = {
  dateRecorded: '06/22/2026',
  onboardingDate: '06/22/2026',
  clientName: 'Ana Smith',
  prospectTechnique: 'Cold Calling',
  email: 'anasmith@gmail.com',
  service: '',
  location: 'Davao',
  salesRepresentative: ['Sales Representative 1', 'Sales Representative 2'],
  waysOfCommunication: 'Messenger',
  remarks: '',
  contactPersonName: 'Ana Smith',
  contactPersonPhone: '0909-326-4879',
  status: 20,
  leadStatus: '',
}

// ============================================
// FORM DATA - Initialize from prop or sample
// prospectTechnique / service / waysOfCommunication hold the selected
// lookup's id; salesRepresentative holds an array of selected ids.
// ============================================
const form = reactive({
  dateRecorded: '',
  onboardingDate: '',
  clientName: '',
  location: '',
  prospectTechnique: '',
  salesRepresentative: [],
  email: '',
  waysOfCommunication: '',
  service: '',
  remarks: '',
  contactPersonName: '',
  contactPersonPhone: '',
  status: 30,
  leadStatus: ''
})

// ============================================
// ERROR STATE
// ============================================
const errors = reactive({
  clientName: false,
  prospectTechnique: false,
  email: false,
  waysOfCommunication: false,
  service: false,
  leadStatus: false
})

// ============================================
// UI STATE
// ============================================
const showDatePickerFor = ref(null)
const showSalesRepDropdown = ref(false)
const selectedDate = ref(null)
const viewDate = ref(new Date())
const isSaving = ref(false)

// ============================================
// INITIALIZE FORM FROM RECORD PROP
// record comes from index.vue's api.toFrontendRecord(), which exposes
// both display names (record.service) and lookup ids (record.serviceId)
// — the form needs the ids so the <select> elements can bind correctly.
// ============================================
function initializeForm() {
  const source = props.record || sampleRecord
  Object.assign(form, {
    dateRecorded: source.dateRecorded || '',
    onboardingDate: source.onboardingDate || '',
    clientName: source.clientName || '',
    location: source.location || '',
    prospectTechnique: source.prospectTechniqueId ?? source.prospectTechnique ?? '',
    salesRepresentative: Array.isArray(source.salesRepresentativeIds) ? [...source.salesRepresentativeIds] :
                         Array.isArray(source.salesRepresentative) ? [...source.salesRepresentative] : [],
    email: source.email || '',
    waysOfCommunication: source.waysOfCommunicationId ?? source.waysOfCommunication ?? '',
    service: source.serviceId ?? source.service ?? '',
    remarks: source.remarks || '',
    contactPersonName: source.contactPersonName || source.contactPerson || '',
    contactPersonPhone: source.contactPersonPhone || source.contactNo || '',
    status: source.status ?? source.progress ?? source.statusPercent ?? 30,
    leadStatus: source.leadStatus || ''
  })
}

// Initialize on mount and watch for prop changes
onMounted(() => {
  initializeForm()
})

watch(() => props.record, () => {
  initializeForm()
}, { deep: true })

// ============================================
// SALES REPRESENTATIVE MULTI-SELECT
// ============================================
function toggleSalesRepDropdown() {
  showSalesRepDropdown.value = !showSalesRepDropdown.value
}

function toggleSalesRep(rep) {
  const index = form.salesRepresentative.indexOf(rep)
  if (index > -1) {
    form.salesRepresentative.splice(index, 1)
  } else {
    form.salesRepresentative.push(rep)
  }
}

function removeSalesRep(rep) {
  const index = form.salesRepresentative.indexOf(rep)
  if (index > -1) {
    form.salesRepresentative.splice(index, 1)
  }
}

function salesRepName(repId) {
  return props.salesRepOptions.find(r => r.id === repId)?.name || repId
}

// Close dropdown when clicking outside
function handleClickOutside(e) {
  if (!e.target.closest('.relative')) {
    showSalesRepDropdown.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})

// ============================================
// CONTACT PERSON PHONE - Philippine format
// ============================================
function formatContactPersonPhone() {
  const digitsOnly = form.contactPersonPhone.replace(/\D/g, '').slice(0, 11)
  let formatted = digitsOnly
  if (digitsOnly.length > 4 && digitsOnly.length <= 7) {
    formatted = `${digitsOnly.slice(0, 4)}-${digitsOnly.slice(4)}`
  } else if (digitsOnly.length > 7) {
    formatted = `${digitsOnly.slice(0, 4)}-${digitsOnly.slice(4, 7)}-${digitsOnly.slice(7)}`
  }
  form.contactPersonPhone = formatted
}

function handleContactKeydown(e) {
  const allowed = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab']
  if (allowed.includes(e.key)) return
  if (!/^[0-9]$/.test(e.key)) e.preventDefault()
}

// ============================================
// EMAIL VALIDATION
// ============================================
function isValidEmail(value) {
  if (!value || !value.trim()) return false
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim())
}

function validateEmailField() {
  errors.email = !isValidEmail(form.email)
}

// ============================================
// STATUS / PROGRESS
// ============================================
const progressColorPalette = [
  '#f52c11', '#fa6f10', '#ffb300', '#ffd60a', '#888888',
  '#6b7a8f', '#7fb069', '#5e8c31', '#4f772d', '#639922',
]

const progressColor = computed(() => {
  const value = Number(form.status) || 0
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1))
  return progressColorPalette[bucket - 1]
})

function clampProgress() {
  let value = Number(form.status)
  if (isNaN(value)) value = 0
  form.status = Math.min(100, Math.max(0, Math.round(value)))
}

function incrementProgress() {
  const current = Number(form.status) || 0
  form.status = Math.min(100, current + 10)
}

function decrementProgress() {
  const current = Number(form.status) || 0
  form.status = Math.max(0, current - 10)
}

// ============================================
// COMPUTED
// ============================================
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

const isFormValid = computed(() => {
  return form.clientName.trim() &&
         form.prospectTechnique &&
         form.email &&
         isValidEmail(form.email) &&
         form.waysOfCommunication &&
         form.service &&
         form.leadStatus
})

// ============================================
// CALENDAR METHODS
// ============================================
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
  if (selectedDate.value && showDatePickerFor.value) {
    const formattedDate = selectedDate.value.toLocaleDateString('en-US', { 
      month: '2-digit', 
      day: '2-digit', 
      year: 'numeric' 
    })
    form[showDatePickerFor.value] = formattedDate
  }
  showDatePickerFor.value = null
}

// ============================================
// VALIDATION
// ============================================
function validateForm() {
  errors.clientName = !form.clientName.trim()
  errors.prospectTechnique = !form.prospectTechnique
  errors.email = !isValidEmail(form.email)
  errors.waysOfCommunication = !form.waysOfCommunication
  errors.service = !form.service
  errors.leadStatus = !form.leadStatus
  
  return !Object.values(errors).some(error => error)
}

function resetErrors() {
  errors.clientName = false
  errors.prospectTechnique = false
  errors.email = false
  errors.waysOfCommunication = false
  errors.service = false
  errors.leadStatus = false
}

// ============================================
// ACTIONS
// ============================================
function close() {
  resetErrors()
  showDatePickerFor.value = null
  showSalesRepDropdown.value = false
  emit('close')
}

async function saveChanges() {
  if (!validateForm()) return
  
  isSaving.value = true
  
  try {
    // ============================================
    // BACKEND INTEGRATION POINT
    // The parent (index.vue) listens for the 'save' event and performs
    // the actual PUT /api/performanceplans/{id} call. If it fails,
    // index.vue sets saveError (prop) instead of closing this modal —
    // so the form and the user's edits stay put and the error shows
    // above the footer. Only close on confirmed success.
    // ============================================
    // Field values here are already lookup ids (technique/service/comm/reps)
    // and a lead-status string. index.vue's updateRecord() converts this
    // into the exact shape PerformancePlanController::update() expects.
    const payload = {
      dateRecorded: form.dateRecorded,
      onboardingDate: form.onboardingDate,
      clientName: form.clientName,
      location: form.location,
      prospectTechnique: form.prospectTechnique,
      salesRepresentative: form.salesRepresentative,
      email: form.email,
      waysOfCommunication: form.waysOfCommunication,
      service: form.service,
      remarks: form.remarks,
      contactPersonName: form.contactPersonName,
      contactPersonPhone: form.contactPersonPhone,
      status: form.status,
      leadStatus: form.leadStatus
    }
    
    emit('save', payload)
    // NOTE: do not close here — index.vue only tells this modal to close
    // (by unmounting/hiding it) once the API call actually succeeds.
    // If it fails, saveError gets set and this modal stays open with the
    // user's edits intact.

  } catch (error) {
    console.error('Failed to update record:', error)
  } finally {
    isSaving.value = false
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap');
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
/* Remove number input spinners */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  -webkit-appearance: none;
  -moz-appearance: textfield;
  appearance: textfield;
}

/* Dropdown options styling - black text, no blue highlight */
select option {
  color: #1F2835;
  background-color: #ffffff;
}

select option:checked {
  color: #1F2835;
  background-color: #ffffff;
}

select option:hover {
  background-color: #f3f4f6;
}

select:focus option:checked {
  background-color: #ffffff;
  color: #1F2835;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-track {
  background: transparent;
}
::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 3px;
}
</style>
