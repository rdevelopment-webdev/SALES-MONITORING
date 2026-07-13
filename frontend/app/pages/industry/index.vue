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

    <div class="px-4 py-2 flex items-center justify-between shrink-0">
      <h1 class="font-bold text-[16px] tracking-tight">
        Industry – Leads listing
      </h1>
      <button
        @click="openArchiveModal"
        class="bg-[#1F2835] hover:bg-black text-white px-2.5 py-[3px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
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
      </button>
    </div>

    <div
      class="px-4 py-1.5 flex items-center justify-between gap-2 shrink-0 bg-white border-b border-gray-200"
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
        <button
          v-if="selectedIds.length > 0"
          @click="archiveSelectedRecords"
          class="bg-amber-600 hover:bg-amber-700 text-white px-2.5 py-[3px] rounded-[4px] text-[11px] font-medium transition-colors flex items-center gap-1"
        >
          Archive Selected ({{ selectedIds.length }})
        </button>

        <div class="relative">
          <button
            @click="showDatePicker = !showDatePicker"
            class="bg-white border border-gray-300 px-2.5 py-[3px] rounded-[4px] text-[11px] flex items-center gap-1.5 text-[#1F2835] hover:border-gray-400 transition-colors"
          >
            {{ selectedDate || "Select Date" }}
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
            class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 p-3 w-64"
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
                    ? 'bg-[#F52C11] text-white'
                    : day.date
                    ? 'hover:bg-gray-100'
                    : 'cursor-default',
                ]"
              >
                {{ day.day }}
              </button>
            </div>
            <button
              v-if="selectedDate"
              @click="selectDate('')"
              class="w-full mt-2 text-center text-[10px] text-red-500 hover:underline"
            >
              Clear Date Filter
            </button>
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
                : 'text-[#1F2835] hover:bg-gray-50',
            ]"
            class="px-2.5 py-2 text-[12px] cursor-pointer transition-all flex items-center justify-between group border-b border-gray-100"
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
                  Rename
                </button>
                <button
                  @click.stop="archiveIndustry(industry)"
                  class="w-full text-left px-3 py-1.5 text-[11px] text-red-500 hover:bg-red-50 transition-colors flex items-center gap-1.5"
                >
                  Archive
                </button>
              </div>
            </div>
          </div>
        </div>
      </aside>

      <section
        class="flex-1 flex flex-col min-w-0 bg-white border border-gray-200 overflow-hidden relative"
      >
        <div
          class="flex items-center justify-between px-2 py-1 border-b border-gray-100 shrink-0 bg-gray-50"
        >
          <span class="text-[11px] text-gray-500">
            <span v-if="filteredRecords.length > 0"
              >Showing {{ paginationStart }}–{{ paginationEnd }}</span
            >
            <span v-else>Showing 0</span>
            <span class="mx-1 text-gray-300">|</span>
            {{ filteredRecords.length }} total records
          </span>

          <div class="flex items-center gap-2">
            <div class="flex items-center gap-1">
              <span class="text-[11px] text-gray-500">Rows per page</span>
              <select
                v-model.number="pageSize"
                class="bg-white border border-gray-300 rounded-[4px] text-[11px] px-1.5 py-[1px] focus:outline-none focus:border-[#F52C11]"
              >
                <option :value="10">10</option>
                <option :value="25">25</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
              </select>
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
                  class="w-8 px-2 py-1.5 border-r border-gray-200 text-center text-[10px] text-gray-400"
                >
                  #
                </th>
                <th
                  class="w-6 px-2 py-1.5 border-r border-gray-200 text-center"
                >
                  <input
                    type="checkbox"
                    :checked="isAllSelected"
                    @change="toggleAll"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  />
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Date
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Business Name
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Contact Person
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Job Position
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Contact No.
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Email
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Service
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Status
                </th>
                <th
                  class="px-3 py-1.5 border-r border-gray-200 font-semibold text-[#F52C11] whitespace-nowrap"
                >
                  Remarks
                </th>
                <th
                  class="px-3 py-1.5 font-semibold text-[#F52C11] sticky right-0 z-30 bg-[#f2f2f2] shadow-[-2px_0_4px_rgba(0,0,0,0.05)] text-center"
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
                    : 'bg-white hover:bg-gray-50',
                ]"
                class="transition-colors border-b border-gray-100"
              >
                <td
                  class="px-2 py-1 border-r border-gray-100 text-center text-[11px] text-gray-400"
                >
                  {{ paginationStart + recordIndex }}
                </td>
                <td class="px-2 py-1 border-r border-gray-100 text-center">
                  <input
                    type="checkbox"
                    :checked="isSelected(record.id)"
                    @change="toggleSelection(record.id)"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  />
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap text-[11px]"
                >
                  {{ record.date }}
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap font-bold text-slate-800"
                >
                  {{ record.businessName }}
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap"
                >
                  {{ record.contactPerson }}
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap"
                >
                  {{ record.jobPosition }}
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap text-slate-600"
                >
                  {{ record.contactNo }}
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap text-gray-600"
                >
                  {{ record.email }}
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap text-[11px]"
                >
                  {{ record.service }}
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 whitespace-nowrap"
                >
                  <div class="flex items-center gap-1.5 min-w-[85px]">
                    <div
                      class="flex-1 h-[4px] bg-gray-200 rounded-full overflow-hidden"
                    >
                      <div
                        class="h-full rounded-full transition-all duration-500"
                        :class="getStatusBarColor(record.status)"
                        :style="{ width: record.statusPercent + '%' }"
                      ></div>
                    </div>
                    <span
                      :class="getStatusTextColor(record.status)"
                      class="text-[10px] font-bold shrink-0 w-8 text-right"
                      >{{ record.statusPercent }}%</span
                    >
                  </div>
                </td>
                <td
                  class="px-3 py-1 border-r border-gray-100 max-w-[200px] truncate text-gray-600"
                  :title="record.remarks"
                >
                  {{ record.remarks || "-" }}
                </td>
                <td
                  class="px-3 py-1 sticky right-0 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] text-center"
                  :class="
                    isSelected(record.id)
                      ? 'bg-amber-50'
                      : 'bg-white group-hover:bg-gray-50'
                  "
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
                    <button
                      @click="archiveSingleRecord(record.id)"
                      class="text-gray-400 hover:text-amber-600"
                      title="Archive row"
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
                          d="M5 8h14M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                        />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div
          class="px-3 py-1.5 border-t border-gray-200 flex items-center justify-between shrink-0 bg-gray-50 text-[11px]"
        >
          <div class="flex items-center gap-1.5">
            <span class="text-gray-500">Go to page</span>
            <input
              v-model="goToPageInput"
              type="text"
              inputmode="numeric"
              :placeholder="String(currentPage)"
              class="w-12 text-center bg-white border border-gray-300 rounded-[4px] px-1 py-[2px] focus:outline-none focus:border-[#F52C11]"
              @keyup.enter="handleGoToPage"
            />
            <button
              @click="handleGoToPage"
              class="px-2 py-[2px] rounded-[4px] bg-gray-200 hover:bg-gray-300 transition-colors font-medium"
            >
              Go
            </button>
          </div>

          <div class="flex items-center gap-1">
            <button
              @click="goToPage(currentPage - 1)"
              :disabled="currentPage === 1"
              :class="
                currentPage === 1
                  ? 'text-gray-300 cursor-not-allowed'
                  : 'text-[#1F2835] hover:bg-gray-200'
              "
              class="w-6 h-6 rounded-[4px] flex items-center justify-center transition-colors"
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
                  d="M15 19l-7-7 7-7"
                />
              </svg>
            </button>
            <button
              v-for="page in paginationPages"
              :key="page.key"
              @click="typeof page.value === 'number' && goToPage(page.value)"
              :disabled="page.value === '...'"
              :class="[
                page.value === currentPage
                  ? 'bg-[#F52C11] text-white font-bold'
                  : page.value === '...'
                  ? 'cursor-default text-gray-400'
                  : 'hover:bg-gray-200 text-slate-700',
              ]"
              class="min-w-[24px] h-6 px-1 rounded-[4px] flex items-center justify-center text-[11px] transition-colors"
            >
              {{ page.value }}
            </button>
            <button
              @click="goToPage(currentPage + 1)"
              :disabled="currentPage === totalPages"
              :class="
                currentPage === totalPages
                  ? 'text-gray-300 cursor-not-allowed'
                  : 'text-[#1F2835] hover:bg-gray-200'
              "
              class="w-6 h-6 rounded-[4px] flex items-center justify-center transition-colors"
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
        class="bg-white rounded-[8px] w-[560px] shadow-xl flex flex-col overflow-hidden max-h-[80vh]"
      >
        <div
          class="flex items-center justify-between px-4 py-2.5 border-b border-gray-200 bg-slate-50"
        >
          <span class="font-bold text-[13px]"
            >Archived Records Database Log</span
          >
          <button
            @click="showArchiveModal = false"
            class="text-gray-400 hover:text-slate-700"
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

        <div
          class="px-4 py-2 border-b border-gray-100 flex items-center justify-between bg-white shrink-0"
        >
          <div class="flex gap-2">
            <button
              @click="archiveTab = 'industries'"
              :class="
                archiveTab === 'industries'
                  ? 'border-[#F52C11] text-[#F52C11] font-semibold'
                  : 'border-transparent text-gray-500'
              "
              class="border-b-2 px-1 py-1 text-[11px] transition-all"
            >
              Industries
            </button>
            <button
              @click="archiveTab = 'records'"
              :class="
                archiveTab === 'records'
                  ? 'border-[#F52C11] text-[#F52C11] font-semibold'
                  : 'border-transparent text-gray-500'
              "
              class="border-b-2 px-1 py-1 text-[11px] transition-all"
            >
              Leads Records
            </button>
          </div>
          <input
            v-model="archiveSearchQuery"
            type="text"
            placeholder="Filter archived data entries..."
            class="border border-gray-300 rounded-[4px] px-2 py-0.5 text-[11px] w-48 focus:outline-none focus:border-[#F52C11]"
          />
        </div>

        <div
          class="flex-1 overflow-y-auto p-4 custom-scroll space-y-2 bg-slate-50 min-h-[200px]"
        >
          <div
            v-if="isLoadingArchive"
            class="text-center text-gray-400 py-10 text-[11px]"
          >
            Loading system archive indices...
          </div>

          <template v-else-if="archiveTab === 'industries'">
            <div
              v-if="filteredArchivedIndustries.length === 0"
              class="text-center text-gray-400 py-10 text-[11px]"
            >
              No matching archived industries found.
            </div>
            <div
              v-for="ind in filteredArchivedIndustries"
              :key="ind"
              class="flex items-center justify-between p-2 bg-white rounded border border-gray-200 text-[12px]"
            >
              <span class="font-medium text-slate-700">{{ ind }}</span>
              <button
                @click="restoreIndustry(ind)"
                class="text-[11px] text-[#F52C11] hover:underline font-semibold"
              >
                Restore
              </button>
            </div>
          </template>

          <template v-else>
            <div
              v-if="filteredArchivedRecords.length === 0"
              class="text-center text-gray-400 py-10 text-[11px]"
            >
              No matching archived lead records found.
            </div>
            <div
              v-for="rec in filteredArchivedRecords"
              :key="rec.id"
              class="flex items-center justify-between p-2.5 bg-white rounded border border-gray-200 text-[12px]"
            >
              <div>
                <div class="font-bold text-slate-800">
                  {{ rec.businessName }}
                </div>
                <div class="text-[10px] text-gray-400 mt-0.5">
                  {{ rec.service }} • {{ rec.date }}
                </div>
              </div>
              <div class="flex gap-3">
                <button
                  @click="restoreRecord(rec.id)"
                  class="text-[11px] text-[#F52C11] hover:underline font-medium"
                >
                  Restore
                </button>
                <button
                  @click="permanentDeleteRecord(rec.id)"
                  class="text-[11px] text-red-500 hover:underline font-medium"
                >
                  Delete
                </button>
              </div>
            </div>
          </template>
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
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import EditRecordModal from "./edit.vue";
import ViewRecordModal from "./view.vue";
import { useApi } from "~/composables/useApi";
import { useAuditLog } from "~/composables/useAuditLog";

