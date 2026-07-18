<template>
  <div
    class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#e5e5e5] font-['Overpass'] text-[13px] text-[#1F2835]"
  >
    <div
      class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200"
    >
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
        <span class="cursor-pointer transition-colors hover:text-[#F52C11]"
          >Leads Tracker</span
        >
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
        <span class="cursor-pointer transition-colors hover:text-[#F52C11]"
          >Leads</span
        >
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
        <span class="text-[#F52C11] font-medium">Industry</span>
      </div>
    </div>
    <main class="flex-1 flex flex-col min-h-0 overflow-hidden">
      <div class="flex-1 overflow-y-auto p-6 md:p-8">
        <div class="max-w-4xl mx-auto w-full">
          <div class="mb-4">
            <h1 class="text-[15px] font-bold text-[#1F2835] leading-tight">
              Add new record
            </h1>
            <p class="text-[10px] text-gray-500 mt-0.5">
              Industry page – Leads Tracker
            </p>
            <p
              v-if="saveError"
              class="mt-1 text-[10px] font-medium text-[#F52C11]"
            >
              {{ saveError }}
            </p>
          </div>

          <div class="w-full space-y-3">
            <div
              class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
            >
              <div class="flex items-center gap-1.5 px-3 py-2">
                <div
                  class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
                >
                  <svg
                    class="w-2.5 h-2.5 text-[#F52C11]"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                    />
                  </svg>
                </div>
                <div>
                  <h2
                    class="text-[11px] font-bold text-[#1F2835] leading-tight"
                  >
                    Business information
                  </h2>
                  <p class="text-[9px] text-gray-400 leading-tight">
                    Enter the lead's contact and company details
                  </p>
                </div>
              </div>

              <div class="px-3 pt-3 pb-2.5 border-t border-gray-100">
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Business name
                    </label>
                    <input
                      v-model="form.businessName"
                      type="text"
                      placeholder="Enter business name"
                      :class="[
                        'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                        errors.businessName
                          ? 'border-[#F52C11]'
                          : 'border-gray-200 focus:border-[#F52C11]',
                      ]"
                      @keyup.enter="saveRecord"
                    />
                    <p
                      v-if="errors.businessName"
                      class="text-[8px] text-[#F52C11] mt-0.5"
                    >
                      Business name is required
                    </p>
                  </div>

                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Job position
                    </label>
                    <input
                      v-model="form.jobPosition"
                      type="text"
                      placeholder="CEO, Owner, Manager..."
                      class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                      @keyup.enter="saveRecord"
                    />
                  </div>

                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Contact person
                    </label>
                    <input
                      v-model="form.contactPerson"
                      type="text"
                      placeholder="Enter a name"
                      :class="[
                        'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                        errors.contactPerson
                          ? 'border-[#F52C11]'
                          : 'border-gray-200 focus:border-[#F52C11]',
                      ]"
                      @keyup.enter="saveRecord"
                    />
                  </div>

                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Email
                    </label>
                    <input
                      v-model="form.email"
                      type="email"
                      placeholder="example@company.com"
                      :class="[
                        'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                        errors.email
                          ? 'border-[#F52C11]'
                          : 'border-gray-200 focus:border-[#F52C11]',
                      ]"
                      @blur="validateEmailField"
                      @keyup.enter="saveRecord"
                    />
                    <p
                      v-if="errors.email"
                      class="text-[8px] text-[#F52C11] mt-0.5"
                    >
                      Enter a valid email (must include @)
                    </p>
                  </div>

                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Contact number
                    </label>
                    <input
                      v-model="form.contactNumber"
                      type="text"
                      inputmode="numeric"
                      maxlength="11"
                      placeholder="09XXXXXXXXX"
                      :class="[
                        'w-full bg-white border rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                        errors.contactNumber
                          ? 'border-[#F52C11]'
                          : 'border-gray-200 focus:border-[#F52C11]',
                      ]"
                      @keydown="blockNonDigits"
                      @blur="validateContactNumberField"
                      @keyup.enter="saveRecord"
                    />
                    <p
                      v-if="errors.contactNumber"
                      class="text-[8px] text-[#F52C11] mt-0.5"
                    >
                      Enter the complete 11-digit number
                    </p>
                  </div>

                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Service
                    </label>
                    <div class="relative">
                      <button
                        type="button"
                        ref="serviceTriggerRef"
                        @click="toggleServiceDropdown"
                        :class="[
                          'w-full flex items-center justify-between border rounded-[4px] px-2.5 py-[5px] text-[11px] bg-white focus:outline-none transition-colors cursor-pointer',
                          errors.service
                            ? 'border-[#F52C11]'
                            : showServiceDropdown
                            ? 'border-[#F52C11]'
                            : 'border-gray-200',
                          form.service ? 'text-[#1F2835]' : 'text-gray-400',
                        ]"
                      >
                        <span class="truncate">{{
                          form.service || "Select a service"
                        }}</span>
                        <svg
                          :class="[
                            'w-2.5 h-2.5 shrink-0 ml-1.5 transition-transform',
                            showServiceDropdown
                              ? 'text-[#F52C11] rotate-180'
                              : 'text-[#F52C11]',
                          ]"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                          />
                        </svg>
                      </button>

                      <teleport to="body">
                        <div
                          v-if="showServiceDropdown"
                          ref="servicePanelRef"
                          :style="servicePanelStyle"
                          class="fixed z-[9999] bg-white border border-gray-200 rounded-[6px] shadow-lg overflow-hidden"
                        >
                          <div class="max-h-48 overflow-y-auto scrollbar-red">
                            <div
                              v-for="service in serviceOptions"
                              :key="service"
                              :class="[
                                'group flex items-center px-3 py-1.5 cursor-pointer transition-colors',
                                form.service === service
                                  ? 'bg-[#F52C11]/10 text-[#F52C11]'
                                  : 'hover:bg-[#F52C11]/5 hover:text-[#1F2835]',
                              ]"
                              @click="selectService(service)"
                            >
                              <span class="text-[11px]">{{ service }}</span>
                            </div>
                          </div>
                          <!-- Inline add new service (like PIP) -->
                          <div
                            class="border-t border-gray-100 px-2 py-1"
                            @click.stop
                          >
                            <div
                              v-if="!showAddServiceInput"
                              @click="openAddService"
                              class="flex items-center gap-1.5 px-1 py-1.5 text-[11px] text-[#F52C11] font-medium cursor-pointer hover:bg-[#F52C11]/5 rounded-[4px] transition-colors"
                            >
                              <svg
                                class="w-2.5 h-2.5 text-[#F52C11]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                viewBox="0 0 24 24"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 4v16m8-8H4"
                                />
                              </svg>
                              <span
                                class="text-[11px] font-medium text-[#F52C11]"
                                >Add new service</span
                              >
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
                              <button
                                type="button"
                                @click="addNewService"
                                class="text-[#F52C11] hover:text-[#d9250e] text-[10px] font-semibold px-1.5"
                              >
                                Add
                              </button>
                            </div>
                          </div>
                        </div>
                      </teleport>
                    </div>
                    <p
                      v-if="errors.service"
                      class="text-[8px] text-[#F52C11] mt-0.5"
                    >
                      Service is required
                    </p>
                  </div>

                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Date
                    </label>
                    <div class="relative">
                      <input
                        v-model="form.date"
                        type="text"
                        placeholder="mm/dd/yyyy"
                        readonly
                        :class="[
                          'w-full border rounded-[4px] px-2.5 py-[5px] pr-8 text-[11px] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer',
                          errors.date
                            ? 'border-[#F52C11] bg-white'
                            : 'border-gray-200 bg-white',
                        ]"
                        @click="showDatePicker = true"
                      />
                      <button
                        @click="showDatePicker = true"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F52C11] transition-colors"
                        type="button"
                      >
                        <svg
                          class="w-3.5 h-3.5"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                          />
                        </svg>
                      </button>
                    </div>
                    <p
                      v-if="errors.date"
                      class="text-[8px] text-[#F52C11] mt-0.5"
                    >
                      Date is required
                    </p>
                  </div>

                  <div>
                    <label
                      class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                    >
                      Remarks
                    </label>
                    <input
                      v-model="form.remarks"
                      type="text"
                      placeholder="Notes about this lead, follow-up actions, outcomes..."
                      class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[5px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                      @keyup.enter="saveRecord"
                    />
                  </div>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div
                class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
              >
                <div class="flex items-center gap-1.5 px-3 py-1.5">
                  <div
                    class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
                  >
                    <svg
                      class="w-2.5 h-2.5 text-[#F52C11]"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                    </svg>
                  </div>
                  <div>
                    <h2
                      class="text-[11px] font-bold text-[#1F2835] leading-tight"
                    >
                      Location <span class="text-[#F52C11]">*</span>
                    </h2>
                    <p class="text-[9px] text-gray-400 leading-tight">
                      The primary operating location for this lead.
                    </p>
                  </div>
                </div>

                <div class="px-3 pb-2.5 pt-1">
                  <div class="relative">
                    <button
                      type="button"
                      ref="locationTriggerRef"
                      @click="toggleLocationDropdown"
                      :class="[
                        'w-full flex items-center justify-between border rounded-[4px] px-2.5 py-[5px] text-[11px] bg-white focus:outline-none transition-colors cursor-pointer',
                        errors.location
                          ? 'border-[#F52C11]'
                          : showLocationDropdown
                          ? 'border-[#F52C11]'
                          : 'border-gray-200',
                        form.location ? 'text-[#1F2835]' : 'text-gray-400',
                      ]"
                    >
                      <span class="truncate">{{
                        form.location || "Select a location"
                      }}</span>
                      <svg
                        :class="[
                          'w-2.5 h-2.5 shrink-0 ml-1.5 transition-transform',
                          showLocationDropdown
                            ? 'text-[#F52C11] rotate-180'
                            : 'text-[#F52C11]',
                        ]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19 9l-7 7-7-7"
                        />
                      </svg>
                    </button>

                    <teleport to="body">
                      <div
                        v-if="showLocationDropdown"
                        ref="locationPanelRef"
                        :style="locationPanelStyle"
                        class="fixed z-[9999] bg-white border border-gray-200 rounded-[6px] shadow-lg overflow-hidden"
                      >
                        <div class="max-h-48 overflow-y-auto scrollbar-red">
                          <div
                            v-for="loc in locationOptions"
                            :key="loc"
                            :class="[
                              'px-3 py-1.5 cursor-pointer transition-colors text-[11px]',
                              form.location === loc
                                ? 'bg-[#F52C11]/10 text-[#F52C11]'
                                : 'hover:bg-[#F52C11]/5 text-[#1F2835]',
                            ]"
                            @click="selectLocation(loc)"
                          >
                            {{ loc }}
                          </div>
                        </div>
                      </div>
                    </teleport>
                  </div>
                  <p
                    v-if="errors.location"
                    class="text-[8px] text-[#F52C11] mt-0.5"
                  >
                    Location is required
                  </p>
                </div>
              </div>

              <div
                class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
              >
                <div class="flex items-center gap-1.5 px-3 py-1.5">
                  <div
                    class="w-5 h-5 rounded-full bg-[#F52C11]/10 flex items-center justify-center shrink-0"
                  >
                    <svg
                      class="w-2.5 h-2.5 text-[#F52C11]"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                      />
                    </svg>
                  </div>
                  <div>
                    <h2
                      class="text-[11px] font-bold text-[#1F2835] leading-tight"
                    >
                      Status and progress
                    </h2>
                    <p class="text-[9px] text-gray-400 leading-tight">
                      Set the current lead stage
                    </p>
                  </div>
                </div>

                <div class="px-3 pb-2.5 pt-1">
                  <div class="flex items-center justify-between mb-1">
                    <div>
                      <label
                        class="block text-[10px] font-semibold text-[#1F2835]"
                        >Status</label
                      >
                      <p class="text-[8px] text-gray-400">
                        Progress bar updates automatically
                      </p>
                    </div>

                    <div class="flex items-center gap-1">
                      <div
                        class="flex items-center border border-gray-200 rounded-[4px] overflow-hidden"
                      >
                        <input
                          v-model.number="form.progress"
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
                          <button
                            type="button"
                            @click="incrementProgress"
                            class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors"
                          >
                            <svg
                              class="w-2 h-2"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="3"
                              viewBox="0 0 24 24"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 15l7-7 7 7"
                              />
                            </svg>
                          </button>
                          <button
                            type="button"
                            @click="decrementProgress"
                            class="w-4 h-[10px] flex items-center justify-center text-gray-400 hover:text-[#F52C11] hover:bg-gray-50 transition-colors"
                          >
                            <svg
                              class="w-2 h-2"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="3"
                              viewBox="0 0 24 24"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                              />
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
                      :style="{
                        width: form.progress + '%',
                        backgroundColor: progressColor,
                      }"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Save error banner (moved inside scrollable area like PIP) -->
          <div
            v-if="saveError"
            class="flex items-start gap-2 px-3 py-2 rounded-[4px] bg-[#F52C11]/10 border border-[#F52C11]/30 text-[#F52C11] text-[10.5px] mt-3"
          >
            <svg
              class="w-3.5 h-3.5 mt-[1px] shrink-0"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
              />
            </svg>
            <span>{{ saveError }}</span>
          </div>

          <!-- Action Buttons (moved inside scrollable area like PIP) -->
          <div class="flex items-center justify-between gap-2 pt-4">
            <!-- Clear all fields -->
            <button
              type="button"
              @click="clearAllFields"
              class="flex items-center gap-1.5 px-3 py-[5px] rounded-[4px] text-[10px] font-medium text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm"
            >
              <svg
                class="w-3 h-3"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                />
              </svg>
              Clear all fields
            </button>

            <div class="flex items-center gap-2">
              <!-- Cancel -->
              <button
                type="button"
                @click="cancel"
                class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors shadow-sm"
              >
                Cancel
              </button>

              <!-- Save record -->
              <button
                type="button"
                @click="saveRecord"
                :disabled="!isFormValid || isSaving"
                :class="[
                  'px-4 py-[6px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors shadow-sm',
                  isFormValid && !isSaving
                    ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white'
                    : 'bg-gray-300 text-gray-500 cursor-not-allowed',
                ]"
              >
                <svg
                  v-if="isSaving"
                  class="w-3 h-3 animate-spin"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
                {{ isSaving ? "Saving..." : "Save record" }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- REMOVED: Fixed footer with buttons (now inside scrollable area above) -->
    </main>

    <div
      v-if="showDatePicker"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
      @click.self="showDatePicker = false"
    >
      <div class="bg-white rounded-[8px] w-[280px] shadow-xl p-4">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-[13px] font-bold text-[#1F2835]">Select Date</h3>
          <button
            @click="showDatePicker = false"
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

    <!-- REMOVED: Create new service modal (now inline in dropdown) -->
  </div>
</template>

<script setup>
definePageMeta({
  layout: "app",
  middleware: "auth",
});

import { ref, computed, onMounted, onUnmounted, nextTick, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useApi } from "~/composables/useApi";
import { useAuditLog } from "~/composables/useAuditLog";

const route = useRoute();
const router = useRouter();
const { apiFetch } = useApi();

const industryId = ref(
  route.query.industryId || route.query.industry_id || null
);
const currentUserId = ref(route.query.userId || route.query.user_id || null);

async function resolveCurrentUserId() {
  if (currentUserId.value) return currentUserId.value;

  const cachedUserId = getStoredUserId();
  if (cachedUserId) {
    currentUserId.value = cachedUserId;
    return currentUserId.value;
  }

  try {
    const meResponse = await apiFetch("/me");
    const meUser = meResponse?.data?.user || meResponse?.user;
    currentUserId.value = meUser?.id || null;
  } catch {
    currentUserId.value = null;
  }

  return currentUserId.value;
}

const locationOptions = ref(["Davao", "Manila"]);

const form = ref({
  businessName: "",
  jobPosition: "",
  contactPerson: "",
  email: "",
  contactNumber: "",
  service: "",
  date: "",
  remarks: "",
  location: "",
  progress: 0,
});

const errors = ref({
  businessName: false,
  contactPerson: false,
  service: false,
  date: false,
  email: false,
  contactNumber: false,
  location: false,
});

const showDatePicker = ref(false);
const selectedDate = ref(null);
const viewDate = ref(new Date());
const isSaving = ref(false);
const saveError = ref("");

const serviceOptions = ref([
  "Website Development",
  "Custome Software",
  "Mobile Application",
  "Digital Marketing",
  "Multimedia",
  "Hosting & Server",
]);
// Location dropdown state
const showLocationDropdown = ref(false);
const locationTriggerRef = ref(null);
const locationPanelRef = ref(null);
const locationPanelStyle = ref({});

function updateLocationPanelPosition() {
  if (!locationTriggerRef.value) return;
  const rect = locationTriggerRef.value.getBoundingClientRect();
  locationPanelStyle.value = {
    top: `${rect.bottom + 4}px`,
    left: `${rect.left}px`,
    width: `${rect.width}px`,
  };
}

function toggleLocationDropdown() {
  showLocationDropdown.value = !showLocationDropdown.value;
  if (showLocationDropdown.value) {
    nextTick(updateLocationPanelPosition);
  }
}

function selectLocation(loc) {
  form.value.location = loc;
  errors.value.location = false;
  showLocationDropdown.value = false;
}

function handleClickOutsideLocationDropdown(event) {
  const clickedTrigger =
    locationTriggerRef.value && locationTriggerRef.value.contains(event.target);
  const clickedPanel =
    locationPanelRef.value && locationPanelRef.value.contains(event.target);
  if (!clickedTrigger && !clickedPanel) {
    showLocationDropdown.value = false;
  }
}

onMounted(() => {
  document.addEventListener("click", handleClickOutsideLocationDropdown);
  window.addEventListener("resize", updateLocationPanelPosition);
  window.addEventListener("scroll", updateLocationPanelPosition, true);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutsideLocationDropdown);
  window.removeEventListener("resize", updateLocationPanelPosition);
  window.removeEventListener("scroll", updateLocationPanelPosition, true);
});
// REMOVED: Modal-based create service state
// const showCreateService = ref(false);
// const newServiceName = ref("");
// const isCreatingService = ref(false);
// const createServiceError = ref("");

// ADDED: Inline add service state (like PIP)
const showAddServiceInput = ref(false);
const newServiceName = ref("");
const newServiceInputRef = ref(null);

// Custom Service dropdown state
const showServiceDropdown = ref(false);
const serviceTriggerRef = ref(null);
const servicePanelRef = ref(null);
const servicePanelStyle = ref({});

// The panel is teleported to <body> (so the card's overflow-hidden can't
// clip it), so its position has to be computed manually from the trigger.
function updateServicePanelPosition() {
  if (!serviceTriggerRef.value) return;
  const rect = serviceTriggerRef.value.getBoundingClientRect();
  servicePanelStyle.value = {
    top: `${rect.bottom + 4}px`,
    left: `${rect.left}px`,
    width: `${rect.width}px`,
  };
}

function toggleServiceDropdown() {
  showServiceDropdown.value = !showServiceDropdown.value;
  if (showServiceDropdown.value) {
    nextTick(updateServicePanelPosition);
  } else {
    cancelAddService();
  }
}

function selectService(service) {
  form.value.service = service;
  errors.value.service = false;
  showServiceDropdown.value = false;
}

// REMOVED: Modal-based add service handlers
// function handleAddNewServiceClick() {
//   showServiceDropdown.value = false;
//   openCreateService();
// }

// function openCreateService() {
//   newServiceName.value = "";
//   createServiceError.value = "";
//   showCreateService.value = true;
// }

// function closeCreateService() {
//   showCreateService.value = false;
// }

// async function createService() { ... }

// ADDED: Inline add service handlers (like PIP)
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
  if (
    serviceOptions.value.some((s) => s.toLowerCase() === name.toLowerCase())
  ) {
    // Optionally show error inline, but for now just cancel
    cancelAddService();
    return;
  }
  serviceOptions.value.push(name);
  form.value.service = name;
  errors.value.service = false;
  cancelAddService();
  showServiceDropdown.value = false;

  // Sync with backend
  try {
    apiFetch("/services", {
      method: "POST",
      body: { service_name: name, name },
    });
  } catch (error) {
    console.error("Failed to sync new service:", error);
  }
}

