<template>
  <div
    class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#e5e5e5] font-['Overpass'] text-[13px] text-[#1F2835]"
  >
    <!-- Page Header -->
    <div
      class="flex items-center justify-between px-4 py-2.5 border-b border-gray-100 bg-white shrink-0"
    >
      <div class="flex items-center gap-2">
        <button
          type="button"
          @click="cancel"
          class="text-gray-400 hover:text-[#F52C11] transition-colors mr-1"
          title="Back to list"
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
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
          </svg>
        </button>
        <div
          class="w-5 h-5 rounded-[4px] bg-[#F52C11]/10 flex items-center justify-center shrink-0"
        >
          <svg
            class="w-3 h-3 text-[#F52C11]"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 4v16m8-8H4"
            />
          </svg>
        </div>
        <div>
          <h3 class="text-[13px] font-bold text-[#1F2835] leading-tight">
            Add new record
          </h3>
          <p class="text-[9.5px] text-gray-400 leading-tight">
            Performance Improvement Plan – Leads Tracker
          </p>
        </div>
      </div>
      <button
        @click="cancel"
        class="text-[#F52C11] hover:text-[#d9250e] transition-colors"
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
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>
    </div>

    <!-- Main Content -->
    <main
      class="flex-1 p-3 flex items-start justify-start overflow-auto bg-[#e5e5e5]"
    >
      <div class="w-full space-y-2">
        <!-- Business Information Card -->
        <div
          class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
        >
          <!-- Card Header -->
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
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                />
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
          <div class="px-3 pt-2 pb-2 border-t border-gray-100">
            <div class="grid grid-cols-2 gap-x-6 gap-y-2">
              <!-- Date Recorded -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Date Recorded
                  <span class="text-[#F52C11]">*</span>
                </label>
                <div class="relative">
                  <input
                    v-model="form.dateRecorded"
                    type="text"
                    placeholder="mm/dd/yyyy"
                    readonly
                    :class="[
                      'w-full border rounded-[4px] px-2.5 py-[4px] pr-8 text-[11px] placeholder:text-gray-400 focus:outline-none transition-colors cursor-pointer bg-white',
                      errors.dateRecorded
                        ? 'border-[#F52C11]'
                        : 'border-gray-200 focus:border-[#F52C11]',
                    ]"
                    @click="showDatePickerFor = 'dateRecorded'"
                  />
                  <button
                    @click="showDatePickerFor = 'dateRecorded'"
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
                  v-if="errors.dateRecorded"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Date recorded is required
                </p>
              </div>

              <!-- Onboarding Date -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Onboarding Date
                </label>
                <div class="relative">
                  <input
                    v-model="form.onboardingDate"
                    type="text"
                    placeholder="mm/dd/yyyy"
                    readonly
                    class="w-full border border-gray-200 rounded-[4px] px-2.5 py-[4px] pr-8 text-[11px] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors cursor-pointer bg-white"
                    @click="showDatePickerFor = 'onboardingDate'"
                  />
                  <button
                    @click="showDatePickerFor = 'onboardingDate'"
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
              </div>

              <!-- Client Name -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Client Name <span class="text-[#F52C11]">*</span>
                </label>
                <input
                  v-model="form.clientName"
                  type="text"
                  placeholder="Enter a name"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.clientName
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                  @keyup.enter="saveRecord"
                />
                <p
                  v-if="errors.clientName"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Client name is required
                </p>
              </div>

              <!-- Location -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Location
                </label>
                <input
                  v-model="form.location"
                  type="text"
                  placeholder="Enter a location"
                  class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                  @keyup.enter="saveRecord"
                />
              </div>

              <!-- Prospect Technique -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Prospect Technique <span class="text-[#F52C11]">*</span>
                </label>
                <button
                  ref="techniqueButtonRef"
                  type="button"
                  @click="toggleDropdown('technique')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[4px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.prospectTechnique
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                    form.prospectTechnique ? 'text-[#1F2835]' : 'text-gray-400',
                  ]"
                >
                  <span class="truncate">{{
                    techniqueLabel || "Select a prospect technique"
                  }}</span>
                  <svg
                    :class="[
                      'w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1',
                      showTechniqueDropdown ? 'rotate-180' : '',
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
                <p
                  v-if="errors.prospectTechnique"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Prospect technique is required
                </p>

                <!-- Prospect technique dropdown panel — teleported to <body> so the
                     modal's scrolling/overflow-hidden containers can't clip it. -->
                <Teleport to="body">
                  <div
                    v-if="showTechniqueDropdown"
                    ref="techniquePanelRef"
                    :style="techniqueDropdownStyle"
                    class="fixed z-[100] bg-white border border-gray-200 rounded-[4px] shadow-lg py-1 max-h-48 overflow-y-auto overflow-x-hidden"
                  >
                    <div
                      v-if="prospectTechniqueOptions.length === 0"
                      class="px-2.5 py-2 text-[10.5px] text-gray-400"
                    >
                      No options yet
                    </div>
                    <div
                      v-for="technique in prospectTechniqueOptions"
                      :key="technique.id"
                      @click="selectTechnique(technique.id)"
                      class="group flex items-center justify-between gap-2 px-2.5 py-1.5 hover:bg-gray-50 cursor-pointer transition-colors"
                    >
                      <span
                        :class="[
                          'text-[11px] truncate',
                          form.prospectTechnique === technique.id
                            ? 'text-[#F52C11] font-semibold'
                            : 'text-[#1F2835]',
                        ]"
                        >{{ technique.name }}</span
                      >
                      <button
                        type="button"
                        @click.stop="deleteLookupItem('technique', technique)"
                        :disabled="deletingLookupId === technique.id"
                        class="shrink-0 text-gray-300 hover:text-[#F52C11] opacity-0 group-hover:opacity-100 disabled:opacity-50 transition-opacity"
                        title="Delete"
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
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                      </button>
                    </div>

                    <!-- Inline "+ Add new" row, lives inside the dropdown itself -->
                    <div
                      class="border-t border-gray-100 mt-1 pt-1 px-2 pb-1"
                      @click.stop
                    >
                      <div
                        v-if="quickAdd.field === 'technique'"
                        class="flex items-center gap-1"
                      >
                        <input
                          v-model="quickAdd.value"
                          type="text"
                          placeholder="New technique name"
                          autofocus
                          class="flex-1 bg-white border border-gray-200 rounded-[4px] px-2 py-[3px] text-[10.5px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                          @keyup.enter="submitQuickAdd"
                          @keyup.esc="closeQuickAdd"
                        />
                        <button
                          type="button"
                          @click="submitQuickAdd"
                          :disabled="quickAdd.saving"
                          class="shrink-0 bg-[#F52C11] hover:bg-[#d9250e] disabled:opacity-50 text-white px-2 py-[3px] rounded-[4px] text-[9.5px] font-medium transition-colors"
                        >
                          {{ quickAdd.saving ? "..." : "Add" }}
                        </button>
                        <button
                          type="button"
                          @click="closeQuickAdd"
                          class="shrink-0 text-gray-400 hover:text-[#1F2835] px-1 text-[9.5px]"
                        >
                          Cancel
                        </button>
                      </div>
                      <button
                        v-else
                        type="button"
                        @click="openQuickAdd('technique')"
                        class="w-full flex items-center gap-1.5 px-1 py-1 text-[10.5px] font-medium text-[#F52C11] hover:text-[#d9250e] transition-colors"
                      >
                        <svg
                          class="w-3 h-3"
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
                        Add new technique
                      </button>
                      <p
                        v-if="quickAdd.field === 'technique' && quickAdd.error"
                        class="text-[8px] text-[#F52C11] mt-0.5 px-1"
                      >
                        {{ quickAdd.error }}
                      </p>
                    </div>
                  </div>
                </Teleport>
              </div>

              <!-- Sales Representative (Multi-select) -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Sales Representative
                </label>
                <button
                  ref="salesRepButtonRef"
                  type="button"
                  @click="toggleDropdown('salesRep')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[4px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.salesRepresentative
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                    form.salesRepresentative.length > 0
                      ? 'text-[#1F2835]'
                      : 'text-gray-400',
                  ]"
                >
                  <span
                    v-if="form.salesRepresentative.length === 0"
                    class="text-gray-400"
                    >Select sales representatives</span
                  >
                  <span
                    v-else
                    class="flex items-center gap-1 overflow-x-auto whitespace-nowrap scrollbar-hide pr-1"
                    style="scrollbar-width: none; -ms-overflow-style: none"
                  >
                    <span
                      v-for="repId in form.salesRepresentative"
                      :key="repId"
                      class="inline-flex items-center gap-0.5 bg-[#F52C11]/10 text-[#F52C11] px-1.5 py-0.5 rounded text-[9px] font-medium shrink-0"
                    >
                      {{ salesRepName(repId) }}
                      <button
                        type="button"
                        @click.stop="removeSalesRep(repId)"
                        class="hover:text-[#d9250e]"
                      >
                        <svg
                          class="w-2.5 h-2.5"
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
                    </span>
                  </span>
                  <svg
                    :class="[
                      'w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1',
                      showSalesRepDropdown ? 'rotate-180' : '',
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
                <p
                  v-if="errors.salesRepresentative"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Sales representative is required
                </p>
              </div>

              <!-- Sales Representative dropdown panel — teleported to <body> so the
                   modal's scrolling/overflow-hidden containers can't clip it. -->
              <Teleport to="body">
                <div
                  v-if="showSalesRepDropdown"
                  ref="salesRepPanelRef"
                  :style="salesRepDropdownStyle"
                  class="fixed z-[100] bg-white border border-gray-200 rounded-[4px] shadow-lg py-1 max-h-52 overflow-y-auto overflow-x-hidden"
                >
                  <div
                    v-if="salesRepOptions.length === 0"
                    class="px-2.5 py-2 text-[10.5px] text-gray-400"
                  >
                    No options yet
                  </div>
                  <div
                    v-for="rep in salesRepOptions"
                    :key="rep.id"
                    @click="toggleSalesRep(rep.id)"
                    class="group flex items-center justify-between gap-2 px-2.5 py-1.5 hover:bg-gray-50 cursor-pointer transition-colors"
                  >
                    <span class="flex items-center gap-2 min-w-0">
                      <div
                        :class="[
                          'w-3.5 h-3.5 rounded border flex items-center justify-center transition-colors shrink-0',
                          form.salesRepresentative.includes(rep.id)
                            ? 'bg-[#F52C11] border-[#F52C11]'
                            : 'border-gray-300',
                        ]"
                      >
                        <svg
                          v-if="form.salesRepresentative.includes(rep.id)"
                          class="w-2.5 h-2.5 text-white"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="3"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                          />
                        </svg>
                      </div>
                      <span class="text-[11px] text-[#1F2835] truncate">{{
                        rep.name
                      }}</span>
                    </span>
                    <button
                      type="button"
                      @click.stop="deleteLookupItem('salesRep', rep)"
                      :disabled="deletingLookupId === rep.id"
                      class="shrink-0 text-gray-300 hover:text-[#F52C11] opacity-0 group-hover:opacity-100 disabled:opacity-50 transition-opacity"
                      title="Delete"
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
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </button>
                  </div>

                  <!-- Inline "+ Add new" row, lives inside the dropdown itself -->
                  <div
                    class="border-t border-gray-100 mt-1 pt-1 px-2 pb-1"
                    @click.stop
                  >
                    <div
                      v-if="quickAdd.field === 'salesRep'"
                      class="flex items-center gap-1"
                    >
                      <input
                        v-model="quickAdd.value"
                        type="text"
                        placeholder="New representative name"
                        autofocus
                        class="flex-1 bg-white border border-gray-200 rounded-[4px] px-2 py-[3px] text-[10.5px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                        @keyup.enter="submitQuickAdd"
                        @keyup.esc="closeQuickAdd"
                      />
                      <button
                        type="button"
                        @click="submitQuickAdd"
                        :disabled="quickAdd.saving"
                        class="shrink-0 bg-[#F52C11] hover:bg-[#d9250e] disabled:opacity-50 text-white px-2 py-[3px] rounded-[4px] text-[9.5px] font-medium transition-colors"
                      >
                        {{ quickAdd.saving ? "..." : "Add" }}
                      </button>
                      <button
                        type="button"
                        @click="closeQuickAdd"
                        class="shrink-0 text-gray-400 hover:text-[#1F2835] px-1 text-[9.5px]"
                      >
                        Cancel
                      </button>
                    </div>
                    <button
                      v-else
                      type="button"
                      @click="openQuickAdd('salesRep')"
                      class="w-full flex items-center gap-1.5 px-1 py-1 text-[10.5px] font-medium text-[#F52C11] hover:text-[#d9250e] transition-colors"
                    >
                      <svg
                        class="w-3 h-3"
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
                      Add new representative
                    </button>
                    <p
                      v-if="quickAdd.field === 'salesRep' && quickAdd.error"
                      class="text-[8px] text-[#F52C11] mt-0.5 px-1"
                    >
                      {{ quickAdd.error }}
                    </p>
                  </div>
                </div>
              </Teleport>

              <!-- Email -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Email <span class="text-[#F52C11]">*</span>
                </label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="example@company.com"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.email
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
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
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Ways of Communication <span class="text-[#F52C11]">*</span>
                </label>
                <button
                  ref="communicationButtonRef"
                  type="button"
                  @click="toggleDropdown('communication')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[4px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.waysOfCommunication
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                    form.waysOfCommunication
                      ? 'text-[#1F2835]'
                      : 'text-gray-400',
                  ]"
                >
                  <span class="truncate">{{
                    communicationLabel || "Select a way of communication"
                  }}</span>
                  <svg
                    :class="[
                      'w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1',
                      showCommunicationDropdown ? 'rotate-180' : '',
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
                <p
                  v-if="errors.waysOfCommunication"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Way of communication is required
                </p>

                <!-- Ways of communication dropdown panel — teleported to <body> so the
                     modal's scrolling/overflow-hidden containers can't clip it. -->
                <Teleport to="body">
                  <div
                    v-if="showCommunicationDropdown"
                    ref="communicationPanelRef"
                    :style="communicationDropdownStyle"
                    class="fixed z-[100] bg-white border border-gray-200 rounded-[4px] shadow-lg py-1 max-h-48 overflow-y-auto overflow-x-hidden"
                  >
                    <div
                      v-if="communicationOptions.length === 0"
                      class="px-2.5 py-2 text-[10.5px] text-gray-400"
                    >
                      No options yet
                    </div>
                    <div
                      v-for="way in communicationOptions"
                      :key="way.id"
                      @click="selectCommunication(way.id)"
                      class="group flex items-center justify-between gap-2 px-2.5 py-1.5 hover:bg-gray-50 cursor-pointer transition-colors"
                    >
                      <span
                        :class="[
                          'text-[11px] truncate',
                          form.waysOfCommunication === way.id
                            ? 'text-[#F52C11] font-semibold'
                            : 'text-[#1F2835]',
                        ]"
                        >{{ way.name }}</span
                      >
                      <button
                        type="button"
                        @click.stop="deleteLookupItem('communication', way)"
                        :disabled="deletingLookupId === way.id"
                        class="shrink-0 text-gray-300 hover:text-[#F52C11] opacity-0 group-hover:opacity-100 disabled:opacity-50 transition-opacity"
                        title="Delete"
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
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                      </button>
                    </div>

                    <!-- Inline "+ Add new" row, lives inside the dropdown itself -->
                    <div
                      class="border-t border-gray-100 mt-1 pt-1 px-2 pb-1"
                      @click.stop
                    >
                      <div
                        v-if="quickAdd.field === 'communication'"
                        class="flex items-center gap-1"
                      >
                        <input
                          v-model="quickAdd.value"
                          type="text"
                          placeholder="New way of communication"
                          autofocus
                          class="flex-1 bg-white border border-gray-200 rounded-[4px] px-2 py-[3px] text-[10.5px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                          @keyup.enter="submitQuickAdd"
                          @keyup.esc="closeQuickAdd"
                        />
                        <button
                          type="button"
                          @click="submitQuickAdd"
                          :disabled="quickAdd.saving"
                          class="shrink-0 bg-[#F52C11] hover:bg-[#d9250e] disabled:opacity-50 text-white px-2 py-[3px] rounded-[4px] text-[9.5px] font-medium transition-colors"
                        >
                          {{ quickAdd.saving ? "..." : "Add" }}
                        </button>
                        <button
                          type="button"
                          @click="closeQuickAdd"
                          class="shrink-0 text-gray-400 hover:text-[#1F2835] px-1 text-[9.5px]"
                        >
                          Cancel
                        </button>
                      </div>
                      <button
                        v-else
                        type="button"
                        @click="openQuickAdd('communication')"
                        class="w-full flex items-center gap-1.5 px-1 py-1 text-[10.5px] font-medium text-[#F52C11] hover:text-[#d9250e] transition-colors"
                      >
                        <svg
                          class="w-3 h-3"
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
                        Add new way of communication
                      </button>
                      <p
                        v-if="
                          quickAdd.field === 'communication' && quickAdd.error
                        "
                        class="text-[8px] text-[#F52C11] mt-0.5 px-1"
                      >
                        {{ quickAdd.error }}
                      </p>
                    </div>
                  </div>
                </Teleport>
              </div>

              <!-- Service -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Service <span class="text-[#F52C11]">*</span>
                </label>
                <button
                  ref="serviceButtonRef"
                  type="button"
                  @click="toggleDropdown('service')"
                  :class="[
                    'w-full bg-white border rounded-[4px] px-2.5 py-[4px] text-[11px] focus:outline-none transition-colors text-left flex items-center justify-between',
                    errors.service
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                    form.service ? 'text-[#1F2835]' : 'text-gray-400',
                  ]"
                >
                  <span class="truncate">{{
                    serviceLabel || "Select a service"
                  }}</span>
                  <svg
                    :class="[
                      'w-2.5 h-2.5 text-[#F52C11] transition-transform shrink-0 ml-1',
                      showServiceDropdown ? 'rotate-180' : '',
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
                <p
                  v-if="errors.service"
                  class="text-[8px] text-[#F52C11] mt-0.5"
                >
                  Service is required
                </p>

                <!-- Service dropdown panel — teleported to <body> so the
                     modal's scrolling/overflow-hidden containers can't clip it. -->
                <Teleport to="body">
                  <div
                    v-if="showServiceDropdown"
                    ref="servicePanelRef"
                    :style="serviceDropdownStyle"
                    class="fixed z-[100] bg-white border border-gray-200 rounded-[4px] shadow-lg py-1 max-h-48 overflow-y-auto overflow-x-hidden"
                  >
                    <div
                      v-if="serviceOptions.length === 0"
                      class="px-2.5 py-2 text-[10.5px] text-gray-400"
                    >
                      No options yet
                    </div>
                    <div
                      v-for="service in serviceOptions"
                      :key="service.id"
                      @click="selectService(service.id)"
                      class="group flex items-center justify-between gap-2 px-2.5 py-1.5 hover:bg-gray-50 cursor-pointer transition-colors"
                    >
                      <span
                        :class="[
                          'text-[11px] truncate',
                          form.service === service.id
                            ? 'text-[#F52C11] font-semibold'
                            : 'text-[#1F2835]',
                        ]"
                        >{{ service.name }}</span
                      >
                      <button
                        type="button"
                        @click.stop="deleteLookupItem('service', service)"
                        :disabled="deletingLookupId === service.id"
                        class="shrink-0 text-gray-300 hover:text-[#F52C11] opacity-0 group-hover:opacity-100 disabled:opacity-50 transition-opacity"
                        title="Delete"
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
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                      </button>
                    </div>

                    <!-- Inline "+ Add new" row, lives inside the dropdown itself -->
                    <div
                      class="border-t border-gray-100 mt-1 pt-1 px-2 pb-1"
                      @click.stop
                    >
                      <div
                        v-if="quickAdd.field === 'service'"
                        class="flex items-center gap-1"
                      >
                        <input
                          v-model="quickAdd.value"
                          type="text"
                          placeholder="New service name"
                          autofocus
                          class="flex-1 bg-white border border-gray-200 rounded-[4px] px-2 py-[3px] text-[10.5px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                          @keyup.enter="submitQuickAdd"
                          @keyup.esc="closeQuickAdd"
                        />
                        <button
                          type="button"
                          @click="submitQuickAdd"
                          :disabled="quickAdd.saving"
                          class="shrink-0 bg-[#F52C11] hover:bg-[#d9250e] disabled:opacity-50 text-white px-2 py-[3px] rounded-[4px] text-[9.5px] font-medium transition-colors"
                        >
                          {{ quickAdd.saving ? "..." : "Add" }}
                        </button>
                        <button
                          type="button"
                          @click="closeQuickAdd"
                          class="shrink-0 text-gray-400 hover:text-[#1F2835] px-1 text-[9.5px]"
                        >
                          Cancel
                        </button>
                      </div>
                      <button
                        v-else
                        type="button"
                        @click="openQuickAdd('service')"
                        class="w-full flex items-center gap-1.5 px-1 py-1 text-[10.5px] font-medium text-[#F52C11] hover:text-[#d9250e] transition-colors"
                      >
                        <svg
                          class="w-3 h-3"
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
                        Add new service
                      </button>
                      <p
                        v-if="quickAdd.field === 'service' && quickAdd.error"
                        class="text-[8px] text-[#F52C11] mt-0.5 px-1"
                      >
                        {{ quickAdd.error }}
                      </p>
                    </div>
                  </div>
                </Teleport>
              </div>

              <!-- Remarks -->
              <div>
                <label
                  class="block text-[10px] font-semibold text-[#1F2835] mb-0.5"
                >
                  Remarks
                </label>
                <input
                  v-model="form.remarks"
                  type="text"
                  placeholder="Enter any additional notes"
                  class="w-full bg-white border border-gray-200 rounded-[4px] px-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
                  @keyup.enter="saveRecord"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Bottom Cards Row -->
        <div class="grid grid-cols-2 gap-2">
          <!-- Contact Person Card -->
          <div
            class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
          >
            <!-- Card Header -->
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
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
              </div>
              <div>
                <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">
                  Contact Person
                </h2>
                <p class="text-[9px] text-gray-400 leading-tight">
                  Identify the primary point of contact
                </p>
              </div>
            </div>

            <!-- Contact Person Inputs -->
            <div class="px-3 pb-2.5 pt-1 space-y-1.5">
              <div class="relative">
                <svg
                  class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
                <input
                  v-model="form.contactPersonName"
                  type="text"
                  placeholder="Type contact name"
                  :class="[
                    'w-full bg-white border rounded-[4px] pl-8 pr-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.contactPersonName
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                  @keyup.enter="saveRecord"
                />
              </div>
              <p
                v-if="errors.contactPersonName"
                class="text-[8px] text-[#F52C11] -mt-1"
              >
                Contact person is required
              </p>
              <div class="relative">
                <svg
                  class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                  />
                </svg>
                <input
                  v-model="form.contactPersonPhone"
                  type="tel"
                  placeholder="09XX-XXX-XXXX"
                  :class="[
                    'w-full bg-white border rounded-[4px] pl-8 pr-2.5 py-[4px] text-[11px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none transition-colors',
                    errors.contactPersonPhone
                      ? 'border-[#F52C11]'
                      : 'border-gray-200 focus:border-[#F52C11]',
                  ]"
                  @input="formatContactPersonPhone"
                  @keydown="handleContactKeydown"
                  @keyup.enter="saveRecord"
                />
              </div>
              <p
                v-if="errors.contactPersonPhone"
                class="text-[8px] text-[#F52C11] -mt-1"
              >
                Contact number is required
              </p>
            </div>
          </div>

          <!-- Status and Progress Card -->
          <div
            class="bg-white rounded-[6px] border border-gray-200 shadow-sm overflow-hidden"
          >
            <!-- Card Header -->
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
                <h2 class="text-[11px] font-bold text-[#1F2835] leading-tight">
                  Status and progress
                </h2>
                <p class="text-[9px] text-gray-400 leading-tight">
                  Set the current lead stage
                </p>
              </div>
            </div>

            <!-- Progress -->
            <div class="px-3 pb-2.5 pt-1">
              <div class="flex items-center justify-between mb-1">
                <div>
                  <label class="block text-[10px] font-semibold text-[#1F2835]"
                    >Status</label
                  >
                  <p class="text-[8px] text-gray-400">
                    Progress bar updates automatically
                  </p>
                </div>

                <!-- Number + stepper -->
                <div class="flex items-center gap-1">
                  <div
                    class="flex items-center border border-gray-200 rounded-[4px] overflow-hidden"
                  >
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
              <!-- Progress Bar -->
              <div class="w-full h-2 bg-gray-200 rounded-full relative">
                <div
                  class="absolute top-1/2 left-0 -translate-y-1/2 h-1 rounded-full transition-all duration-300"
                  :style="{
                    width: form.status + '%',
                    backgroundColor: progressColor,
                  }"
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

        <!-- Clear all fields button -->
        <div class="flex justify-end pt-1">
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
        </div>
      </div>
    </main>

    <!-- Footer: Action Buttons -->
    <div
      class="shrink-0 border-t border-gray-200 bg-white px-4 py-2.5 flex items-center justify-end gap-2"
    >
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
// This used to be a modal driven entirely by props/emits from index.vue.
// Now that it's a full route/page, it fetches its own lookups, resolves its
// own current user, and talks to the API directly instead of bubbling
// 'save'/'lookup-added'/'lookup-deleted' events up to a parent.
// ============================================
const route = useRoute();

