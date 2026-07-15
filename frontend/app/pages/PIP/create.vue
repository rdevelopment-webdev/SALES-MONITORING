<template>
  <div
    class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#e5e5e5] font-['Overpass'] text-[13px] text-[#1F2835]"
  >
    <!-- Breadcrumb Header -->
    <div class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200">
      <div class="flex items-center text-[10px] text-gray-500 gap-1">
        <svg
          class="w-3 h-3 text-gray-400"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
          />
        </svg>
        <span class="cursor-pointer transition-colors hover:text-[#F52C11]" @click="cancel">Leads Tracker</span>
        <svg
          class="w-2.5 h-2.5 text-gray-400"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 5l7 7-7 7"
          />
        </svg>
        <span class="text-[#F52C11] font-medium">PIP</span>
      </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-[#e5e5e5]">
      <div class="max-w-4xl mx-auto w-full p-6 md:p-8 space-y-3">
        
        <!-- Page Title -->
        <div class="mb-4">
          <h1 class="text-[15px] font-bold text-[#1F2835] leading-tight">
            Add new record
          </h1>
          <p class="text-[10px] text-gray-500 mt-0.5">
            PIP page – Leads Tracker
          </p>
          <p v-if="saveError" class="mt-1 text-[10px] font-medium text-[#F52C11]">
            {{ saveError }}
          </p>
        </div>

        <!-- Business Information Card -->
        <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden">
          <!-- Card Header -->
          <div class="flex items-center gap-1.5 px-3 py-2">
            <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
              <svg class="w-2.5 h-2.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
            </div>
            <div>
              <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">
                Business information
              </h2>
              <p class="text-[9px] text-gray-400 leading-tight">
                Enter the contact and company details
              </p>
            </div>
          </div>

          <!-- Form Fields -->
          <div class="px-3 pt-3 pb-2.5 border-t border-gray-100">
            <div class="grid grid-cols-2 gap-3">
              <!-- Date Recorded -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Date Recorded
                </label>
                <div class="relative">
                  <input
                    v-model="form.dateRecorded"
                    type="text"
                    placeholder="mm/dd/yyyy"
                    readonly
                    :class="[
                      'w-full border rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] placeholder:text-gray-400 focus:outline-none transition-colors cursor-pointer bg-white',
                      errors.dateRecorded ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                    ]"
                    @click="showDatePickerFor = 'dateRecorded'"
                  />
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
                <p v-if="errors.dateRecorded" class="text-[8px] text-[#F52C11] mt-0.5">
                  Date recorded is required
                </p>
              </div>

              <!-- Onboarding Date -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Onboarding Date
                </label>
                <div class="relative">
                  <input
                    v-model="form.onboardingDate"
                    type="text"
                    placeholder="mm/dd/yyyy"
                    readonly
                    class="w-full border border-gray-200 rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer bg-white"
                    @click="showDatePickerFor = 'onboardingDate'"
                  />
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

              <!-- Client Name -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Client Name
                </label>
                <input
                  v-model="form.clientName"
                  type="text"
                  placeholder="Enter a name"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.clientName ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                  @keyup.enter="saveRecord"
                />
                <p v-if="errors.clientName" class="text-[8px] text-[#F52C11] mt-0.5">
                  Client name is required
                </p>
              </div>

              <!-- Location -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Location
                </label>
                <button
                  ref="locationButtonRef"
                  type="button"
                  @click="toggleDropdown('location')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    'border-gray-200 focus:border-[#F52C11]',
                    form.location ? 'text-[#1F2835]' : 'text-gray-400',
                  ]"
                >
                  <span class="truncate">{{ locationLabel || "Select a location" }}</span>
                  <svg
                    :class="['w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1', showLocationDropdown ? 'rotate-180' : '']"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <!-- Teleport dropdown -->
                <Teleport to="body">
                  <div
                    v-if="showLocationDropdown"
                    ref="locationPanelRef"
                    :style="locationDropdownStyle"
                    class="fixed z-50 bg-white border border-gray-200 rounded-[6px] shadow-lg py-1 max-h-52 overflow-y-auto scrollbar-red"
                  >
                    <div
                      v-for="option in locationOptions"
                      :key="option.id"
                      @click="selectLocation(option.id)"
                      :class="[
                        'px-3 py-2 text-[11px] cursor-pointer flex items-center justify-between transition-colors',
                        form.location === option.id ? 'text-[#F52C11] font-medium bg-[#F52C11]/5' : 'text-[#1F2835] hover:text-[#F52C11] hover:bg-[#F52C11]/5'
                      ]"
                    >
                      <span>{{ option.name }}</span>
                    </div>
                  </div>
                </Teleport>
              </div>

              <!-- Prospect Technique -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Prospect Technique
                </label>
                <button
                  ref="techniqueButtonRef"
                  type="button"
                  @click="toggleDropdown('technique')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.prospectTechnique ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                    form.prospectTechnique ? 'text-[#1F2835]' : 'text-gray-400',
                  ]"
                >
                  <span class="truncate">{{ techniqueLabel || "Select a prospect technique" }}</span>
                  <svg
                    :class="['w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1', showTechniqueDropdown ? 'rotate-180' : '']"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <p v-if="errors.prospectTechnique" class="text-[8px] text-[#F52C11] mt-0.5">
                  Prospect technique is required
                </p>
                <!-- Teleport dropdown -->
                <Teleport to="body">
                 <div
  v-if="showTechniqueDropdown"
  ref="techniquePanelRef"
  :style="techniqueDropdownStyle"
  class="fixed z-50 bg-white border border-gray-200 rounded-[6px] shadow-lg py-1 max-h-52 overflow-y-auto scrollbar-red"