definePageMeta({
  layout: "app",
  middleware: "auth",
});

const route = useRoute();
const router = useRouter();
const { apiFetch } = useApi();
const { logAuditAction } = useAuditLog();

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
const archiveTab = ref("industries");

// Loading Indicators
const isSubmittingIndustry = ref(false);
const isLoadingIndustries = ref(false);
const isLoadingRecords = ref(false);
const isLoadingArchive = ref(false);

// Pagination Elements
const currentPage = ref(1);
const pageSize = ref(10);
const goToPageInput = ref("");

// Internal Custom Calendar Core Configurations
const currentMonth = ref(new Date().getMonth());
const currentYear = ref(new Date().getFullYear());

const serviceOptions = ref([
  "All Services",
  "Web Development",
  "Mobile App Development",
  "SEO / Digital Marketing",
  "Graphic Design",
  "UI/UX Consulting",
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
  };
}

function normalizeIndustry(raw) {
  if (!raw) return null;
  return {
    id: raw.id,
    name: raw.industry_name || raw.name || "",
  };
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
    archivedIndustries.value = parsed.map((i) => i.name);
    parsed.forEach((i) => {
      if (i.id && i.name) industryIdByName.value[i.name] = i.id;
    });
  } catch (err) {
    console.warn("Could not query archived industries:", err);
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
  } finally {
    isLoadingRecords.value = false;
  }
}