// Same auth/base-URL wiring as index.vue's <script setup> — this page can be
// navigated to directly (deep link / refresh), so it can't assume index.vue
// has already run configureApi() in this session.
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

// Lookup options — previously passed in as props, now fetched directly.
const prospectTechniqueOptions = ref([]);
const salesRepOptions = ref([]);
const communicationOptions = ref([]);
const serviceOptions = ref([]);
const isLoadingLookups = ref(false);

async function loadLookups() {
  isLoadingLookups.value = true;
  try {
    const lookups = await api.fetchLookups();
    prospectTechniqueOptions.value = lookups.techniques;
    salesRepOptions.value = lookups.salesReps;
    communicationOptions.value = lookups.communications;
    serviceOptions.value = lookups.services;
  } catch (error) {
    console.error("Failed to fetch lookups:", error);
  } finally {
    isLoadingLookups.value = false;
  }
}

// Navigates back to the list page. Built from the current route rather than
// a hard-coded path, on the assumption this page lives one level below the
// list (e.g. pages/performance-plan/index.vue + pages/performance-plan/create.vue
// -> "/performance-plan" and "/performance-plan/create"). If your list page
// lives somewhere else, just change this to navigateTo('/your/list/route').
function goToList() {
  const parent = route.path.replace(/\/[^/]+\/?$/, "") || "/";
  navigateTo(parent || "/");
}

