<template>
  <div
    class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#f0f0f0] font-['Overpass'] text-[14px] text-[#1F2835]"
  >
    <div
      class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200"
    >
      <div class="flex items-center text-[11px] text-gray-500 gap-1">
        <svg
          class="w-3.5 h-3.5 text-gray-400"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 17V9" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 17V5" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 17v-3" />
        </svg>
        <span class="hover:text-[#1F2835] cursor-pointer transition-colors"
          >Leads Tracker</span
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
            d="M9 5l7 7-7 7"
          />
        </svg>
        <span class="hover:text-[#1F2835] cursor-pointer transition-colors"
          >Leads</span
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
            d="M9 5l7 7-7 7"
          />
        </svg>
        <span class="text-[#F52C11] font-semibold">Industry</span>
      </div>
    </div>

    <div class="px-4 py-0.5 flex items-center justify-between shrink-0">
      <h1 class="font-bold text-[16px] tracking-tight">
        Industry – Leads listing
      </h1>
      <button
        @click="openArchiveModal"
        class="relative bg-white border border-gray-300 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-3 py-[4px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
      >
        <svg
          class="w-3 h-3"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
          />
        </svg>
        View archive
        <span
          v-if="totalArchivedCount > 0"
          class="absolute -top-1.5 -right-1.5 min-w-[16px] h-[16px] px-1 flex items-center justify-center rounded-full bg-[#F52C11] text-white text-[9px] font-bold leading-none"
        >
          {{ totalArchivedCount > 99 ? "99+" : totalArchivedCount }}
        </span>
      </button>
    </div>

    <div
      class="px-4 py-0.5 flex items-center justify-between gap-2 shrink-0 bg-[#f0f0f0]"
    >
      <div class="flex items-center gap-1.5">
        <button
          v-for="loc in locationOptions"
          :key="loc"
          @click="switchLocation(loc)"
          :class="
            selectedLocation === loc
              ? 'bg-[#F52C11] text-white'
              : 'bg-gray-100 text-[#1F2835] border border-gray-200'
          "
          class="pl-1.5 pr-2 py-[2px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
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
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
            />
          </svg>
          {{ loc }}
        </button>
        <div class="relative flex items-center">
          <svg
            class="w-3.5 h-3.5 text-gray-400 absolute left-2 pointer-events-none"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            />
          </svg>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search business name, contact..."
            class="pl-7 pr-2 py-[3px] w-56 bg-white border border-gray-300 rounded-[4px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
          />
        </div>
      </div>

      <div class="flex items-center gap-2">
        <div class="relative">
          <button
            @click="showDatePicker = !showDatePicker"
            class="bg-white border border-gray-300 px-2.5 py-[3px] rounded-[4px] text-[11px] flex items-center gap-1.5 text-[#1F2835] hover:border-gray-400 transition-colors"
          >
            {{ formattedSelectedDate || "Select Date" }}
            <svg
              class="w-3 h-3 text-[#F52C11]"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
          </button>
          <div
            v-if="showDatePicker"
            class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[12px] shadow-lg z-50 p-3 w-64"
          >
            <div class="flex items-center justify-between mb-2">
              <button
                @click="prevMonth"
                class="text-gray-400 hover:text-[#1F2835]"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <span class="text-[12px] font-semibold">{{
                currentMonthYear
              }}</span>
              <button
                @click="nextMonth"
                class="text-gray-400 hover:text-[#1F2835]"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
            <div
              class="grid grid-cols-7 gap-1 text-center text-[10px] text-gray-400 mb-1"
            >
              <span>Su</span><span>Mo</span><span>Tu</span><span>We</span
              ><span>Th</span><span>Fr</span><span>Sa</span>
            </div>
            <div class="grid grid-cols-7 gap-1">
              <button
                v-for="day in calendarDays"
                :key="day.date || Math.random()"
                @click="day.date && selectDate(day.date)"
                :disabled="!day.date"
                :class="[
                  'w-7 h-7 rounded-[4px] text-[11px] flex items-center justify-center transition-colors',
                  day.isCurrentMonth ? 'text-[#1F2835]' : 'text-gray-300',
                  day.isSelected
                    ? 'bg-[#F52C11] text-white font-semibold'
                    : day.isToday
                    ? 'border border-[#F52C11] text-[#F52C11] font-semibold'
                    : day.date
                    ? 'hover:bg-gray-100'
                    : '',
                ]"
              >
                {{ day.day }}
              </button>
            </div>

            <!-- Clear date -->
            <div class="flex justify-end mt-2 pt-2">
              <button
                @click="clearDateFilter"
                class="text-[10px] text-gray-400 hover:text-[#F52C11] transition-colors"
              >
                Clear date
              </button>
            </div>
          </div>
        </div>

        <div class="relative">
          <button
            @click="showServicesDropdown = !showServicesDropdown"
            :class="
              selectedService !== 'All Services'
                ? 'border-[#F52C11] text-[#F52C11]'
                : 'border-gray-300 text-[#1F2835]'
            "
            class="bg-white border px-2.5 py-[3px] rounded-[4px] text-[11px] flex items-center gap-1 hover:border-gray-400 transition-colors"
          >
            {{ selectedService }}
            <svg
              class="w-2.5 h-2.5 text-gray-500"
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
          <div
            v-if="showServicesDropdown"
            class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[160px]"
          >
            <button
              v-for="service in serviceOptions"
              :key="service"
              @click="
                selectedService = service;
                showServicesDropdown = false;
              "
              :class="
                selectedService === service
                  ? 'bg-[#F52C11]/10 text-[#F52C11] font-medium'
                  : 'text-[#1F2835] hover:bg-gray-50'
              "
              class="w-full text-left px-3 py-1.5 text-[11px] transition-colors"
            >
              {{ service }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <main class="flex-1 flex p-2 gap-1.5 min-h-0 overflow-hidden">
      <aside
        class="w-48 shrink-0 flex flex-col bg-white border border-gray-200 rounded-[6px] overflow-hidden"
      >
        <div
          class="bg-[#1F2835] text-white px-2.5 py-1 flex items-center justify-center relative"
        >
          <button
            @click="showAddIndustryModal = true"
            class="absolute left-2.5 w-5 h-5 bg-white/20 rounded-[4px] flex items-center justify-center hover:bg-white/30 transition-colors"
            title="Add industry"
          >
            <svg
              class="w-3 h-3 text-white"
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
          </button>
          <span class="font-bold text-[11px] tracking-wide uppercase"
            >Industries</span
          >
        </div>

        <div
          v-if="isLoadingIndustries"
          class="flex-1 flex items-center justify-center text-[11px] text-gray-400 py-6 px-3 text-center"
        >
          Loading industries...
        </div>
        <div
          v-else-if="sortedIndustries.length === 0"
          class="flex-1 flex items-center justify-center text-[11px] text-gray-400 py-6 px-3 text-center"
        >
          No industries yet. Click + to add one.
        </div>
        <div v-else class="flex-1 overflow-y-auto custom-scroll relative">
          <div
            v-for="(industry, index) in sortedIndustries"
            :key="industry"
            @click="selectedIndustry = industry"
            :class="[
              selectedIndustry === industry
                ? 'bg-[#F52C11]/15 text-[#F52C11] font-medium'
                : 'text-[#1F2835] hover:bg-[#F52C11]/10',
            ]"
            class="px-2.5 py-1.5 text-[12px] cursor-pointer transition-all flex items-center justify-between group"
          >
            <div
              v-if="editingIndex === index"
              class="flex-1 flex items-center gap-1"
              @click.stop
            >
              <input
                v-model="renameValue"
                type="text"
                class="flex-1 bg-white border border-gray-300 rounded-[3px] px-1.5 py-0.5 text-[11px] focus:outline-none focus:border-[#F52C11]"
                @blur="finishRename(index)"
                @keyup.enter="finishRename(index)"
                @keyup.esc="cancelRename"
              />
            </div>
            <span v-else class="truncate pr-1 flex-1">{{ industry }}</span>

            <div v-if="editingIndex !== index" class="relative">
              <button
                @click.stop="toggleIndustryMenu(index)"
                class="text-gray-400 hover:text-[#1F2835] p-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity"
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
                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                  />
                </svg>
              </button>
              <div
                v-if="openIndustryMenuIndex === index"
                class="absolute right-0 top-full mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[100px]"
              >
                <button
                  @click.stop="startInlineRename(industry, index)"
                  class="w-full text-left px-3 py-1.5 text-[11px] text-[#1F2835] hover:bg-gray-50 transition-colors flex items-center gap-1.5"
                >
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
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                    />
                  </svg>
                  Rename
                </button>
                <button
                  @click.stop="archiveIndustry(industry)"
                  class="w-full text-left px-3 py-1.5 text-[11px] text-red-500 hover:bg-red-50 transition-colors flex items-center gap-1.5"
                >
                  <svg
                    class="w-3 h-3 text-red-400"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                    />
                  </svg>
                  Archive
                </button>
              </div>
            </div>
          </div>
        </div>
      </aside>

      <section
        class="flex-1 flex flex-col min-w-0 bg-white border border-gray-100 overflow-hidden relative"
      >
        <div
          class="flex items-center justify-between px-2 py-1 border-b border-gray-100 shrink-0 bg-gray-50"
        >
          <span class="text-[11px] text-gray-500">
            <span v-if="filteredRecords.length > 0"
              >Showing {{ recordsRangeStart }}–{{ recordsRangeEnd }}</span
            >
            <span v-else>Showing 0</span>
            <span class="mx-1 text-gray-200">|</span>
            {{ filteredRecords.length }} total records
          </span>

          <div class="flex items-center gap-2">
            <span class="text-[11px] text-gray-500">Rows per page</span>
            <div class="relative">
              <select
                v-model.number="recordsRowsPerPage"
                class="bg-white border border-gray-300 rounded-[4px] text-[11px] px-1.5 py-[1px] pr-5 focus:outline-none focus:border-[#F52C11] appearance-none cursor-pointer"
              >
                <option
                  v-for="option in rowsPerPageOptions"
                  :key="option"
                  :value="option"
                >
                  {{ option }}
                </option>
              </select>
              <!-- Custom arrow -->
              <svg
                class="w-2.5 h-2.5 text-[#F52C11] absolute right-1 top-1/2 -translate-y-1/2 pointer-events-none"
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
            </div>

            <button
              @click="goToAddRecord"
              :disabled="!selectedIndustry"
              :class="[
                selectedIndustry
                  ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white'
                  : 'bg-gray-300 text-gray-500 cursor-not-allowed',
              ]"
              class="px-2.5 py-1 rounded-[4px] text-[10px] font-medium flex items-center gap-0.5 transition-colors"
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
                  d="M12 4v16m8-8H4"
                />
              </svg>
              Add record
            </button>
          </div>
        </div>

        <div class="flex-1 overflow-auto custom-scroll relative">
          <table class="w-full border-collapse text-left text-[12px]">
            <thead class="bg-[#f2f2f2] sticky top-0 z-20">
              <tr class="border-b border-gray-200">
                <th
                  class="w-8 px-2 py-1.5 text-center text-[10px] text-gray-400"
                ></th>
                <th class="w-6 px-2 py-1.5 text-center">
                  <input
                    type="checkbox"
                    :checked="isAllSelected"
                    @change="toggleAll"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] accent-[#F52C11] cursor-pointer"
                  />
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Date
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Business Name
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Contact Person
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Job Position
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Contact No.
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Email
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Service
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Status
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Remarks
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] sticky right-0 z-30 bg-gray-100 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] text-center"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="isLoadingRecords">
                <td
                  colspan="12"
                  class="px-4 py-12 text-center text-gray-400 border border-gray-200 bg-white"
                >
                  Loading records from database...
                </td>
              </tr>
              <tr
                v-else-if="paginatedRecords.length === 0"
                class="px-4 py-12 text-center text-gray-400 border border-gray-200 bg-white"
              >
                <td
                  colspan="12"
                  class="px-4 py-12 text-center text-gray-400 border border-gray-200"
                >
                  No active records discovered in this collection.
                </td>
              </tr>

              <tr
                v-else
                v-for="(record, recordIndex) in paginatedRecords"
                :key="record.id"
                :class="[
                  isSelected(record.id)
                    ? 'bg-[#F52C11]/10'
                    : 'bg-white hover:bg-[#f52c11]/5',
                ]"
                class="transition-colors border-b border-gray-100"
              >
                <td class="px-2 py-1 text-center text-[11px] text-gray-400">
                  {{ recordsRangeStart + recordIndex }}
                </td>
                <td class="px-2 py-1 text-center">
                  <input
                    type="checkbox"
                    :checked="isSelected(record.id)"
                    @change="toggleSelection(record.id)"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] accent-[#F52C11] cursor-pointer"
                  />
                </td>
                <td class="px-3 py-1 whitespace-nowrap text-[11px]">
                  {{ record.date }}
                </td>
                <td
                  class="px-3 py-1 whitespace-nowrap font-bold text-slate-800"
                >
                  {{ record.businessName }}
                </td>
                <td class="px-3 py-1 whitespace-nowrap">
                  {{ record.contactPerson }}
                </td>
                <td class="px-3 py-1 whitespace-nowrap">
                  {{ record.jobPosition }}
                </td>
                <td class="px-3 py-1 whitespace-nowrap text-slate-600">
                  {{ record.contactNo }}
                </td>
                <td class="px-3 py-1 whitespace-nowrap text-gray-600">
                  {{ record.email }}
                </td>
                <td class="px-3 py-1 whitespace-nowrap text-[11px]">
                  {{ record.service }}
                </td>
                <td class="px-3 py-1 whitespace-nowrap">
                  <div class="flex items-center gap-1.5 min-w-[120px]">
                    <div
                      class="flex-1 h-[5px] bg-gray-200 rounded-full overflow-hidden"
                    >
                      <div
                        class="h-full rounded-full transition-all duration-500"
                        :style="{
                          width: record.statusPercent + '%',
                          backgroundColor: getStatusColor(record.statusPercent),
                        }"
                      ></div>
                    </div>
                    <span
                      :style="{ color: getStatusColor(record.statusPercent) }"
                      class="text-[10px] font-bold shrink-0 w-6 text-right"
                      >{{ record.statusPercent }}%</span
                    >
                  </div>
                </td>
                <td
                  class="px-3 py-1 max-w-[200px] truncate text-gray-600"
                  :title="record.remarks"
                >
                  {{ record.remarks || "-" }}
                </td>
                <td
                  class="px-3 py-1 sticky right-0 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] text-center"
                  :class="isSelected(record.id) ? 'bg-[#FCE4E2]' : 'bg-white'"
                >
                  <div class="flex items-center justify-center gap-2">
                    <button
                      @click="viewRecord(record)"
                      class="text-gray-400 hover:text-[#1F2835]"
                      title="View details"
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
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                      </svg>
                    </button>
                    <button
                      @click="openEditModal(record)"
                      class="text-gray-400 hover:text-blue-600"
                      title="Modify record"
                    >
                      <svg
                        class="w-3.5 h-3.5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                      >
                        <path
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Archive Selected Bar - sits above pagination, matches PIP index sizing -->
        <div
          v-if="selectedIds.length > 0"
          class="shrink-0 bg-white border-t border-gray-200 px-3 py-[2px] flex items-center justify-between"
        >
          <div class="flex items-center gap-2 text-[11px] text-[#1F2835]">
            <svg
              class="w-3.5 h-3.5 text-[#F52C11]"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            <span class="font-medium"
              >{{ selectedIds.length }} record(s) selected</span
            >
          </div>
          <button
            @click="archiveSelectedRecords"
            class="bg-[#F52C11] hover:bg-[#d9250e] text-white px-2.5 py-[2px] rounded-[6px] text-[11px] font-medium flex items-center gap-1 transition-colors"
          >
            <svg
              class="w-3 h-3"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
              />
            </svg>
            Archive selected
          </button>
        </div>

        <!-- Pagination footer - matches PIP index pattern -->
        <div
          class="shrink-0 bg-[#f0f0f0] px-3 py-1.5 flex items-center justify-between gap-2 flex-wrap border-t border-gray-200 text-[11px]"
        >
          <span class="text-[11px] text-gray-500"
            >Page {{ recordsCurrentPage }} of {{ totalRecordsPages }}</span
          >

          <div class="flex items-center gap-1">
            <span class="text-[11px] text-gray-500">Go to</span>
            <input
              v-model="recordsPageInput"
              type="number"
              min="1"
              :max="totalRecordsPages"
              placeholder="---"
              class="w-10 bg-white border border-gray-300 rounded-[3px] px-1.5 py-[1px] text-[11px] text-[#1F2835] text-center focus:outline-none focus:border-[#F52C11] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
              @keyup.enter="goToTypedRecordsPage"
            />
            <button
              @click="goToTypedRecordsPage"
              class="bg-gray-200 border border-gray-300 hover:bg-gray-300 text-[#1F2835] px-1.5 py-[1px] rounded-[3px] text-[9px] font-medium transition-colors"
            >
              Go
            </button>
          </div>

          <div class="flex items-center gap-0.5">
            <button
              @click="goToRecordsPage(recordsCurrentPage - 1)"
              :disabled="recordsCurrentPage === 1"
              class="w-5 h-5 flex items-center justify-center rounded-[3px] text-gray-400 hover:text-[#1F2835] hover:bg-gray-100 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-400 transition-colors"
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
                  d="M15 19l-7-7 7-7"
                />
              </svg>
            </button>
            <button
              v-for="page in recordsPageNumbers"
              :key="page"
              @click="goToRecordsPage(page)"
              :class="
                recordsCurrentPage === page
                  ? 'text-[#1F2835]'
                  : 'text-gray-400 hover:bg-gray-100'
              "
              class="w-5 h-5 flex items-center justify-center rounded-[3px] text-[10px] font-medium transition-colors"
            >
              {{ page }}
            </button>
            <button
              @click="goToRecordsPage(recordsCurrentPage + 1)"
              :disabled="recordsCurrentPage === totalRecordsPages"
              class="w-5 h-5 flex items-center justify-center rounded-[3px] text-gray-400 hover:text-[#1F2835] hover:bg-gray-100 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-400 transition-colors"
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
                  d="M9 5l7 7-7 7"
                />
              </svg>
            </button>
          </div>
        </div>
      </section>
    </main>

    <div
      v-if="showAddIndustryModal"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-[6px] w-[365px] shadow-xl p-4">
        <h3 class="text-[13px] font-bold text-slate-800 mb-2">
          Create New Industry Node
        </h3>
        <input
          v-model="newIndustryName"
          type="text"
          placeholder="e.g. Finance, Agriculture, Healthcare"
          class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] mb-2 focus:outline-none focus:border-[#F52C11]"
          @keyup.enter="addIndustry"
        />
        <p v-if="addIndustryError" class="text-[11px] text-[#F52C11] mb-2">
          {{ addIndustryError }}
        </p>
        <div class="flex justify-end gap-1.5 mt-3">
          <button
            @click="
              showAddIndustryModal = false;
              newIndustryName = '';
              addIndustryError = '';
            "
            class="px-3 py-1 rounded-[4px] text-[11px] text-slate-600 bg-gray-100 hover:bg-gray-200 transition-colors"
          >
            Cancel
          </button>
          <button
            @click="addIndustry"
            :disabled="!newIndustryName.trim() || isSubmittingIndustry"
            class="px-4 py-1 rounded-[4px] text-[11px] bg-[#F52C11] text-white hover:bg-[#d9250e] disabled:bg-gray-300 transition-colors font-medium"
          >
            Add
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="showArchiveModal"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
    >
      <div
        class="bg-white rounded-[12px] w-[800px] h-[550px] shadow-xl flex flex-col overflow-hidden"
      >
        <div
          class="flex items-center justify-between px-5 py-4 border-b border-gray-200"
        >
          <div class="flex items-center gap-3">
            <div
              class="w-9 h-9 rounded-[8px] bg-[#F52C11]/10 flex items-center justify-center shrink-0"
            >
              <svg
                class="w-[18px] h-[18px] text-[#F52C11]"
                fill="none"
                stroke="currentColor"
                stroke-width="1.75"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                />
              </svg>
            </div>
            <div>
              <div class="font-bold text-[14px] text-slate-800 leading-tight">
                Archived items
              </div>
              <div class="text-[11px] text-gray-400 leading-tight">
                Industry page
              </div>
            </div>
          </div>
          <button
            @click="showArchiveModal = false"
            class="text-[#F52C11] hover:text-[#d9250e] transition-colors"
          >
            <svg
              class="w-[18px] h-[18px]"
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

        <div class="flex items-center gap-5 px-5 border-b border-gray-200">
          <button
            @click="archiveTab = 'records'"
            :class="
              archiveTab === 'records'
                ? 'border-[#F52C11] text-[#F52C11]'
                : 'border-transparent text-gray-400 hover:text-gray-600'
            "
            class="flex items-center gap-1.5 pb-2.5 pt-3 border-b-2 text-[11px] font-medium transition-colors"
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
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
            Archived records
            <span
              :class="
                archiveTab === 'records'
                  ? 'bg-[#F52C11]/10 text-[#F52C11]'
                  : 'bg-gray-100 text-gray-500'
              "
              class="rounded-full px-1.5 py-[1px] text-[10px] font-semibold"
              >{{ archivedRecords.length }}</span
            >
          </button>
          <button
            @click="archiveTab = 'industries'"
            :class="
              archiveTab === 'industries'
                ? 'border-[#F52C11] text-[#F52C11]'
                : 'border-transparent text-gray-400 hover:text-gray-600'
            "
            class="flex items-center gap-1.5 pb-2.5 pt-3 border-b-2 text-[12px] font-medium transition-colors"
          >
            <svg
              class="w-3.5 h-3.5"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <rect x="4" y="4" width="7" height="7" rx="1.5" />
              <rect x="13" y="4" width="7" height="7" rx="1.5" />
              <rect x="4" y="13" width="7" height="7" rx="1.5" />
              <rect x="13" y="13" width="7" height="7" rx="1.5" />
            </svg>
            Archived industries
            <span
              :class="
                archiveTab === 'industries'
                  ? 'bg-[#F52C11]/10 text-[#F52C11]'
                  : 'bg-gray-100 text-gray-500'
              "
              class="rounded-full px-1.5 py-[1px] text-[10px] font-semibold"
              >{{ archivedIndustries.length }}</span
            >
          </button>
        </div>

        <!-- Location filter — records only. Archived industries carry no
             location value, so there's nothing to filter there. -->
        <div
          v-if="archiveTab === 'records'"
          class="px-5 pt-3 pb-1 shrink-0 flex items-center gap-1.5"
        >
          <span class="text-[11px] text-gray-400 mr-0.5"></span>
          <button
            v-for="loc in ['All', ...locationOptions]"
            :key="loc"
            @click="setArchiveLocationFilter(loc)"
            :class="
              archiveLocationFilter === loc
                ? 'bg-[#1F2835] text-white'
                : 'bg-gray-100 text-[#1F2835] border border-gray-200'
            "
            class="px-2.5 py-[2px] rounded-[4px] text-[11px] font-medium transition-colors"
          >
            {{ loc }}
          </button>
        </div>

        <div class="px-5 py-2 shrink-0">
          <div class="relative">
            <svg
              class="w-3 h-3 text-gray-400 absolute left-2 top-1/2 -translate-y-1/2 pointer-events-none"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
            <input
              v-model="archiveSearchQuery"
              type="text"
              :placeholder="
                archiveTab === 'records'
                  ? 'Search archived records...'
                  : 'Search archived industries...'
              "
              class="w-full pl-7 pr-2 py-[4px] bg-white border border-gray-200 rounded-[4px] text-[11px] placeholder:text-gray-400 focus:outline-none focus:border-[#F52C11] transition-colors"
            />
          </div>
        </div>

        <div
          class="flex-1 overflow-y-auto custom-scroll px-5 pb-4 min-h-[200px]"
        >
          <div
            v-if="isLoadingArchive"
            class="text-center text-gray-400 py-10 text-[11px]"
          >
            Loading system archive indices...
          </div>

          <div v-else class="space-y-2.5">
            <template v-if="archiveTab === 'records'">
              <div
                v-if="filteredArchivedRecords.length === 0"
                class="text-center text-gray-400 py-10 text-[11px]"
              >
                No matching archived lead records found.
              </div>
              <div
                v-for="rec in filteredArchivedRecords"
                :key="rec.id"
                class="flex items-center gap-3 p-1 bg-white border border-gray-200 rounded-[8px] hover:border-gray-300 transition-colors"
              >
                <div class="flex items-center gap-3 min-w-0">
                  <input
                    type="checkbox"
                    :checked="isArchiveRecordSelected(rec.id)"
                    @change="toggleArchiveRecordSelection(rec.id)"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] accent-[#F52C11] cursor-pointer shrink-0"
                  />
                  <div
                    class="w-10 h-10 rounded-[8px] bg-gray-100 flex items-center justify-center shrink-0"
                  >
                    <svg
                      class="w-4 h-4 text-gray-400"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.75"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 21h18M6 21V6a1 1 0 011-1h6a1 1 0 011 1v15M9 9h1m3 0h1m-5 4h1m3 0h1m-5 4h1m3 0h1M18 21v-8a1 1 0 00-1-1h-2"
                      />
                    </svg>
                  </div>
                  <div class="min-w-0">
                    <div class="font-bold text-[13px] text-slate-800 truncate">
                      {{ rec.businessName }}
                    </div>
                    <div class="text-[11px] text-gray-400 mt-0.5 truncate">
                      {{ rec.location }}, {{ archivedRecordIndustryName(rec) }}
                      <span class="mx-1">•</span>Archived
                      {{ formatArchiveDate(rec.archivedAt) }}
                    </div>
                  </div>
                </div>
              </div>
            </template>

            <template v-else>
              <div
                v-if="filteredArchivedIndustries.length === 0"
                class="text-center text-gray-400 py-10 text-[11px]"
              >
                No matching archived industries found.
              </div>
              <div
                v-for="ind in filteredArchivedIndustries"
                :key="ind.name"
                class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-[10px]"
              >
                <div class="flex items-center gap-3 min-w-0">
                  <input
                    type="checkbox"
                    :checked="isArchiveIndustrySelected(ind.name)"
                    @change="toggleArchiveIndustrySelection(ind.name)"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] accent-[#F52C11] cursor-pointer shrink-0"
                  />
                  <div
                    class="w-10 h-10 rounded-[8px] bg-gray-100 flex items-center justify-center shrink-0"
                  >
                    <svg
                      class="w-4 h-4 text-gray-400"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.75"
                      viewBox="0 0 24 24"
                    >
                      <rect x="4" y="4" width="7" height="7" rx="1.5" />
                      <rect x="13" y="4" width="7" height="7" rx="1.5" />
                      <rect x="4" y="13" width="7" height="7" rx="1.5" />
                      <rect x="13" y="13" width="7" height="7" rx="1.5" />
                    </svg>
                  </div>
                  <div class="min-w-0">
                    <div class="font-bold text-[13px] text-slate-800 truncate">
                      {{ ind.name }}
                    </div>
                    <div class="flex items-center gap-1.5 mt-0.5">
                      <span
                        class="bg-[#F52C11]/10 text-[#F52C11] text-[10px] font-semibold px-1.5 py-[1px] rounded-full shrink-0"
                        >{{ ind.leadsCount }} leads</span
                      >
                      <span class="text-[11px] text-gray-400 truncate"
                        >• Archived
                        {{ formatArchiveDate(ind.archivedAt) }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>

        <!--Bulk actions - matches PIP index selected-archive bar pattern-->
        <div
          v-if="
            (archiveTab === 'records' && archiveSelectedRecordIds.length > 0) ||
            (archiveTab === 'industries' &&
              archiveSelectedIndustryNames.length > 0)
          "
          class="shrink-0 bg-white border-t border-gray-200 px-3 py-[6px] flex items-center justify-between"
        >
          <div class="flex items-center gap-2 text-[11px] text-[#1F2835]">
            <svg
              class="w-3.5 h-3.5 text-[#F52C11]"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            <span class="font-medium">
              {{
                archiveTab === "records"
                  ? archiveSelectedRecordIds.length
                  : archiveSelectedIndustryNames.length
              }}
              record(s) selected
            </span>
          </div>
          <div class="flex items-center gap-2">
            <!-- Select All Button -->
            <button
              @click="
                archiveTab === 'records'
                  ? toggleAllArchivedRecords()
                  : toggleAllArchivedIndustries()
              "
              class="inline-flex items-center gap-1 px-2.5 py-[4px] rounded-[6px] border border-gray-200 bg-white text-[#1F2835] hover:border-[#F52C11] hover:text-[#F52C11] text-[10px] font-medium transition-colors"
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
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              Select all
            </button>

            <button
              @click="
                archiveTab === 'records'
                  ? restoreSelectedArchivedRecords()
                  : restoreSelectedArchivedIndustries()
              "
              class="inline-flex items-center gap-1 px-2.5 py-[4px] rounded-[6px] border border-gray-200 bg-white text-[#1F2835] hover:border-[#F52C11] text-[10px] font-medium transition-colors"
            >
              <svg
                class="w-3 h-3 text-green-600"
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
              Restore
            </button>
            <button
              @click="
                archiveTab === 'records'
                  ? deleteSelectedArchivedRecords()
                  : deleteSelectedArchivedIndustries()
              "
              class="inline-flex items-center gap-1 px-2.5 py-[4px] rounded-[6px] border border-gray-200 bg-white text-[#1F2835] hover:border-red-400 text-[10px] font-medium transition-colors"
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
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
              Delete
            </button>
          </div>
        </div>

        <div
          class="px-5 py-2 border-t border-gray-100 flex items-center justify-between bg-white shrink-0"
        >
          <div class="flex items-center gap-1.5 text-[9px] text-gray-400">
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
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            <span v-if="archiveTab === 'records'"
              >Restoring moves the record back to its active list</span
            >
            <span v-else
              >Restoring brings the industry and its leads back to the
              sidebar</span
            >
          </div>
          <button
            @click="showArchiveModal = false"
            class="px-3 py-[4px] rounded-[6px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
          >
            Close
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="
        showDatePicker || showServicesDropdown || openIndustryMenuIndex !== null
      "
      class="fixed inset-0 z-40"
      @click="closeAllDropdowns"
    ></div>

    <ViewRecordModal
      v-if="showViewModal"
      :record="viewingRecord"
      @close="closeViewModal"
    />

    <EditRecordModal
      v-if="showEditModal"
      :record="toEditModalRecord(editingRecord)"
      :error-message="editSaveError"
      :saving="isEditSaving"
      @close="closeEditModal"
      @save="handleEditSave"
    />

    <!-- Toast Notifications -->
    <div class="fixed top-4 right-4 z-[200] flex flex-col gap-2 w-72">
      <TransitionGroup name="toast">
        <div
          v-for="t in toast.toasts.value"
          :key="t.id"
          :class="[
            'flex items-start gap-2 px-3 py-2 rounded-[6px] shadow-lg border text-[12px] font-medium',
            t.type === 'success' && 'bg-white border-green-200 text-green-700',
            t.type === 'error' && 'bg-white border-red-200 text-red-600',
            t.type === 'warning' && 'bg-white border-amber-200 text-amber-700',
            t.type === 'info' && 'bg-white border-gray-200 text-[#1F2835]',
          ]"
        >
          <svg
            v-if="t.type === 'success'"
            class="w-3.5 h-3.5 mt-[1px] shrink-0"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M5 13l4 4L19 7"
            />
          </svg>
          <svg
            v-else-if="t.type === 'error'"
            class="w-3.5 h-3.5 mt-[1px] shrink-0"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 9v3.75m0 3.75h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <svg
            v-else
            class="w-3.5 h-3.5 mt-[1px] shrink-0"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <span class="flex-1">{{ t.message }}</span>
          <button
            @click="toast.remove(t.id)"
            class="shrink-0 text-gray-400 hover:text-[#1F2835] transition-colors"
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
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </TransitionGroup>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import EditRecordModal from "./edit.vue";
import ViewRecordModal from "./view.vue";
import { useApi } from "~/composables/useApi";
import { useAuditLog } from "~/composables/useAuditLog";
import { useToast } from "~/composables/useToast";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

const route = useRoute();
const router = useRouter();
const { apiFetch } = useApi();
const { logAuditAction } = useAuditLog();
const toast = useToast();

/* ---------------------------------------------------------------------- */
/* Operational Reactive States Storage Log Setup Variables */
/* ---------------------------------------------------------------------- */
const searchQuery = ref("");
const locationOptions = ref(["Davao", "Manila"]);
const selectedLocation = ref("Davao");
const selectedIndustry = ref("");
const selectedIds = ref([]);
const selectedDate = ref("");
const selectedService = ref("All Services");

// Industry Collection Stores
const industries = ref([]);
const archivedIndustries = ref([]);
const industryIdByName = ref({});

// Records List Stores
const records = ref([]);
const archivedRecords = ref([]);

// Modals / Dropdowns Toggles
const showAddIndustryModal = ref(false);
const showArchiveModal = ref(false);
const showDatePicker = ref(false);
const showServicesDropdown = ref(false);
const openIndustryMenuIndex = ref(null);
const editingIndex = ref(null);

// Modal Tracking States
const viewingRecord = ref(null);
const editingRecord = ref(null);
const showViewModal = ref(false);
const showEditModal = ref(false);
const editSaveError = ref("");
const isEditSaving = ref(false);
const currentUserId = ref(null);

const renameValue = ref("");
const newIndustryName = ref("");
const addIndustryError = ref("");
const archiveSearchQuery = ref("");
const archiveTab = ref("records");
// Only applies to the "Archived records" tab — archived industries have
// no location field to filter by.
const archiveLocationFilter = ref("All");

// Archive multi-select state (kept separate per tab since records use
// numeric ids and industries are keyed by name)
const archiveSelectedRecordIds = ref([]);
const archiveSelectedIndustryNames = ref([]);

// Loading Indicators
const isSubmittingIndustry = ref(false);
const isLoadingIndustries = ref(false);
const isLoadingRecords = ref(false);
const isLoadingArchive = ref(false);

// Pagination Elements - matches PIP index naming/behavior pattern
const rowsPerPageOptions = [13, 26, 39, 52, 65];
const recordsCurrentPage = ref(1);
const recordsRowsPerPage = ref(13);
const recordsPageInput = ref("");

// Internal Custom Calendar Core Configurations
const currentMonth = ref(new Date().getMonth());
const currentYear = ref(new Date().getFullYear());

const serviceOptions = ref([
  "All Services",
  "Website Development",
  "Custom Software",
  "Mobile Application",
  "Digital Marketing",
  "Multimedia",
  "Hosting & Server",
]);

/* ---------------------------------------------------------------------- */
/* Translation Schema Object Form Normalizer Utilities Matrix */
/* ---------------------------------------------------------------------- */
function normalizeRecord(raw) {
  if (!raw) return null;
  return {
    id: raw.id,
    // `leads` has no `date` column in the DB — fall back to created_at
    // (trimmed to YYYY-MM-DD) so existing rows still show something.
    date:
      raw.date || (raw.created_at ? String(raw.created_at).slice(0, 10) : ""),
    businessName: raw.business_name || raw.businessName || "",
    contactPerson: raw.contact_person || raw.contactPerson || "",
    jobPosition: raw.job_position || raw.jobPosition || "",
    contactNo: raw.contact_number || raw.contact_no || raw.contactNo || "",
    email: raw.email || "",
    service: raw.service_name || raw.service || "",
    status: raw.status_name || raw.status || "Emailed",
    statusPercent: parseInt(
      raw.status_percent || raw.statusPercent || raw.progress || 0,
      10
    ),
    remarks: raw.remarks || "",
    location: raw.location || "Davao",
    industryId: raw.industry_id || raw.industryId || null,
    // Archive-only metadata — only present on rows returned by the
    // /leads/archived endpoint, harmless (undefined -> "") elsewhere.
    // `archivedDate` is what LeadController::formatLead() actually sends;
    // archived_at/deleted_at kept as fallbacks for other archive types
    // that might go through this same normalizer shape.
    archivedAt: raw.archivedDate || raw.archived_at || raw.deleted_at || null,
  };
}

function normalizeIndustry(raw) {
  if (!raw) return null;
  return {
    id: raw.id,
    name: raw.industry_name || raw.name || "",
    // Archive-only metadata — only present on rows returned by the
    // /archived/industry endpoint.
    leadsCount: raw.leads_count ?? raw.active_leads_count ?? 0,
    archivedAt: raw.archived_at || raw.deleted_at || null,
  };
}

function clearDateFilter() {
  selectedDate.value = "";
  showDatePicker.value = false;
}
// Laravel sometimes wraps responses as { data: ... } (API Resources) and
// sometimes returns the raw model/array directly, depending on the
// controller. This normalizes both shapes so callers don't have to care
// which one a given endpoint uses.
function payloadData(response) {
  return response?.data ?? response;
}

/* ---------------------------------------------------------------------- */
/* Unified Native API Pipeline Connection Handlers (Using project apiFetch) */
/* ---------------------------------------------------------------------- */
async function fetchIndustries() {
  isLoadingIndustries.value = true;
  try {
    const response = await apiFetch("/industries");
    const parsed = (
      Array.isArray(payloadData(response)) ? payloadData(response) : []
    ).map(normalizeIndustry);

    industries.value = parsed.map((i) => i.name);
    parsed.forEach((i) => {
      if (i.id && i.name) industryIdByName.value[i.name] = i.id;
    });
  } catch (err) {
    console.warn(
      "Failed to gather system industry data lists via apiFetch:",
      err
    );
    toast.error("Failed to load industries.");
  } finally {
    isLoadingIndustries.value = false;
  }
}

async function fetchArchivedIndustries() {
  try {
    const response = await apiFetch("/archived/industry");
    const parsed = (
      Array.isArray(payloadData(response)) ? payloadData(response) : []
    ).map(normalizeIndustry);
    archivedIndustries.value = parsed;
    parsed.forEach((i) => {
      if (i.id && i.name) industryIdByName.value[i.name] = i.id;
    });
  } catch (err) {
    console.warn("Could not query archived industries:", err);
    toast.error("Failed to load archived industries.");
  }
}

async function fetchRecords() {
  if (!selectedIndustry.value) {
    records.value = [];
    return;
  }
  isLoadingRecords.value = true;
  try {
    const queryParams = {
      location: selectedLocation.value,
      industry: selectedIndustry.value,
    };
    if (searchQuery.value.trim()) queryParams.search = searchQuery.value.trim();
    if (selectedService.value !== "All Services")
      queryParams.service = selectedService.value;
    if (selectedDate.value) queryParams.date = selectedDate.value;

    const response = await apiFetch("/leads", { query: queryParams });
    const data = payloadData(response);
    records.value = Array.isArray(data) ? data.map(normalizeRecord) : [];
  } catch (err) {
    console.warn("Leads fetch query rejection:", err);
    records.value = [];
    toast.error("Failed to load leads.");
  } finally {
    isLoadingRecords.value = false;
  }
}

async function fetchArchive() {
  isLoadingArchive.value = true;
  try {
    const query = {};
    // "All" means don't scope by location at all; otherwise scope the
    // archive listing to whichever location the modal filter is set to
    // (independent from the main table's location toggle). This only
    // applies when viewing the "Archived records" tab — archived
    // industries have no location value to filter against.
    if (archiveLocationFilter.value !== "All") {
      query.location = archiveLocationFilter.value;
    }
    const response = await apiFetch("/leads/archived", { query });
    const data = payloadData(response);
    archivedRecords.value = Array.isArray(data)
      ? data.map(normalizeRecord)
      : [];
  } catch (err) {
    console.warn("Archive logs lookup execution exception:", err);
    toast.error("Failed to load archive.");
  } finally {
    isLoadingArchive.value = false;
  }
}

/* ---------------------------------------------------------------------- */
/* Operational Core Actions / Commands Handlers Framework Matrix */
/* ---------------------------------------------------------------------- */
async function addIndustry() {
  const targetName = newIndustryName.value.trim();
  if (!targetName) return;
  isSubmittingIndustry.value = true;
  addIndustryError.value = "";
  try {
    const response = await apiFetch("/industries", {
      method: "POST",
      body: { industry_name: targetName },
    });
    const parsed = normalizeIndustry(payloadData(response));
    if (parsed && parsed.name) {
      industryIdByName.value[parsed.name] = parsed.id;
    }
    await fetchIndustries();
    selectedIndustry.value = targetName;
    showAddIndustryModal.value = false;
    newIndustryName.value = "";

    logAuditAction({
      module: "Industry",
      description: `Added new industry: ${targetName}`,
    });
    toast.success(`Industry "${targetName}" added.`);
  } catch (err) {
    // Laravel validation errors (422) come back with a specific shape —
    // try to pull the actual field message out first (e.g. "The industry
    // name has already been taken."), otherwise fall back to a friendly
    // generic message rather than dumping the raw HTTP error string.
    const status = err?.response?.status || err?.status || err?.statusCode;
    const serverErrors =
      err?.data?.errors ||
      err?.response?._data?.errors ||
      err?.response?.data?.errors;
    const serverMessage =
      err?.data?.message ||
      err?.response?._data?.message ||
      err?.response?.data?.message;

    if (status === 422) {
      addIndustryError.value =
        serverErrors?.industry_name?.[0] ||
        serverMessage ||
        `"${targetName}" is already in use. Please choose a different name.`;
      // Inline message in the modal is enough here — skip the toast so
      // the error doesn't show twice.
    } else {
      addIndustryError.value =
        serverMessage || "Failed to add industry. Please try again.";
      toast.error(addIndustryError.value);
    }
  } finally {
    isSubmittingIndustry.value = false;
  }
}

async function finishRename(index) {
  const oldName = sortedIndustries.value[index];
  const newName = renameValue.value.trim();
  if (newName && newName !== oldName) {
    const industryId = industryIdByName.value[oldName];
    if (industryId) {
      try {
        const response = await apiFetch(`/industries/${industryId}`, {
          method: "PUT",
          body: { industry_name: newName },
        });
        const updated = normalizeIndustry(payloadData(response));
        await fetchIndustries();
        if (selectedIndustry.value === oldName) {
          selectedIndustry.value = updated?.name || newName;
        }
        await fetchRecords();

        logAuditAction({
          module: "Industry",
          description: `Renamed industry "${oldName}" to "${newName}"`,
        });
        toast.success(`Industry renamed to "${newName}".`);
      } catch (err) {
        console.error("Renaming industry entity node pipeline error:", err);
        toast.error("Failed to rename industry.");
      }
    }
  }
  editingIndex.value = null;
}

async function archiveIndustry(industry) {
  const industryId = industryIdByName.value[industry];
  if (!industryId) return;
  try {
    await apiFetch(`/archive/industry/${industryId}`, { method: "POST" });
    await fetchIndustries();
    await fetchArchivedIndustries();
    if (selectedIndustry.value === industry) {
      selectedIndustry.value = sortedIndustries.value[0] || "";
      await fetchRecords();
    }

    logAuditAction({
      module: "Industry",
      description: `Archived industry: ${industry}`,
    });
    toast.success(`"${industry}" archived.`);
  } catch (err) {
    console.error("Failed to archive workspace dynamic link layer:", err);
    toast.error("Failed to archive industry.");
  }
  openIndustryMenuIndex.value = null;
}

async function restoreIndustry(industry) {
  const industryId = industryIdByName.value[industry];
  if (!industryId) return;
  try {
    await apiFetch(`/unarchive/industry/${industryId}`, { method: "POST" });
    await fetchIndustries();
    await fetchArchivedIndustries();
    selectedIndustry.value = industry;
    await fetchRecords();

    logAuditAction({
      module: "Industry",
      description: `Restored industry: ${industry}`,
    });
    toast.success(`"${industry}" restored.`);
  } catch (err) {
    console.error("Restoring targeted industry row sequence exception:", err);
    toast.error("Failed to restore industry.");
  }
}

async function permanentDeleteIndustry(industry) {
  if (
    !confirm(
      `Are you completely certain you want to permanently delete "${industry}" and remove it from backend database systems storage? This cannot be undone.`
    )
  )
    return;
  const industryId = industryIdByName.value[industry];
  if (!industryId) return;
  try {
    await apiFetch(`/industries/${industryId}`, { method: "DELETE" });
    await fetchArchivedIndustries();

    logAuditAction({
      module: "Industry",
      description: `Permanently deleted industry: ${industry}`,
    });
    toast.success(`"${industry}" permanently deleted.`);
  } catch (err) {
    console.error("Purging industry storage reference exception:", err);
    toast.error("Failed to delete industry.");
  }
}

/* ---------------------------------------------------------------------- */
/* Leads Rows Management Logic Event Handlers Matrix Details Dispatch */
/* ---------------------------------------------------------------------- */
function goToAddRecord() {
  if (!selectedIndustry.value) return;
  // Creation now happens on its own page (create.vue) instead of an inline
  // modal — pass along everything it needs so it doesn't have to re-fetch.
  router.push({
    path: "/industry/create",
    query: {
      industryId: industryIdByName.value[selectedIndustry.value],
      location: selectedLocation.value,
      ...(currentUserId.value ? { userId: currentUserId.value } : {}),
    },
  });
}

async function handleEditSave(formFromModal) {
  if (!editingRecord.value) return;
  editSaveError.value = "";
  isEditSaving.value = true;
  try {
    const payload = {
      date: formFromModal.date,
      business_name: formFromModal.businessName,
      contact_person: formFromModal.contactPerson,
      job_position: formFromModal.jobPosition,
      contact_number: formFromModal.contactNo || formFromModal.contactNumber,
      email: formFromModal.email,
      service_name: formFromModal.service,
      status_name: formFromModal.status || editingRecord.value.status,
      status_percent:
        formFromModal.statusPercent || formFromModal.progress || 0,
      remarks: formFromModal.remarks,
      location: formFromModal.location,
      industry_id: industryIdByName.value[formFromModal.industry],
    };
    await apiFetch(`/leads/${editingRecord.value.id}`, {
      method: "PUT",
      body: payload,
    });
    closeEditModal();
    await fetchRecords();

    logAuditAction({
      module: "Leads Tracker",
      description: `Updated lead record for ${formFromModal.businessName}`,
    });
    toast.success(`Lead updated for ${formFromModal.businessName}.`);
  } catch (err) {
    console.error(
      "Database patch log index update exception handler tracker:",
      err
    );
    editSaveError.value =
      err?.data?.message ||
      err?.response?._data?.message ||
      err?.statusMessage ||
      err?.message ||
      "Unable to save changes. Please try again.";
    toast.error(editSaveError.value);
  } finally {
    isEditSaving.value = false;
  }
}

async function archiveSingleRecord(id) {
  try {
    const target = records.value.find((r) => r.id === id);
    const targetName =
      target?.businessName || target?.business_name || "record";

    await apiFetch("/leads/archive", {
      method: "POST",
      body: { ids: [id] },
    });
    records.value = records.value.filter((r) => r.id !== id);
    selectedIds.value = selectedIds.value.filter((x) => x !== id);

    logAuditAction({
      module: "Leads Tracker",
      description: `Archived lead record: ${targetName}`,
    });
    toast.success(`Archived "${targetName}".`);
  } catch (err) {
    console.error("Archive lead conversion mapping runtime error:", err);
    toast.error("Failed to archive record.");
  }
}

async function archiveSelectedRecords() {
  if (selectedIds.value.length === 0) return;
  try {
    const targetNames = records.value
      .filter((r) => selectedIds.value.includes(r.id))
      .map((r) => r.businessName || r.business_name)
      .filter(Boolean)
      .join(", ");

    await apiFetch("/leads/archive", {
      method: "POST",
      body: { ids: selectedIds.value },
    });
    records.value = records.value.filter(
      (r) => !selectedIds.value.includes(r.id)
    );

    logAuditAction({
      module: "Leads Tracker",
      description:
        selectedIds.value.length === 1
          ? `Archived lead record: ${targetNames}`
          : `Archived ${selectedIds.value.length} lead records: ${targetNames}`,
    });

    toast.success(
      selectedIds.value.length === 1
        ? "Archived 1 record."
        : `Archived ${selectedIds.value.length} records.`
    );
    selectedIds.value = [];
  } catch (err) {
    console.error(
      "Bulk archive update transaction exception pipeline error:",
      err
    );
    toast.error("Failed to archive selected records.");
  }
}

async function restoreRecord(id) {
  try {
    const target = archivedRecords.value.find((r) => r.id === id);
    const targetName =
      target?.businessName || target?.business_name || "record";

    await apiFetch(`/leads/${id}/restore`, { method: "PUT" });
    await fetchArchive();
    await fetchRecords();

    logAuditAction({
      module: "Leads Tracker",
      description: `Restored lead record: ${targetName}`,
    });
    toast.success(`Restored "${targetName}".`);
  } catch (err) {
    console.error("Re-routing dynamic trace records restoration error:", err);
    toast.error("Failed to restore record.");
  }
}

async function permanentDeleteRecord(id) {
  if (
    !confirm(
      "Are you completely certain you want to permanently delete this lead trace out of backend database systems storage?"
    )
  )
    return;
  try {
    const target = archivedRecords.value.find((r) => r.id === id);
    const targetName =
      target?.businessName || target?.business_name || "record";

    await apiFetch(`/leads/${id}`, { method: "DELETE" });
    await fetchArchive();

    logAuditAction({
      module: "Leads Tracker",
      description: `Permanently deleted lead record: ${targetName}`,
    });
    toast.success(`"${targetName}" permanently deleted.`);
  } catch (err) {
    console.error(
      "Purging storage reference transaction rejection error:",
      err
    );
    toast.error("Failed to delete record.");
  }
}

/* ---------------------------------------------------------------------- */
/* Archive Multi-Select Bulk Action Handlers Matrix */
/* ---------------------------------------------------------------------- */
async function restoreSelectedArchivedRecords() {
  if (archiveSelectedRecordIds.value.length === 0) return;
  const count = archiveSelectedRecordIds.value.length;
  try {
    await Promise.all(
      archiveSelectedRecordIds.value.map((id) =>
        apiFetch(`/leads/${id}/restore`, { method: "PUT" })
      )
    );
    logAuditAction({
      module: "Leads Tracker",
      description: `Restored ${count} lead record(s)`,
    });
    toast.success(
      count === 1 ? "Restored 1 record." : `Restored ${count} records.`
    );
    archiveSelectedRecordIds.value = [];
    await fetchArchive();
    await fetchRecords();
  } catch (err) {
    console.error("Bulk restore of archived records failed:", err);
    toast.error("Failed to restore selected records.");
  }
}

async function deleteSelectedArchivedRecords() {
  if (archiveSelectedRecordIds.value.length === 0) return;
  const count = archiveSelectedRecordIds.value.length;
  if (
    !confirm(
      `Are you completely certain you want to permanently delete ${count} record(s) from backend database systems storage? This cannot be undone.`
    )
  )
    return;
  try {
    await Promise.all(
      archiveSelectedRecordIds.value.map((id) =>
        apiFetch(`/leads/${id}`, { method: "DELETE" })
      )
    );
    logAuditAction({
      module: "Leads Tracker",
      description: `Permanently deleted ${count} lead record(s)`,
    });
    toast.success(
      count === 1 ? "Deleted 1 record." : `Deleted ${count} records.`
    );
    archiveSelectedRecordIds.value = [];
    await fetchArchive();
  } catch (err) {
    console.error("Bulk permanent delete of archived records failed:", err);
    toast.error("Failed to delete selected records.");
  }
}

async function restoreSelectedArchivedIndustries() {
  if (archiveSelectedIndustryNames.value.length === 0) return;
  const count = archiveSelectedIndustryNames.value.length;
  try {
    await Promise.all(
      archiveSelectedIndustryNames.value.map((name) => {
        const id = industryIdByName.value[name];
        return id
          ? apiFetch(`/unarchive/industry/${id}`, { method: "POST" })
          : Promise.resolve();
      })
    );
    logAuditAction({
      module: "Industry",
      description: `Restored ${count} industry(ies)`,
    });
    toast.success(
      count === 1 ? "Restored 1 industry." : `Restored ${count} industries.`
    );
    archiveSelectedIndustryNames.value = [];
    await fetchIndustries();
    await fetchArchivedIndustries();
  } catch (err) {
    console.error("Bulk restore of archived industries failed:", err);
    toast.error("Failed to restore selected industries.");
  }
}

async function deleteSelectedArchivedIndustries() {
  if (archiveSelectedIndustryNames.value.length === 0) return;
  const count = archiveSelectedIndustryNames.value.length;
  if (
    !confirm(
      `Are you completely certain you want to permanently delete ${count} industry(ies) from backend database systems storage? This cannot be undone.`
    )
  )
    return;
  try {
    await Promise.all(
      archiveSelectedIndustryNames.value.map((name) => {
        const id = industryIdByName.value[name];
        return id
          ? apiFetch(`/industries/${id}`, { method: "DELETE" })
          : Promise.resolve();
      })
    );
    logAuditAction({
      module: "Industry",
      description: `Permanently deleted ${count} industry(ies)`,
    });
    toast.success(
      count === 1 ? "Deleted 1 industry." : `Deleted ${count} industries.`
    );
    archiveSelectedIndustryNames.value = [];
    await fetchArchivedIndustries();
  } catch (err) {
    console.error("Bulk permanent delete of archived industries failed:", err);
    toast.error("Failed to delete selected industries.");
  }
}

function isArchiveRecordSelected(id) {
  return archiveSelectedRecordIds.value.includes(id);
}

function toggleArchiveRecordSelection(id) {
  const idx = archiveSelectedRecordIds.value.indexOf(id);
  if (idx > -1) archiveSelectedRecordIds.value.splice(idx, 1);
  else archiveSelectedRecordIds.value.push(id);
}

function isArchiveIndustrySelected(name) {
  return archiveSelectedIndustryNames.value.includes(name);
}

function toggleArchiveIndustrySelection(name) {
  const idx = archiveSelectedIndustryNames.value.indexOf(name);
  if (idx > -1) archiveSelectedIndustryNames.value.splice(idx, 1);
  else archiveSelectedIndustryNames.value.push(name);
}

function setArchiveLocationFilter(loc) {
  archiveLocationFilter.value = loc;
  archiveSelectedRecordIds.value = [];
  fetchArchive();
}

/* ---------------------------------------------------------------------- */
/* Computed Representation Elements Filter Pipeline Transformers Matrix */
/* ---------------------------------------------------------------------- */
const sortedIndustries = computed(() => {
  return [...industries.value].sort((a, b) => a.localeCompare(b));
});

const filteredRecords = computed(() => {
  return records.value; // Relies on server-side filters applied via apiFetch query arguments
});

// Notification badge shown on the "View archive" button — matches PIP
// index pattern, combining both archived records and archived industries.
const totalArchivedCount = computed(
  () => archivedRecords.value.length + archivedIndustries.value.length
);

// Pagination computed props - matches PIP index naming/behavior pattern
const totalRecordsPages = computed(() =>
  Math.max(
    1,
    Math.ceil(filteredRecords.value.length / recordsRowsPerPage.value)
  )
);

const paginatedRecords = computed(() => {
  const start = (recordsCurrentPage.value - 1) * recordsRowsPerPage.value;
  return filteredRecords.value.slice(start, start + recordsRowsPerPage.value);
});

const recordsRangeStart = computed(() =>
  filteredRecords.value.length === 0
    ? 0
    : (recordsCurrentPage.value - 1) * recordsRowsPerPage.value + 1
);
const recordsRangeEnd = computed(() =>
  Math.min(
    recordsCurrentPage.value * recordsRowsPerPage.value,
    filteredRecords.value.length
  )
);

const recordsPageNumbers = computed(() => {
  const total = totalRecordsPages.value;
  const current = recordsCurrentPage.value;
  const maxButtons = 5;
  let start = Math.max(1, current - Math.floor(maxButtons / 2));
  let end = Math.min(total, start + maxButtons - 1);
  start = Math.max(1, end - maxButtons + 1);
  const pages = [];
  for (let p = start; p <= end; p++) pages.push(p);
  return pages;
});

function goToRecordsPage(page) {
  recordsCurrentPage.value = Math.min(
    Math.max(1, page),
    totalRecordsPages.value
  );
}

function goToTypedRecordsPage() {
  const page = parseInt(recordsPageInput.value, 10);
  if (!isNaN(page)) goToRecordsPage(page);
  recordsPageInput.value = "";
}

const filteredArchivedIndustries = computed(() => {
  const q = archiveSearchQuery.value.trim().toLowerCase();
  if (!q) return archivedIndustries.value;
  return archivedIndustries.value.filter((i) =>
    i.name.toLowerCase().includes(q)
  );
});

const filteredArchivedRecords = computed(() => {
  const q = archiveSearchQuery.value.trim().toLowerCase();
  if (!q) return archivedRecords.value;
  return archivedRecords.value.filter(
    (r) =>
      r.businessName.toLowerCase().includes(q) ||
      r.service.toLowerCase().includes(q)
  );
});

const isAllArchivedRecordsSelected = computed(() => {
  const ids = filteredArchivedRecords.value.map((r) => r.id);
  return (
    ids.length > 0 &&
    ids.every((id) => archiveSelectedRecordIds.value.includes(id))
  );
});

const isAllArchivedIndustriesSelected = computed(() => {
  const names = filteredArchivedIndustries.value.map((i) => i.name);
  return (
    names.length > 0 &&
    names.every((n) => archiveSelectedIndustryNames.value.includes(n))
  );
});

/* ---------------------------------------------------------------------- */
/* Archive Modal Presentation Helpers Matrix */
/* ---------------------------------------------------------------------- */
function archivedRecordIndustryName(rec) {
  if (!rec) return "";
  const entry = Object.entries(industryIdByName.value).find(
    ([, id]) => String(id) === String(rec.industryId)
  );
  return entry ? entry[0] : rec.service || "";
}

function formatArchiveDate(value) {
  if (!value) return "—";
  const parsed = new Date(value);
  if (Number.isNaN(parsed.getTime())) return String(value).slice(0, 10);
  return parsed.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
}

/* ---------------------------------------------------------------------- */
/* Selection Framework Mapping Actions Controllers Dispatch Methods */
/* ---------------------------------------------------------------------- */
const isAllSelected = computed(() => {
  const visibleIds = paginatedRecords.value.map((r) => r.id);
  return (
    visibleIds.length > 0 &&
    visibleIds.every((id) => selectedIds.value.includes(id))
  );
});

function toggleSelection(id) {
  const idx = selectedIds.value.indexOf(id);
  if (idx > -1) selectedIds.value.splice(idx, 1);
  else selectedIds.value.push(id);
}

function toggleAll() {
  const visibleIds = paginatedRecords.value.map((r) => r.id);
  if (isAllSelected.value) {
    selectedIds.value = selectedIds.value.filter(
      (id) => !visibleIds.includes(id)
    );
  } else {
    visibleIds.forEach((id) => {
      if (!selectedIds.value.includes(id)) selectedIds.value.push(id);
    });
  }
}

function isSelected(id) {
  return selectedIds.value.includes(id);
}

function toggleAllArchivedRecords() {
  const ids = filteredArchivedRecords.value.map((r) => r.id);
  if (isAllArchivedRecordsSelected.value) {
    archiveSelectedRecordIds.value = archiveSelectedRecordIds.value.filter(
      (id) => !ids.includes(id)
    );
  } else {
    ids.forEach((id) => {
      if (!archiveSelectedRecordIds.value.includes(id))
        archiveSelectedRecordIds.value.push(id);
    });
  }
}

function toggleAllArchivedIndustries() {
  const names = filteredArchivedIndustries.value.map((i) => i.name);
  if (isAllArchivedIndustriesSelected.value) {
    archiveSelectedIndustryNames.value =
      archiveSelectedIndustryNames.value.filter((n) => !names.includes(n));
  } else {
    names.forEach((n) => {
      if (!archiveSelectedIndustryNames.value.includes(n))
        archiveSelectedIndustryNames.value.push(n);
    });
  }
}

/* ---------------------------------------------------------------------- */
/* Workspace View Control Interface UI Transformation Helpers Event Handlers */
/* ---------------------------------------------------------------------- */
function startInlineRename(name, index) {
  editingIndex.value = index;
  renameValue.value = name;
  openIndustryMenuIndex.value = null;
}

function toggleIndustryMenu(index) {
  openIndustryMenuIndex.value =
    openIndustryMenuIndex.value === index ? null : index;
}

function cancelRename() {
  editingIndex.value = null;
}

function closeAllDropdowns() {
  showDatePicker.value = false;
  showServicesDropdown.value = false;
  openIndustryMenuIndex.value = null;
}

async function switchLocation(loc) {
  selectedLocation.value = loc;
  selectedIds.value = [];
  recordsCurrentPage.value = 1;
  await fetchRecords();
}

async function openArchiveModal() {
  showArchiveModal.value = true;
  archiveSelectedRecordIds.value = [];
  archiveSelectedIndustryNames.value = [];
  await fetchArchivedIndustries();
  await fetchArchive();
}

/* ---------------------------------------------------------------------- */
/* Submodal Inter-Component Data Bindings Conversions Framework Interfaces */
/* ---------------------------------------------------------------------- */
function viewRecord(record) {
  // normalizeRecord only keeps industryId (no industry name column comes
  // back on the lead itself), so stitch in the currently selected
  // industry's name for display — every visible row belongs to it anyway.
  viewingRecord.value = { ...record, industry: selectedIndustry.value };
  showViewModal.value = true;
}

function openEditModal(record) {
  editSaveError.value = "";
  editingRecord.value = record;
  showEditModal.value = true;
}

function closeViewModal() {
  showViewModal.value = false;
  viewingRecord.value = null;
}

function closeEditModal() {
  showEditModal.value = false;
  editingRecord.value = null;
  editSaveError.value = "";
}

function toEditModalRecord(rec) {
  if (!rec) return null;
  return {
    businessName: rec.businessName,
    contactPerson: rec.contactPerson,
    jobPosition: rec.jobPosition,
    service: rec.service,
    date: rec.date,
    contactNumber: rec.contactNo,
    email: rec.email,
    location: rec.location,
    remarks: rec.remarks,
    industry: selectedIndustry.value,
    progress: rec.statusPercent,
  };
}

/* ---------------------------------------------------------------------- */
/* Custom Reactive Date Picker Picker Matrix Process Engine Logic Calendar */
/* ---------------------------------------------------------------------- */
const currentMonthYear = computed(() => {
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  return `${months[currentMonth.value]} ${currentYear.value}`;
});

// Formats the internally-stored YYYY-MM-DD selectedDate as MM/DD/YYYY for
// display in the filter button. The underlying selectedDate ref stays
// untouched (still YYYY-MM-DD) since fetchRecords() sends it straight to
// the /leads endpoint's `date` query param.
const formattedSelectedDate = computed(() => {
  if (!selectedDate.value) return "";
  const [year, month, day] = selectedDate.value.split("-");
  return `${month}/${day}/${year}`;
});

const calendarDays = computed(() => {
  const startDay = new Date(currentYear.value, currentMonth.value, 1).getDay();
  const daysInMonth = new Date(
    currentYear.value,
    currentMonth.value + 1,
    0
  ).getDate();
  const days = [];

  // Compute "today" as YYYY-MM-DD once per render so we can flag the
  // matching cell in the currently-displayed month/year with a border.
  const now = new Date();
  const todayStr = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(
    2,
    "0"
  )}-${String(now.getDate()).padStart(2, "0")}`;

  for (let i = 0; i < startDay; i++)
    days.push({ day: "", isCurrentMonth: false, date: null });
  for (let i = 1; i <= daysInMonth; i++) {
    const dateStr = `${currentYear.value}-${String(
      currentMonth.value + 1
    ).padStart(2, "0")}-${String(i).padStart(2, "0")}`;
    days.push({
      day: i,
      isCurrentMonth: true,
      date: dateStr,
      isSelected: selectedDate.value === dateStr,
      isToday: dateStr === todayStr,
    });
  }
  return days;
});

function prevMonth() {
  if (currentMonth.value === 0) {
    currentMonth.value = 11;
    currentYear.value--;
  } else currentMonth.value--;
}

function nextMonth() {
  if (currentMonth.value === 11) {
    currentMonth.value = 0;
    currentYear.value++;
  } else currentMonth.value++;
}

function selectDate(date) {
  selectedDate.value = date;
  showDatePicker.value = false;
}

/* ---------------------------------------------------------------------- */
/* Status Tracking UI Custom Presentation Styling Element Map Conversions */
/* ---------------------------------------------------------------------- */
const statusColorPalette = [
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

const getStatusColor = (percent) => {
  const value = Number(percent) || 0;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return statusColorPalette[bucket - 1];
};

/* ---------------------------------------------------------------------- */
/* Live Application Mounting Hook System Lifecycle Step */
/* ---------------------------------------------------------------------- */
onMounted(async () => {
  if (route.query.location) selectedLocation.value = route.query.location;
  isLoadingIndustries.value = true;
  await fetchIndustries();
  // Fetch archived industries AND archived records up front so the
  // "View archive" badge and per-tab counts are correct on first paint,
  // instead of only populating once the modal is opened.
  await fetchArchivedIndustries();
  await fetchArchive();
  try {
    const meResponse = await apiFetch("/me");
    const meUser = meResponse?.data?.user || meResponse?.user;
    currentUserId.value =
      meUser?.id ||
      JSON.parse(localStorage.getItem("user") || "null")?.id ||
      null;
  } catch {
    currentUserId.value =
      JSON.parse(localStorage.getItem("user") || "null")?.id || null;
  }

  // If we've just come back from create.vue (which passes industryId back
  // on save), restore that industry tab instead of always jumping to
  // whichever one sorts first alphabetically.
  const returnedIndustryId = route.query.industryId || route.query.industry_id;
  const matchedName = returnedIndustryId
    ? Object.keys(industryIdByName.value).find(
        (name) =>
          String(industryIdByName.value[name]) === String(returnedIndustryId)
      )
    : null;

  if (matchedName) {
    selectedIndustry.value = matchedName;
  } else if (sortedIndustries.value.length > 0) {
    selectedIndustry.value = sortedIndustries.value[0];
  }
  isLoadingIndustries.value = false;
  await fetchRecords();
});

/* ---------------------------------------------------------------------- */
/* Workspace Filter Change Event Observers Matrix Watch Setup */
/* ---------------------------------------------------------------------- */
watch(
  [
    selectedIndustry,
    searchQuery,
    selectedService,
    selectedDate,
    selectedLocation,
  ],
  () => {
    selectedIds.value = [];
    recordsCurrentPage.value = 1;
    fetchRecords();
  }
);

watch(recordsRowsPerPage, () => {
  recordsCurrentPage.value = 1;
});

// Switching tabs inside the archive modal clears the other tab's
// selection so a stray "Delete selected" click can't act on rows that
// aren't currently visible.
watch(archiveTab, () => {
  archiveSelectedRecordIds.value = [];
  archiveSelectedIndustryNames.value = [];
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

.custom-scroll::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #e0e0e0;
  border: 1px solid #c9c9c9;
  border-radius: 10px;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: #f52c11;
  border-radius: 10px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #f52c11;
}

.toast-enter-active,
.toast-leave-active {
  transition: all 0.25s ease;
}
.toast-enter-from {
  opacity: 0;
  transform: translateX(24px);
}
.toast-leave-to {
  opacity: 0;
  transform: translateX(24px);
}
.toast-leave-active {
  position: absolute;
}
</style>