async function deleteService(service) {
  const confirmed = window.confirm(
    `Delete "${service}"? This can't be undone.`
  );
  if (!confirmed) return;

  const previousOptions = serviceOptions.value;
  serviceOptions.value = serviceOptions.value.filter((s) => s !== service);
  if (form.value.service === service) {
    form.value.service = "";
  }

  try {
    await apiFetch("/services", {
      method: "DELETE",
      body: { service_name: service, name: service },
    });
  } catch (error) {
    // Roll back if the deletion didn't actually succeed server-side
    serviceOptions.value = previousOptions;
    console.error("Failed to delete service:", error);
  }
}

function handleClickOutsideServiceDropdown(event) {
  const clickedTrigger =
    serviceTriggerRef.value && serviceTriggerRef.value.contains(event.target);
  const clickedPanel =
    servicePanelRef.value && servicePanelRef.value.contains(event.target);
  if (!clickedTrigger && !clickedPanel) {
    showServiceDropdown.value = false;
    cancelAddService();
  }
}

onMounted(() => {
  document.addEventListener("click", handleClickOutsideServiceDropdown);
  window.addEventListener("resize", updateServicePanelPosition);
  window.addEventListener("scroll", updateServicePanelPosition, true);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutsideServiceDropdown);
  window.removeEventListener("resize", updateServicePanelPosition);
  window.removeEventListener("scroll", updateServicePanelPosition, true);
});