// error message from a failed save attempt (used to be a prop from the parent)
const saveError = ref("");

// ============================================
// FORM DATA - Ready for backend connection
// prospectTechnique / service / waysOfCommunication hold the selected
// lookup's id; salesRepresentative holds an array of selected ids.
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
// QUICK-ADD (inline "+ add new" row, lives inside each dropdown panel)
// field: 'technique' | 'salesRep' | 'communication' | 'service' | null
// ============================================
const quickAdd = ref({ field: null, value: "", saving: false, error: "" });

// Maps a quick-add field key to: the api.js create function, which form
// field to auto-select after creation (null = handled specially, see
// submitQuickAdd), and the "type" string sent up via 'lookup-added' so
// index.vue knows which lookups.* array to push into.
const quickAddConfig = {
  technique: {
    create: api.createProspectTechnique,
    formField: "prospectTechnique",
    type: "techniques",
  },
  salesRep: {
    create: api.createSalesRepresentative,
    formField: null,
    type: "salesReps",
  },
  communication: {
    create: api.createWayOfCommunication,
    formField: "waysOfCommunication",
    type: "communications",
  },
  service: {
    create: api.createService,
    formField: "service",
    type: "services",
  },
};

function openQuickAdd(field) {
  quickAdd.value = { field, value: "", saving: false, error: "" };
}