async function fetchArchive() {
  isLoadingArchive.value = true;
  try {
    const response = await apiFetch("/leads/archived", {
      query: { location: selectedLocation.value },
    });
    const data = payloadData(response);
    archivedRecords.value = Array.isArray(data)
      ? data.map(normalizeRecord)
      : [];
  } catch (err) {
    console.warn("Archive logs lookup execution exception:", err);
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
  } catch (err) {
    addIndustryError.value =
      err.message || "Failed to commit record mutation changes.";
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
      } catch (err) {
        console.error("Renaming industry entity node pipeline error:", err);
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
  } catch (err) {
    console.error("Failed to archive workspace dynamic link layer:", err);
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
  } catch (err) {
    console.error("Restoring targeted industry row sequence exception:", err);
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
  } catch (err) {
    console.error("Archive lead conversion mapping runtime error:", err);
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

    selectedIds.value = [];
  } catch (err) {
    console.error(
      "Bulk archive update transaction exception pipeline error:",
      err
    );
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
  } catch (err) {
    console.error("Re-routing dynamic trace records restoration error:", err);
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
  } catch (err) {
    console.error(
      "Purging storage reference transaction rejection error:",
      err
    );
  }
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

const totalPages = computed(
  () => Math.ceil(filteredRecords.value.length / pageSize.value) || 1
);
const paginationStart = computed(() =>
  filteredRecords.value.length === 0
    ? 0
    : (currentPage.value - 1) * pageSize.value + 1
);
const paginationEnd = computed(() =>
  Math.min(currentPage.value * pageSize.value, filteredRecords.value.length)
);

const paginatedRecords = computed(() => {
  const start = (currentPage.value - 1) * pageSize.value;
  return filteredRecords.value.slice(start, start + pageSize.value);
});

const paginationPages = computed(() => {
  const total = totalPages.value;
  const current = currentPage.value;
  const pages = [];
  const pushPage = (value) =>
    pages.push({ key: `${value}-${pages.length}`, value });

  if (total <= 7) {
    for (let i = 1; i <= total; i++) pushPage(i);
    return pages;
  }
  pushPage(1);
  if (current > 3) pushPage("...");
  const rangeStart = Math.max(2, current - 1);
  const rangeEnd = Math.min(total - 1, current + 1);
  for (let i = rangeStart; i <= rangeEnd; i++) pushPage(i);
  if (current < total - 2) pushPage("...");
  pushPage(total);
  return pages;
});

const filteredArchivedIndustries = computed(() => {
  const q = archiveSearchQuery.value.trim().toLowerCase();
  if (!q) return archivedIndustries.value;
  return archivedIndustries.value.filter((i) => i.toLowerCase().includes(q));
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

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) currentPage.value = page;
}

function handleGoToPage() {
  const page = parseInt(goToPageInput.value, 10);
  if (!isNaN(page)) goToPage(Math.min(Math.max(page, 1), totalPages.value));
  goToPageInput.value = "";
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
  currentPage.value = 1;
  await fetchRecords();
}

async function openArchiveModal() {
  showArchiveModal.value = true;
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

const calendarDays = computed(() => {
  const startDay = new Date(currentYear.value, currentMonth.value, 1).getDay();
  const daysInMonth = new Date(
    currentYear.value,
    currentMonth.value + 1,
    0
  ).getDate();
  const days = [];

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
const getStatusBarColor = (status) => {
  const map = {
    Client: "bg-[#639922]",
    Called: "bg-[#fa6f10]",
    Prospect: "bg-[#888780]",
    Emailed: "bg-[#378add]",
    Rejected: "bg-[#e24b4a]",
  };
  return map[status] || "bg-gray-400";
};

const getStatusTextColor = (status) => {
  const map = {
    Client: "text-[#639922]",
    Called: "text-[#fa6f10]",
    Prospect: "text-[#888780]",
    Emailed: "text-[#378add]",
    Rejected: "text-[#e24b4a]",
  };
  return map[status] || "text-gray-500";
};

/* ---------------------------------------------------------------------- */
/* Live Application Mounting Hook System Lifecycle Step */
/* ---------------------------------------------------------------------- */
onMounted(async () => {
  if (route.query.location) selectedLocation.value = route.query.location;
  isLoadingIndustries.value = true;
  await fetchIndustries();
  await fetchArchivedIndustries();
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
    currentPage.value = 1;
    fetchRecords();
  }
);

watch(pageSize, () => {
  currentPage.value = 1;
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

.custom-scroll::-webkit-scrollbar {
  width: 4px;
  height: 4px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: rgba(31, 40, 53, 0.2);
  border-radius: 10px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: rgba(245, 44, 17, 0.4);
}
</style>