>
                   <div
  v-for="option in prospectTechniqueOptions"
  :key="option.id"
  @click="selectTechnique(option.id)"
  :class="[
    'px-3 py-2 text-[11px] cursor-pointer flex items-center justify-between transition-colors',
    form.prospectTechnique === option.id ? 'text-[#F52C11] font-medium bg-[#F52C11]/5' : 'text-[#1F2835] hover:text-[#F52C11] hover:bg-[#F52C11]/5'
  ]"
>
  <span>{{ option.name }}</span>
</div>
                  </div>
                </Teleport>
              </div>

              <!-- Sales Representative -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Sales Representative
                </label>
                <button
                  ref="salesRepButtonRef"
                  type="button"
                  @click="toggleDropdown('salesRep')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.salesRepresentative ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                    form.salesRepresentative.length > 0 ? 'text-[#1F2835]' : 'text-gray-400',
                  ]"
                >
                  <span v-if="form.salesRepresentative.length === 0" class="text-gray-400">Select sales representatives</span>
                  <span v-else class="flex items-center gap-1 overflow-x-auto whitespace-nowrap scrollbar-hide pr-1" style="scrollbar-width: none; -ms-overflow-style: none">
                    <span
                      v-for="repId in form.salesRepresentative"
                      :key="repId"
                      class="inline-flex items-center gap-0.5 bg-[#F52C11]/10 text-[#F52C11] px-1.5 py-0.5 rounded text-[9px] font-medium shrink-0"
                    >
                      {{ salesRepName(repId) }}
                      <button type="button" @click.stop="removeSalesRep(repId)" class="hover:text-[#d9250e]">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                      </button>
                    </span>
                  </span>
                  <svg
                    :class="['w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1', showSalesRepDropdown ? 'rotate-180' : '']"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <p v-if="errors.salesRepresentative" class="text-[8px] text-[#F52C11] mt-0.5">
                  Sales representative is required
                </p>
                <!-- Teleport dropdown with checkboxes -->
                <Teleport to="body">
                  <div
  v-if="showSalesRepDropdown"
  ref="salesRepPanelRef"
  :style="salesRepDropdownStyle"
  class="fixed z-50 bg-white border border-gray-200 rounded-[6px] shadow-lg py-1 max-h-52 overflow-y-auto scrollbar-red"
>
                    <div
                      v-for="option in salesRepOptions"
                      :key="option.id"
                      @click="toggleSalesRep(option.id)"
                      class="px-3 py-2 text-[11px] text-[#1F2835] hover:bg-gray-50 cursor-pointer flex items-center gap-2 transition-colors"
                    >
                      <div
                        :class="[
                          'w-3.5 h-3.5 rounded-[3px] border flex items-center justify-center shrink-0 transition-colors',
                          form.salesRepresentative.includes(option.id) ? 'bg-[#F52C11] border-[#F52C11]' : 'border-gray-300 bg-white'
                        ]"
                      >
                        <svg v-if="form.salesRepresentative.includes(option.id)" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                      </div>
                      <span>{{ option.name }}</span>
                    </div>

                    <!-- Add Sales Representative -->
                    <div class="border-t border-gray-100 mt-1 pt-1 px-2" @click.stop>
                      <div
                        v-if="!showAddSalesRepInput"
                        @click="openAddSalesRep"
                        class="flex items-center gap-1.5 px-1 py-1.5 text-[11px] text-[#F52C11] font-medium cursor-pointer hover:bg-[#F52C11]/5 rounded-[4px] transition-colors"
                      >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add sales representative
                      </div>
                      <div v-else class="flex items-center gap-1 py-1">
                        <input
                          ref="newSalesRepInputRef"
                          v-model="newSalesRepName"
                          type="text"
                          placeholder="New representative name"
                          class="flex-1 border border-gray-200 rounded-[4px] px-2 py-1 text-[11px] focus:outline-none focus:border-[#F52C11]"
                          @keyup.enter="addNewSalesRep"
                          @keyup.esc="cancelAddSalesRep"
                        />
                        <button type="button" @click="addNewSalesRep" class="text-[#F52C11] hover:text-[#d9250e] text-[10px] font-semibold px-1.5">
                          Add
                        </button>
                      </div>
                    </div>
                  </div>
                </Teleport>
              </div>

              <!-- Email -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Email
                </label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="example@company.com"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.email ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                  @blur="validateEmailField"
                  @keyup.enter="saveRecord"
                />
                <p v-if="errors.email" class="text-[8px] text-[#F52C11] mt-0.5">
                  Enter a valid email (must include @)
                </p>
              </div>

              <!-- Ways of Communication -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Ways of Communication
                </label>
                <button
                  ref="communicationButtonRef"
                  type="button"
                  @click="toggleDropdown('communication')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.waysOfCommunication ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                    form.waysOfCommunication ? 'text-[#1F2835]' : 'text-gray-400',
                  ]"
                >
                  <span class="truncate">{{ communicationLabel || "Select a way of communication" }}</span>
                  <svg
                    :class="['w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1', showCommunicationDropdown ? 'rotate-180' : '']"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <p v-if="errors.waysOfCommunication" class="text-[8px] text-[#F52C11] mt-0.5">
                  Way of communication is required
                </p>
                <!-- Teleport dropdown -->
                <Teleport to="body">
                  <div
  v-if="showCommunicationDropdown"
  ref="communicationPanelRef"
  :style="communicationDropdownStyle"
  class="fixed z-50 bg-white border border-gray-200 rounded-[6px] shadow-lg py-1 max-h-52 overflow-y-auto scrollbar-red"