function closeQuickAdd() {
  quickAdd.value = { field: null, value: "", saving: false, error: "" };
}

async function submitQuickAdd() {
  const cfg = quickAddConfig[quickAdd.value.field];
  const name = quickAdd.value.value.trim();
  if (!cfg || !name || quickAdd.value.saving) return;

  quickAdd.value.saving = true;
  quickAdd.value.error = "";
  try {
    const created = await cfg.create(name);
    const newItem = {
      id: created?.id ?? created?.data?.id,
      name: created?.name ?? created?.data?.name ?? name,
    };

    // Push straight into this page's own lookup list (no parent to bubble
    // this up to anymore — it used to be a 'lookup-added' emit).
    const targetList = {
      techniques: prospectTechniqueOptions,
      salesReps: salesRepOptions,
      communications: communicationOptions,
      services: serviceOptions,
    }[cfg.type];
    if (targetList && !targetList.value.some((o) => o.id === newItem.id)) {
      targetList.value.push(newItem);
    }

    // Auto-select the newly created value in this form.
    if (cfg.formField) {
      form.value[cfg.formField] = newItem.id;
    } else if (quickAdd.value.field === "salesRep") {
      form.value.salesRepresentative.push(newItem.id);
    }

    closeQuickAdd();
  } catch (error) {
    console.error("Failed to add lookup value:", error);
    const fieldErrors = error?.data?.errors;
    quickAdd.value.error = fieldErrors
      ? Object.values(fieldErrors).flat().join(" ")
      : error?.message || "Failed to add. Please try again.";
    quickAdd.value.saving = false;
  }
}