function payloadData(response) {
  return response?.data ?? response;
}

function getStoredUserId() {
  try {
    return JSON.parse(localStorage.getItem("user") || "null")?.id || null;
  } catch {
    return null;
  }
}

async function resolveIndustryId() {
  if (industryId.value) return industryId.value;

  const industriesResponse = await apiFetch("/industries");
  const industries = payloadData(industriesResponse);
  if (Array.isArray(industries) && industries.length > 0) {
    industryId.value = industries[0].id;
  }

  return industryId.value;
}

function normalizeServiceNames(payload) {
  const data = payloadData(payload);
  if (!Array.isArray(data)) return [];
  return data
    .map((service) => service.service_name || service.name || service)
    .filter(Boolean);
}

// Block letters/symbols from being typed, but no auto-formatting.
function blockNonDigits(e) {
  const allowed = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];
  if (allowed.includes(e.key) || e.metaKey || e.ctrlKey) return;
  if (!/^[0-9]$/.test(e.key)) e.preventDefault();
}

// Contact number is now optional. If left blank, it's valid.
// If the user starts typing, it must resolve to a complete 11-digit number.
function isValidContactNumber(value) {
  const digits = (value || "").replace(/\D/g, "");
  if (digits.length === 0) return true;
  return digits.length === 11;
}