>
                    <div
  v-for="option in communicationOptions"
  :key="option.id"
  @click="selectCommunication(option.id)"
  :class="[
    'px-3 py-2 text-[11px] cursor-pointer flex items-center justify-between transition-colors',
    form.waysOfCommunication === option.id ? 'text-[#F52C11] font-medium bg-[#F52C11]/5' : 'text-[#1F2835] hover:text-[#F52C11] hover:bg-[#F52C11]/5'
  ]"
>
  <span>{{ option.name }}</span>
</div>
                  </div>
                </Teleport>
              </div>

              <!-- Service -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Service
                </label>
                <button
                  ref="serviceButtonRef"
                  type="button"
                  @click="toggleDropdown('service')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.service ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                    form.service ? 'text-[#1F2835]' : 'text-gray-400',
                  ]"
                >
                  <span class="truncate">{{ serviceLabel || "Select a service" }}</span>
                  <svg
                    :class="['w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1', showServiceDropdown ? 'rotate-180' : '']"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <p v-if="errors.service" class="text-[8px] text-[#F52C11] mt-0.5">
                  Service is required
                </p>
                <!-- Teleport dropdown -->
                <Teleport to="body">
                  <div
  v-if="showServiceDropdown"
  ref="servicePanelRef"
  :style="serviceDropdownStyle"
  class="fixed z-50 bg-white border border-gray-200 rounded-[6px] shadow-lg py-1 max-h-52 overflow-y-auto scrollbar-[#F52C11]/10"
>
                    <div
  v-for="option in serviceOptions"
  :key="option.id"
  @click="selectService(option.id)"
  :class="[
    'px-3 py-2 text-[11px] cursor-pointer flex items-center justify-between transition-colors',
    form.service === option.id ? 'text-[#F52C11] font-medium bg-[#F52C11]/5' : 'text-[#1F2835] hover:text-[#F52C11] hover:bg-[#F52C11]/5'
  ]"
>
  <span>{{ option.name }}</span>