// ============================================
// LOOKUP DELETE ("just in case" — a trash icon next to each option, right
// inside the dropdown, so a wrong/duplicate lookup value can be removed
// without leaving the modal).
// ============================================
const deletingLookupId = ref(null);

const lookupDeleteConfig = {
  technique: {
    del: api.deleteProspectTechnique,
    type: "techniques",
    formField: "prospectTechnique",
  },
  salesRep: {
    del: api.deleteSalesRepresentative,
    type: "salesReps",
    formField: null,
  },
  communication: {
    del: api.deleteWayOfCommunication,
    type: "communications",
    formField: "waysOfCommunication",
  },
  service: { del: api.deleteService, type: "services", formField: "service" },
};

async function deleteLookupItem(field, item) {
  const cfg = lookupDeleteConfig[field];
  if (!cfg || deletingLookupId.value) return;

  const ok = window.confirm(
    `Delete "${item.name}"? This can't be undone, and any records currently using it may be affected.`
  );
  if (!ok) return;

  deletingLookupId.value = item.id;
  try {
    await cfg.del(item.id);

    // Remove from this page's own lookup list (used to be a 'lookup-deleted'
    // emit up to the parent; edit.vue will simply refetch lookups next time
    // it's opened, since these two pages no longer share state directly).
    const targetList = {
      techniques: prospectTechniqueOptions,
      salesReps: salesRepOptions,
      communications: communicationOptions,
      services: serviceOptions,
    }[cfg.type];
    if (targetList) {
      const idx = targetList.value.findIndex((o) => o.id === item.id);
      if (idx > -1) targetList.value.splice(idx, 1);
    }

    // If this form currently had the deleted item selected, clear it.
    if (cfg.formField) {
      if (form.value[cfg.formField] === item.id) form.value[cfg.formField] = "";
    } else if (field === "salesRep") {
      const idx = form.value.salesRepresentative.indexOf(item.id);
      if (idx > -1) form.value.salesRepresentative.splice(idx, 1);
    }
  } catch (error) {
    console.error("Failed to delete lookup value:", error);
    window.alert(
      error?.data?.message ||
        error?.message ||
        "Failed to delete. It may still be in use by existing records."
    );
  } finally {
    deletingLookupId.value = null;
  }
}