function validateContactNumberField() {
  errors.value.contactNumber = !isValidContactNumber(form.value.contactNumber);
}

function isValidEmail(value) {
  if (!value || !value.trim()) return true;
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
}

function validateEmailField() {
  errors.value.email = !isValidEmail(form.value.email);
}

const progressColorPalette = [
  "#f52c11",
  "#fa6f10",
  "#ffb300",
  "#ffd60a",
  "#888888",
  "#6b7a8f",
  "#7fb069",
  "#5e8c31",
  "#4f772d",
  "#639922",
];

const progressColor = computed(() => {
  const value = Number(form.value.progress) || 0;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return progressColorPalette[bucket - 1];
});

function clampProgress() {
  let value = Number(form.value.progress);
  if (isNaN(value)) value = 0;
  form.value.progress = Math.min(100, Math.max(0, Math.round(value)));
}

// Stepper increments updates
function incrementProgress() {
  const current = Number(form.value.progress) || 0;
  form.value.progress = Math.min(100, current + 10);
}

// Stepper decrements updates
function decrementProgress() {
  const current = Number(form.value.progress) || 0;
  form.value.progress = Math.max(0, current - 10);
}

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

// Only Location remains a hard requirement on the frontend.
// Contact person / Contact number are optional but still validated
// for shape if the user chooses to fill them in.
const isFormValid = computed(() => {
  return !!form.value.location;
});

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
  if (selectedDate.value) {
    const year = selectedDate.value.getFullYear();
    const month = String(selectedDate.value.getMonth() + 1).padStart(2, "0");
    const day = String(selectedDate.value.getDate()).padStart(2, "0");
    form.value.date = `${month}/${day}/${year}`;
  }
  showDatePicker.value = false;
}