</div>

                    <!-- Add Service -->
                    <div class="border-t border-gray-100 mt-1 pt-1 px-2" @click.stop>
                      <div
                        v-if="!showAddServiceInput"
                        @click="openAddService"
                        class="flex items-center gap-1.5 px-1 py-1.5 text-[11px] text-[#F52C11] font-medium cursor-pointer hover:bg-[#F52C11]/5 rounded-[4px] transition-colors"
                      >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add service
                      </div>
                      <div v-else class="flex items-center gap-1 py-1">
                        <input
                          ref="newServiceInputRef"
                          v-model="newServiceName"
                          type="text"
                          placeholder="New service name"
                          class="flex-1 border border-gray-200 rounded-[4px] px-2 py-1 text-[11px] focus:outline-none focus:border-[#F52C11]"
                          @keyup.enter="addNewService"
                          @keyup.esc="cancelAddService"
                        />
                        <button type="button" @click="addNewService" class="text-[#F52C11] hover:text-[#d9250e] text-[10px] font-semibold px-1.5">
                          Add
                        </button>
                      </div>
                    </div>
                  </div>
                </Teleport>
              </div>

              <!-- Remarks -->
              <div>
                <label class="block text-[10px] font-semibold text-[#1F2835] mb-0.5">
                  Remarks
                </label>
                <input
                  v-model="form.remarks"
                  type="text"
                  placeholder="Enter any additional notes"
                  class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                  @keyup.enter="saveRecord"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Bottom Cards Row -->
        <div class="grid grid-cols-2 gap-3">
          <!-- Contact Person Card -->
          <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-1.5 px-3 py-2">
              <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
                <svg class="w-2.5 h-2.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">Contact Person</h2>
                <p class="text-[9px] text-gray-400 leading-tight">Identify the primary point of contact</p>
              </div>
            </div>

            <div class="px-3 pb-2.5 pt-1 space-y-1.5">
              <div class="relative">
                <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <input
                  v-model="form.contactPersonName"
                  type="text"
                  placeholder="Type contact name"
                  :class="[
                    'w-full bg-white border rounded-[4px] pl-8 pr-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.contactPersonName ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                  @keyup.enter="saveRecord"
                />
              </div>
              <p v-if="errors.contactPersonName" class="text-[8px] text-[#F52C11] -mt-1">
                Contact person is required
              </p>
              <div class="relative">
                <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <input
                  v-model="form.contactPersonPhone"
                  type="tel"
                  placeholder="09XX-XXX-XXXX"
                  :class="[
                    'w-full bg-white border rounded-[4px] pl-8 pr-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.contactPersonPhone ? 'border-[#F52C11]' : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                  @input="formatContactPersonPhone"
                  @keydown="handleContactKeydown"
                  @keyup.enter="saveRecord"
                />
              </div>
              <p v-if="errors.contactPersonPhone" class="text-[8px] text-[#F52C11] -mt-1">
                Contact number is required
              </p>
            </div>
          </div>

          <!-- Status and Progress Card -->
          <div class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-1.5 px-3 py-2">
              <div class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0">
                <svg class="w-2.5 h-2.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">Status and progress</h2>
                <p class="text-[9px] text-gray-400 leading-tight">Set the current lead stage</p>
              </div>
            </div>

            <div class="px-3 pb-2.5 pt-1">
              <div class="flex items-center justify-between mb-1">
                <div>
                  <label class="block text-[10px] font-semibold text-[#1F2835]">Status</label>
                  <p class="text-[8px] text-gray-400">Progress bar updates automatically</p>
                </div>

                <div class="flex items-center gap-1">
                  <div class="flex items-center border border-gray-200 rounded-[4px] overflow-hidden">
                    <input
                      v-model.number="form.status"
                      type="number"
                      min="0"
                      max="100"
                      step="10"
                      class="w-10 text-right text-[11px] font-semibold text-[#1F2835] bg-transparent border-none focus:outline-none p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                      @input="clampProgress"
                      @blur="clampProgress"
                      @keyup.enter="saveRecord"
                    />
                    <div class="flex flex-col">
                      <button type="button" @click="incrementProgress" class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors">
                        <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                        </svg>
                      </button>
                      <button type="button" @click="decrementProgress" class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors">
                        <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                  <span class="text-[11px] text-gray-400">%</span>
                </div>
              </div>
              <div class="w-full h-2 bg-gray-200 rounded-full relative">
                <div
                  class="absolute top-1/2 left-0 -translate-y-1/2 h-1 rounded-full transition-all duration-300"
                  :style="{ width: form.status + '%', backgroundColor: progressColor }"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Save error banner -->
        <div
          v-if="saveError"
          class="flex items-start gap-2 px-3 py-2 rounded-[4px] bg-[#F52C11]/10 border border-[#F52C11]/30 text-[#F52C11] text-[10.5px]"
        >
          <svg class="w-3.5 h-3.5 mt-[1px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
          </svg>
          <span>{{ saveError }}</span>
        </div>

        <!-- Action Buttons (moved inside scrollable area) -->
        <div class="flex items-center justify-between gap-2 pt-1">
          <button
            type="button"
            @click="clearAllFields"
            class="flex items-center gap-1.5 px-3 py-[5px] rounded-[4px] text-[10px] font-medium text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm"
          >
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Clear all fields
          </button>

          <div class="flex items-center gap-2">
            <button
              type="button"
              @click="cancel"
              class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors shadow-sm"
            >
              Cancel
            </button>
            <button
              type="button"
              @click="saveRecord"
              :disabled="!isFormValid || isSaving"
              :class="[
                'px-4 py-[6px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors shadow-sm',
                isFormValid && !isSaving ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed',
              ]"
            >
              <svg
                v-if="isSaving"
                class="w-3 h-3 animate-spin"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isSaving ? "Saving..." : "Save record" }}
            </button>
          </div>
        </div>
      </div>
    </main>

    <!-- Date Picker Modal -->
    <div
      v-if="showDatePickerFor"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
      @click.self="showDatePickerFor = null"
    >
      <div class="bg-white rounded-[8px] w-[280px] shadow-xl p-4">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-[13px] font-bold text-[#1F2835]">Select Date</h3>
          <button
            @click="showDatePickerFor = null"
            class="text-gray-400 hover:text-[#1F2835]"
          >
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        <!-- Month/Year Navigation -->
        <div class="flex items-center justify-between mb-2">
          <button
            @click="prevMonth"
            class="p-1 hover:bg-gray-100 rounded text-gray-500"
          >
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 19l-7-7 7-7"
              />
            </svg>
          </button>
          <span class="text-[12px] font-semibold text-[#1F2835]">{{
            currentMonthYear
          }}</span>
          <button
            @click="nextMonth"
            class="p-1 hover:bg-gray-100 rounded text-gray-500"
          >
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9 5l7 7-7 7"
              />
            </svg>
          </button>
        </div>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-0.5 mb-1">
          <div
            v-for="(day, i) in ['S', 'M', 'T', 'W', 'T', 'F', 'S']"
            :key="i"
            class="text-center text-[9px] font-semibold text-gray-400 py-1"
          >
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
              date.isToday && !date.isSelected
                ? 'border border-[#F52C11] text-[#F52C11]'
                : '',
            ]"
          >
            {{ date.day }}
          </div>
        </div>

        <div
          class="flex items-center justify-end gap-2 mt-3 pt-2 border-t border-gray-100"
        >
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