// ============================================
// DROPDOWNS (Prospect Technique, Sales Representative, Ways of
// Communication, Service)
// All four are custom button+panel dropdowns instead of native <select>s,
// so the "+ Add new" row and per-option delete buttons can live inside the
// dropdown itself. Panels are teleported to <body> so the modal's
// scrolling/overflow-hidden containers can't clip them, which means we
// position them manually and handle outside-clicks/scroll ourselves
// instead of relying on normal in-flow absolute positioning.
// ============================================
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

// Registry the generic helpers below iterate over — just groups the refs
// declared above, doesn't redeclare them.
const dropdownRegistry = {
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
  // Only one dropdown open at a time.
  Object.values(dropdownRegistry).forEach((entry) => {
    entry.show.value = false;
  });
  d.show.value = opening;
  if (opening) {
    closeQuickAdd();
    // Position after the panel exists in the DOM (it's teleported + v-if).
    nextTick(() => positionDropdown(key));
  }
}

function selectTechnique(id) {
  form.value.prospectTechnique = id;
  closeQuickAdd();
  showTechniqueDropdown.value = false;
}

function selectService(id) {
  form.value.service = id;
  closeQuickAdd();
  showServiceDropdown.value = false;
}

function selectCommunication(id) {
  form.value.waysOfCommunication = id;
  closeQuickAdd();
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

// Close whichever dropdown is open on an outside click. Since panels are
// teleported to <body>, they're no longer inside their button's wrapper, so
// we check both the button and the panel explicitly for each dropdown.
function handleDropdownsOutsideClick(e) {
  Object.values(dropdownRegistry).forEach((d) => {
    if (!d.show.value) return;
    const clickedButton = d.button.value?.contains(e.target);
    const clickedPanel = d.panel.value?.contains(e.target);
    if (!clickedButton && !clickedPanel) {
      d.show.value = false;
    }
  });
}

// Reposition any open dropdown if the modal scrolls or the window resizes,
// so the panel never drifts away from its button.
function handleDropdownsReposition() {
  Object.entries(dropdownRegistry).forEach(([key, d]) => {
    if (d.show.value) positionDropdown(key);
  });
}

onMounted(() => {
  loadCurrentUser();
  loadLookups();
  document.addEventListener("click", handleDropdownsOutsideClick);
  window.addEventListener("resize", handleDropdownsReposition);
  window.addEventListener("scroll", handleDropdownsReposition, true); // capture: catches scroll on the page's inner scrollable area too
});

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
  if (!value || !value.trim()) return false; // required field now
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

  // Previous month padding
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

  // Current month
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

  // Next month padding
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
  return (
    form.value.clientName.trim() &&
    form.value.dateRecorded &&
    form.value.prospectTechnique &&
    form.value.salesRepresentative.length > 0 &&
    form.value.email &&
    isValidEmail(form.value.email) &&
    form.value.waysOfCommunication &&
    form.value.service &&
    form.value.contactPersonName.trim() &&
    form.value.contactPersonPhone.trim()
  );
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
  errors.value.dateRecorded = !form.value.dateRecorded;
  errors.value.clientName = !form.value.clientName.trim();
  errors.value.prospectTechnique = !form.value.prospectTechnique;
  errors.value.salesRepresentative =
    form.value.salesRepresentative.length === 0;
  errors.value.email = !isValidEmail(form.value.email);
  errors.value.waysOfCommunication = !form.value.waysOfCommunication;
  errors.value.service = !form.value.service;
  errors.value.contactPersonName = !form.value.contactPersonName.trim();
  errors.value.contactPersonPhone = !form.value.contactPersonPhone.trim();

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
// ACTIONS - Ready for backend API calls
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
  closeQuickAdd();
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

    // Field values here are already lookup ids (technique/service/comm/reps)
    // and a lead-status string. toBackendPayload() converts this into the
    // exact shape PerformancePlanController::store() expects.
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

    // Success — go back to the list. Its own onMounted fetch will pick up
    // the new record since this is a fresh page load, not a shared-state
    // in-memory push like the old modal version had.
    clearAllFields();
    goToList();
  } catch (error) {
    console.error("Failed to save record:", error);
    saveError.value = describeApiError(error);
  } finally {
    isSaving.value = false;
  }
}

// Same error-message shaping as index.vue's describeApiError() — mirrored
// here since this page no longer shares a parent scope with index.vue.
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