function validateForm() {
  // Reset all errors first
  errors.value = {
    businessName: false,
    contactPerson: false,
    service: false,
    date: false,
    email: false,
    contactNumber: false,
    location: false,
  };

  // Only location is required
  errors.value.location = !form.value.location;

  return !errors.value.location;
}
function resetErrors() {
  errors.value = {
    businessName: false,
    contactPerson: false,
    service: false,
    date: false,
    email: false,
    contactNumber: false,
    location: false,
  };
}

function clearAllFields() {
  form.value = {
    businessName: "",
    jobPosition: "",
    contactPerson: "",
    email: "",
    contactNumber: "",
    service: "",
    date: "",
    remarks: "",
    location: "",
    progress: 0,
  };
  showServiceDropdown.value = false;
  selectedDate.value = null;
  cancelAddService();
  resetErrors();
}

function cancel() {
  clearAllFields();
  if (window.history.state && window.history.state.back) {
    router.back();
  } else {
    router.push({
      path: "/industry",
      query: {
        location: route.query.location || "",
        industryId: industryId.value || "",
        industry_id: industryId.value || "",
      },
    });
  }
}

const { logAuditAction } = useAuditLog();

async function saveRecord() {
  if (isSaving.value) return;
  if (!validateForm()) return;
  isSaving.value = true;
  saveError.value = "";

  try {
    const [userId, selectedIndustryId] = await Promise.all([
      resolveCurrentUserId(),
      resolveIndustryId(),
    ]);

    if (!userId) {
      throw new Error(
        "Unable to identify the current user. Please log in again."
      );
    }

    if (!selectedIndustryId) {
      throw new Error("Please select an industry before saving this record.");
    }

    await apiFetch("/leads", {
      method: "POST",
      body: {
        user_id: userId,
        userId,
        date: form.value.date,
        business_name: form.value.businessName,
        businessName: form.value.businessName,
        job_position: form.value.jobPosition,
        jobPosition: form.value.jobPosition,
        contact_person: form.value.contactPerson,
        contactPerson: form.value.contactPerson,
        email: form.value.email,
        contact_number: form.value.contactNumber,
        contactNumber: form.value.contactNumber,
        service_name: form.value.service,
        service: form.value.service,
        status_name: "Emailed",
        status_percent: form.value.progress,
        progress: form.value.progress,
        remarks: form.value.remarks,
        location: form.value.location,
        industry_id: selectedIndustryId,
        industryId: selectedIndustryId,
      },
    });

    logAuditAction({
      module: "Leads Tracker",
      description: `Created new lead record for ${form.value.businessName}`,
    });

    await router.push({
      path: "/industry",
      query: {
        location: form.value.location,
        industryId: selectedIndustryId,
        industry_id: selectedIndustryId,
      },
    });
  } catch (error) {
    console.error("Failed to save record:", error);
    saveError.value =
      error?.data?.message ||
      error?.response?._data?.message ||
      error?.statusMessage ||
      error?.message ||
      "Unable to save this record. Please check the details and try again.";
  } finally {
    isSaving.value = false;
  }
}

onMounted(async () => {
  try {
    const [servicesResponse, industriesResponse] = await Promise.all([
      apiFetch("/services"),
      apiFetch("/industries"),
    ]);

    const services = normalizeServiceNames(servicesResponse);
    if (services.length > 0) {
      serviceOptions.value = services;
    }

    const industries = payloadData(industriesResponse);
    if (
      !industryId.value &&
      Array.isArray(industries) &&
      industries.length > 0
    ) {
      industryId.value = industries[0].id;
    }

    const meResponse = await apiFetch("/me");
    const meUser = meResponse?.data?.user || meResponse?.user;
    currentUserId.value =
      meUser?.id || getStoredUserId() || currentUserId.value;
  } catch {
    // Keep internal fallbacks if API endpoints are unreachable
  }
});

watch(
  () => route.query.industryId || route.query.industry_id,
  (value) => {
    if (value) industryId.value = value;
  }
);
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
  background: #f52c11;
  border-radius: 3px;
}
.scrollbar-red::-webkit-scrollbar-thumb:hover {
  background: #d9250e;
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