import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import * as api from "./api.js";
import { useAuditLog } from "~/composables/useAuditLog";

// ============================================
// PAGE-OWNED STATE
// ============================================
const route = useRoute();

const runtimeConfig = useRuntimeConfig();
api.configureApi({
  baseURL: runtimeConfig.public.apiBase,
  getToken: () =>
    typeof localStorage !== "undefined" ? localStorage.getItem("token") : null,
});

const currentUser = ref(null);
async function loadCurrentUser() {
  try {
    const raw =
      typeof localStorage !== "undefined" ? localStorage.getItem("user") : null;
    currentUser.value = raw ? JSON.parse(raw) : null;
  } catch {
    currentUser.value = null;
  }

  if (currentUser.value?.id) return currentUser.value;

  const meResponse = await api.fetchCurrentUser();
  const meUser = meResponse?.data?.user || meResponse?.user || meResponse?.data;
  currentUser.value = meUser || currentUser.value;
  return currentUser.value;
}

// ============================================
// HARDCODED LOOKUP OPTIONS
// ============================================
// Location
const locationOptions = ref([
  { id: 1, name: "Davao" },
  { id: 2, name: "Manila" },
]);

// Prospect Technique
const prospectTechniqueOptions = ref([
  { id: 1, name: "Cold Calling" },
  { id: 2, name: "Cold Emailing" },
  { id: 3, name: "Social Media" },
  { id: 4, name: "Outreach" },
  { id: 5, name: "Direct Mail" },
  { id: 6, name: "Networking Events" },
  { id: 7, name: "Content Marketing" },
  { id: 8, name: "Social Media Ads" },
  { id: 9, name: "Website Inquiry" },
  { id: 10, name: "Referral" },
  { id: 11, name: "Calendly" },
]);

// Sales Representative
const salesRepOptions = ref([
  { id: 1, name: "SAM Supervisor" },
  { id: 2, name: "Asst. SAM Supervisor" },
  { id: 2, name: "Sales assistant" },
  // ... etc
]);

// Ways of Communication
const communicationOptions = ref([
  { id: 1, name: "Messenger" },
  { id: 2, name: "FB Page" },
  { id: 3, name: "Viber" },
  { id: 4, name: "Telegram" },
  { id: 5, name: "WhatsApp" },
  { id: 6, name: "Mobile Number" },
  { id: 7, name: "Email" },
]);

// Services
const serviceOptions = ref([
  { id: 1, name: "Website Development" },
  { id: 2, name: "Custom Software" },
  { id: 3, name: "Mobile Application" },
  { id: 4, name: "Digital Marketing" },
  { id: 5, name: "Multimedia" },
  { id: 6, name: "Hosting & Server" },
]);

const isLoadingLookups = ref(false);

function goToList() {
  const parent = route.path.replace(/\/[^/]+\/?$/, "") || "/";
  navigateTo(parent || "/");
}

const saveError = ref("");

// ============================================
// FORM DATA
// ============================================
const form = ref({
  dateRecorded: "",
  onboardingDate: "",
  clientName: "",
  location: "",
  prospectTechnique: "",
  salesRepresentative: [],
  email: "",
  waysOfCommunication: "",
  service: "",
  remarks: "",
  contactPersonName: "",
  contactPersonPhone: "",
  status: 30,
});

// ============================================
// ERROR STATE
// ============================================
const errors = ref({
  dateRecorded: false,
  clientName: false,
  prospectTechnique: false,
  salesRepresentative: false,
  email: false,
  waysOfCommunication: false,
  service: false,
  contactPersonName: false,
  contactPersonPhone: false,
});

// ============================================
// UI STATE
// ============================================
const showDatePickerFor = ref(null);
const selectedDate = ref(null);
const viewDate = ref(new Date());
const isSaving = ref(false);

// ============================================
// DROPDOWNS
// ============================================
const showLocationDropdown = ref(false);
const locationButtonRef = ref(null);
const locationPanelRef = ref(null);
const locationDropdownStyle = ref({});

const showTechniqueDropdown = ref(false);
const techniqueButtonRef = ref(null);
const techniquePanelRef = ref(null);
const techniqueDropdownStyle = ref({});

const showServiceDropdown = ref(false);
const serviceButtonRef = ref(null);
const servicePanelRef = ref(null);
const serviceDropdownStyle = ref({});

const showCommunicationDropdown = ref(false);
const communicationButtonRef = ref(null);
const communicationPanelRef = ref(null);
const communicationDropdownStyle = ref({});

const showSalesRepDropdown = ref(false);
const salesRepButtonRef = ref(null);
const salesRepPanelRef = ref(null);
const salesRepDropdownStyle = ref({});

const dropdownRegistry = {
  location: {
    show: showLocationDropdown,
    button: locationButtonRef,
    panel: locationPanelRef,
    style: locationDropdownStyle,
  },
  technique: {
    show: showTechniqueDropdown,
    button: techniqueButtonRef,
    panel: techniquePanelRef,
    style: techniqueDropdownStyle,
  },
  service: {
    show: showServiceDropdown,
    button: serviceButtonRef,
    panel: servicePanelRef,
    style: serviceDropdownStyle,
  },
  communication: {
    show: showCommunicationDropdown,
    button: communicationButtonRef,
    panel: communicationPanelRef,
    style: communicationDropdownStyle,
  },
  salesRep: {
    show: showSalesRepDropdown,
    button: salesRepButtonRef,
    panel: salesRepPanelRef,
    style: salesRepDropdownStyle,
  },
};

function positionDropdown(key) {
  const d = dropdownRegistry[key];
  const btn = d?.button.value;
  if (!btn) return;
  const rect = btn.getBoundingClientRect();
  d.style.value = {
    top: `${rect.bottom + 4}px`,
    left: `${rect.left}px`,
    width: `${rect.width}px`,
  };
}

function toggleDropdown(key) {
  const d = dropdownRegistry[key];
  if (!d) return;
  const opening = !d.show.value;
  Object.values(dropdownRegistry).forEach((entry) => {
    entry.show.value = false;
  });
  d.show.value = opening;
  if (opening) {
    nextTick(() => positionDropdown(key));
  } else {
    // reset any in-progress "add" inputs when the dropdown closes
    cancelAddService();
    cancelAddSalesRep();
  }
}

function selectLocation(id) {
  form.value.location = id;
  showLocationDropdown.value = false;
}

function selectTechnique(id) {
  form.value.prospectTechnique = id;
  showTechniqueDropdown.value = false;
}

function selectService(id) {
  form.value.service = id;
  showServiceDropdown.value = false;
}

function selectCommunication(id) {
  form.value.waysOfCommunication = id;
  showCommunicationDropdown.value = false;
}

function toggleSalesRep(repId) {
  const index = form.value.salesRepresentative.indexOf(repId);
  if (index > -1) {
    form.value.salesRepresentative.splice(index, 1);
  } else {
    form.value.salesRepresentative.push(repId);
  }
}

function removeSalesRep(repId) {
  const index = form.value.salesRepresentative.indexOf(repId);
  if (index > -1) {
    form.value.salesRepresentative.splice(index, 1);
  }
}

function salesRepName(repId) {
  return salesRepOptions.value.find((r) => r.id === repId)?.name || repId;
}

// ============================================
// ADD NEW SERVICE (inline, from Service dropdown)
// ============================================
const showAddServiceInput = ref(false);
const newServiceName = ref("");
const newServiceInputRef = ref(null);

function openAddService() {
  showAddServiceInput.value = true;
  nextTick(() => newServiceInputRef.value?.focus());
}

function cancelAddService() {
  showAddServiceInput.value = false;
  newServiceName.value = "";
}

function addNewService() {
  const name = newServiceName.value.trim();
  if (!name) {
    cancelAddService();
    return;
  }
  const nextId = Math.max(0, ...serviceOptions.value.map((s) => s.id)) + 1;
  serviceOptions.value.push({ id: nextId, name });
  form.value.service = nextId;
  cancelAddService();
  showServiceDropdown.value = false;

  // Expected request body shape for creating a service lookup on the backend:
  // await api.createServiceOption({ name });
}

// ============================================
// ADD NEW SALES REPRESENTATIVE (inline, from Sales Rep dropdown)
// ============================================
const showAddSalesRepInput = ref(false);
const newSalesRepName = ref("");
const newSalesRepInputRef = ref(null);

function openAddSalesRep() {
  showAddSalesRepInput.value = true;
  nextTick(() => newSalesRepInputRef.value?.focus());
}

function cancelAddSalesRep() {
  showAddSalesRepInput.value = false;
  newSalesRepName.value = "";
}

function addNewSalesRep() {
  const name = newSalesRepName.value.trim();
  if (!name) {
    cancelAddSalesRep();
    return;
  }
  const nextId = Math.max(0, ...salesRepOptions.value.map((r) => r.id)) + 1;
  salesRepOptions.value.push({ id: nextId, name });
  form.value.salesRepresentative.push(nextId);
  cancelAddSalesRep();

  // Expected request body shape for creating a sales rep lookup on the backend:
  // await api.createSalesRepOption({ name });
}

function handleDropdownsOutsideClick(e) {
  Object.values(dropdownRegistry).forEach((d) => {
    if (!d.show.value) return;
    const clickedButton = d.button.value?.contains(e.target);
    const clickedPanel = d.panel.value?.contains(e.target);
    if (!clickedButton && !clickedPanel) {
      d.show.value = false;
      cancelAddService();
      cancelAddSalesRep();
    }
  });
}

function handleDropdownsReposition() {
  Object.entries(dropdownRegistry).forEach(([key, d]) => {
    if (d.show.value) positionDropdown(key);
  });
}

onMounted(async () => {
  loadCurrentUser();
  await loadLookups();
  document.addEventListener("click", handleDropdownsOutsideClick);
  window.addEventListener("resize", handleDropdownsReposition);
  window.addEventListener("scroll", handleDropdownsReposition, true);
});

async function loadLookups() {
  isLoadingLookups.value = true;
  try {
    const lookups = await api.fetchLookups();
    // Only overwrite the hardcoded fallback arrays if the backend actually
    // returned data — keeps the form usable even if one endpoint is down.
    if (lookups.techniques?.length) prospectTechniqueOptions.value = lookups.techniques;
    if (lookups.salesReps?.length) salesRepOptions.value = lookups.salesReps;
    if (lookups.services?.length) serviceOptions.value = lookups.services;
    if (lookups.communications?.length) communicationOptions.value = lookups.communications;
    if (lookups.locations?.length) locationOptions.value = lookups.locations;
  } catch (error) {
    console.warn("Failed to fetch lookup options, using local fallback:", error);
  } finally {
    isLoadingLookups.value = false;
  }
}

onBeforeUnmount(() => {
  document.removeEventListener("click", handleDropdownsOutsideClick);
  window.removeEventListener("resize", handleDropdownsReposition);
  window.removeEventListener("scroll", handleDropdownsReposition, true);
});

// ============================================
// CONTACT PERSON PHONE - Philippine format
// ============================================
function formatContactPersonPhone() {
  const digitsOnly = form.value.contactPersonPhone
    .replace(/\D/g, "")
    .slice(0, 11);
  let formatted = digitsOnly;
  if (digitsOnly.length > 4 && digitsOnly.length <= 7) {
    formatted = `${digitsOnly.slice(0, 4)}-${digitsOnly.slice(4)}`;
  } else if (digitsOnly.length > 7) {
    formatted = `${digitsOnly.slice(0, 4)}-${digitsOnly.slice(
      4,
      7
    )}-${digitsOnly.slice(7)}`;
  }
  form.value.contactPersonPhone = formatted;
}

function handleContactKeydown(e) {
  const allowed = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];
  if (allowed.includes(e.key)) return;
  if (!/^[0-9]$/.test(e.key)) e.preventDefault();
}

// ============================================
// EMAIL VALIDATION
// ============================================
function isValidEmail(value) {
  if (!value || !value.trim()) return true;
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
}

function validateEmailField() {
  errors.value.email = !isValidEmail(form.value.email);
}

// ============================================
// STATUS / PROGRESS
// ============================================
const progressColorPalette = [
  "#f52c11", // 1-10
  "#fa6f10", // 11-20
  "#ffb300", // 21-30
  "#ffd60a", // 31-40
  "#888888", // 41-50
  "#6b7a8f", // 51-60
  "#7fb069", // 61-70
  "#5e8c31", // 71-80
  "#4f772d", // 81-90
  "#639922", // 91-100
];

const progressColor = computed(() => {
  const value = Number(form.value.status) || 0;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return progressColorPalette[bucket - 1];
});

function clampProgress() {
  let value = Number(form.value.status);
  if (isNaN(value)) value = 0;
  form.value.status = Math.min(100, Math.max(0, Math.round(value)));
}

function incrementProgress() {
  const current = Number(form.value.status) || 0;
  form.value.status = Math.min(100, current + 10);
}

function decrementProgress() {
  const current = Number(form.value.status) || 0;
  form.value.status = Math.max(0, current - 10);
}

// ============================================
// COMPUTED
// ============================================
const locationLabel = computed(
  () =>
    locationOptions.value.find((l) => l.id === form.value.location)?.name ||
    ""
);
const techniqueLabel = computed(
  () =>
    prospectTechniqueOptions.value.find(
      (t) => t.id === form.value.prospectTechnique
    )?.name || ""
);
const serviceLabel = computed(
  () =>
    serviceOptions.value.find((s) => s.id === form.value.service)?.name || ""
);
const communicationLabel = computed(
  () =>
    communicationOptions.value.find(
      (c) => c.id === form.value.waysOfCommunication
    )?.name || ""
);

const currentMonthYear = computed(() => {
  return viewDate.value.toLocaleDateString("en-US", {
    month: "long",
    year: "numeric",
  });
});

const calendarDates = computed(() => {
  const year = viewDate.value.getFullYear();
  const month = viewDate.value.getMonth();

  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const startDayOfWeek = firstDay.getDay();

  const dates = [];
  const today = new Date();

  const prevMonthLastDay = new Date(year, month, 0).getDate();
  for (let i = startDayOfWeek - 1; i >= 0; i--) {
    dates.push({
      key: `prev-${i}`,
      day: prevMonthLastDay - i,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false,
    });
  }

  for (let day = 1; day <= lastDay.getDate(); day++) {
    const dateObj = new Date(year, month, day);
    const isToday = dateObj.toDateString() === today.toDateString();
    const isSelected =
      selectedDate.value &&
      dateObj.toDateString() === selectedDate.value.toDateString();

    dates.push({
      key: `current-${day}`,
      day,
      isCurrentMonth: true,
      isSelected,
      isToday,
      dateObj,
    });
  }

  const remaining = 42 - dates.length;
  for (let day = 1; day <= remaining; day++) {
    dates.push({
      key: `next-${day}`,
      day,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false,
    });
  }

  return dates;
});

const isFormValid = computed(() => {
  return isValidEmail(form.value.email);
});

// ============================================
// CALENDAR METHODS
// ============================================
function prevMonth() {
  viewDate.value = new Date(
    viewDate.value.getFullYear(),
    viewDate.value.getMonth() - 1,
    1
  );
}

function nextMonth() {
  viewDate.value = new Date(
    viewDate.value.getFullYear(),
    viewDate.value.getMonth() + 1,
    1
  );
}

function selectDate(date) {
  if (!date.isCurrentMonth) {
    if (date.day > 20) {
      prevMonth();
    } else {
      nextMonth();
    }
    return;
  }
  selectedDate.value = date.dateObj;
}

function confirmDate() {
  if (selectedDate.value && showDatePickerFor.value) {
    const formattedDate = selectedDate.value.toLocaleDateString("en-US", {
      month: "2-digit",
      day: "2-digit",
      year: "numeric",
    });
    form.value[showDatePickerFor.value] = formattedDate;
  }
  showDatePickerFor.value = null;
}

// ============================================
// VALIDATION
// ============================================
function validateForm() {
  errors.value.dateRecorded = false;
  errors.value.clientName = false;
  errors.value.prospectTechnique = false;
  errors.value.salesRepresentative = false;
  errors.value.email = !isValidEmail(form.value.email);
  errors.value.waysOfCommunication = false;
  errors.value.service = false;
  errors.value.contactPersonName = false;
  errors.value.contactPersonPhone = false;

  return !Object.values(errors.value).some((error) => error);
}

function resetErrors() {
  errors.value = {
    dateRecorded: false,
    clientName: false,
    prospectTechnique: false,
    salesRepresentative: false,
    email: false,
    waysOfCommunication: false,
    service: false,
    contactPersonName: false,
    contactPersonPhone: false,
  };
}

// ============================================
// ACTIONS
// ============================================
function clearAllFields() {
  form.value = {
    dateRecorded: "",
    onboardingDate: "",
    clientName: "",
    location: "",
    prospectTechnique: "",
    salesRepresentative: [],
    email: "",
    waysOfCommunication: "",
    service: "",
    remarks: "",
    contactPersonName: "",
    contactPersonPhone: "",
    status: 30,
  };
  selectedDate.value = null;
  Object.values(dropdownRegistry).forEach((d) => {
    d.show.value = false;
  });
  cancelAddService();
  cancelAddSalesRep();
  resetErrors();
}

function cancel() {
  clearAllFields();
  goToList();
}

const { logAuditAction } = useAuditLog();

async function saveRecord() {
  if (!validateForm()) return;

  isSaving.value = true;
  saveError.value = "";

  try {
    const user = await loadCurrentUser();

    if (!user?.id) {
      throw new Error(
        "Unable to identify the current user. Please log in again."
      );
    }

    const payload = {
      dateRecorded: form.value.dateRecorded,
      onboardingDate: form.value.onboardingDate,
      clientName: form.value.clientName,
      location: form.value.location,
      prospectTechnique: form.value.prospectTechnique,
      salesRepresentative: form.value.salesRepresentative,
      email: form.value.email,
      waysOfCommunication: form.value.waysOfCommunication,
      service: form.value.service,
      remarks: form.value.remarks,
      contactPersonName: form.value.contactPersonName,
      contactPersonPhone: form.value.contactPersonPhone,
      status: form.value.status,
    };

    const backendPayload = api.toBackendPayload(payload, user.id);
    await api.createPerformancePlan(backendPayload);

    logAuditAction({
      module: "Performance Improvement Plan",
      description: `Created new PIP record for ${form.value.clientName}`,
    });

    clearAllFields();
    goToList();
  } catch (error) {
    console.error("Failed to save record:", error);
    saveError.value = describeApiError(error);
  } finally {
    isSaving.value = false;
  }
}

function describeApiError(error) {
  const fieldErrors = error?.data?.errors;
  if (fieldErrors && typeof fieldErrors === "object") {
    const firstMessages = Object.values(fieldErrors).flat();
    if (firstMessages.length) return firstMessages.join(" ");
  }
  return (
    error?.message || "Something went wrong while saving. Please try again."
  );
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

.scrollbar-red::-webkit-scrollbar {
  width: 6px;
}
.scrollbar-red::-webkit-scrollbar-track {
  background: transparent;
}
.scrollbar-red::-webkit-scrollbar-thumb {
  background: #F52C11;
  border-radius: 3px;
}
.scrollbar-red::-webkit-scrollbar-thumb:hover {
  background: #d9250e;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

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

select option {
  color: #1f2835;
  background-color: #ffffff;
}

select option:checked {
  color: #1f2835;
  background-color: #ffffff;
}

select option:hover {
  background-color: #f3f4f6;
}

select:focus option:checked {
  background-color: #ffffff;
  color: #1f2835;
}

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