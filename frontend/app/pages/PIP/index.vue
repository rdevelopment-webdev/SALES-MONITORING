<template>
  <template v-if="canView">
    <div
      class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#f0f0f0] font-['Overpass'] text-[14px] text-[#1F2835]"
    >
      <!-- Top Header: Breadcrumb -->
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
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
            />
          </svg>
          <span class="cursor-pointer transition-colors">Leads Tracker</span>
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
              d="M9 5l7 7-7 7"
            />
          </svg>
          <span class="text-[#f52c11] font-medium">PIP</span>
        </div>
      </div>

      <!-- Title + Search + View Archive -->
      <div class="px-4 py-0.5 flex items-center justify-between gap-4 shrink-0">
        <h1 class="font-bold text-[16px] tracking-tight whitespace-nowrap">
          PIP
        </h1>

        <div class="flex items-center gap-1.5">
          <button
            @click="
              showArchiveModal = true;
              fetchArchivedRecords();
            "
            class="relative bg-white border border-gray-300 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-3 py-[4px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
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
                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
              />
            </svg>
            View archive
            <span
              v-if="archivedRecords.length > 0"
              class="absolute -top-1.5 -right-1.5 min-w-[16px] h-[16px] px-1 flex items-center justify-center rounded-full bg-[#F52C11] text-white text-[9px] font-bold leading-none"
            >
              {{ archivedRecords.length > 99 ? "99+" : archivedRecords.length }}
            </span>
          </button>
        </div>
      </div>

      <!-- Filters Row (Date + Services) - COPIED FROM LEADS -->
      <div class="px-4 py-1 flex items-center justify-between gap-2 shrink-0">
        <!-- Left: Search moved here per image -->
        <div class="flex items-center gap-1.5">
          <div class="relative flex items-center">
            <svg
              class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-[4px] pointer-events-none"
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
              placeholder="Search..."
              class="pl-7 pr-2 py-[2px] w-48 bg-white border border-gray-300 rounded-[4px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
            />
          </div>
        </div>

        <!-- Right: Date, Services -->
        <div class="flex items-center gap-1.5">
          <!-- Date Picker -->
          <div class="relative">
            <button
              @click="showDatePicker = !showDatePicker"
              class="bg-white border border-gray-300 px-2.5 py-[3px] rounded-[4px] text-[11px] flex items-center gap-1.5 text-[#1F2835] hover:border-gray-400 transition-colors"
            >
              <span>{{ selectedDate || "Select Date" }}</span>
              <svg
                class="w-4 h-4 text-[#F52C11] shrink-0"
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
                  v-for="day in calendarDays.filter((d) => d.isCurrentMonth)"
                  :key="day.date"
                  @click="selectDate(day.date)"
                  :class="[
                    'w-7 h-7 rounded-[4px] text-[11px] flex items-center justify-center transition-colors',
                    day.isCurrentMonth ? 'text-[#1F2835]' : 'text-gray-300',
                    day.isSelected
                      ? 'bg-[#F52C11] text-white font-semibold'
                      : day.isToday
                      ? 'border border-[#F52C11] text-[#F52C11] font-semibold'
                      : 'hover:bg-gray-100',
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

          <!-- Services Dropdown -->
          <div class="relative">
            <button
              @click="showServicesDropdown = !showServicesDropdown"
              :class="
                selectedService !== 'All Services'
                  ? 'border-[#F52C11] text-[#F52C11]'
                  : 'border-gray-300 text-[#1F2835]'
              "
              class="bg-white border px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-1 hover:border-gray-400 transition-colors"
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

      <!-- Main Content: Table Section -->
      <main
        class="flex-1 flex pt-0.5 px-2.5 pb-2.5 gap-1.5 min-h-0 overflow-hidden"
      >
        <section
          class="flex-1 flex flex-col min-w-2 bg-white overflow-hidden relative rounded-[6px]"
        >
          <!-- Table Header Info -->
          <div
            class="flex items-center justify-between px-2 py-[3px] border-b border-gray-100 shrink-0"
          >
            <div class="flex items-center gap-3">
              <span class="text-[11px] text-gray-500 font-medium"
                >Showing {{ recordsRangeStart }}-{{ recordsRangeEnd }}</span
              >
              <span class="text-[11px] text-gray-400"
                >{{ filteredRecords.length }} total records</span
              >
            </div>

            <div class="flex items-center gap-2">
              <div class="flex items-center gap-1.5">
                <span class="text-[10px] text-gray-500">Rows per page</span>
                <div class="relative">
                  <select
                    v-model.number="recordsRowsPerPage"
                    class="bg-white border border-gray-300 rounded-[4px] pl-2 pr-6 py-[3px] text-[10px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] appearance-none cursor-pointer"
                  >
                    <option
                      v-for="option in rowsPerPageOptions"
                      :key="option"
                      :value="option"
                    >
                      {{ option }}
                    </option>
                  </select>
                  <svg
                    class="w-2.5 h-2.5 text-[#F52C11] absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none"
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
                  v-if="canAdd"
                  @click="openAddRecordModal"
                  class="bg-white hover:bg-gray-50 border border-gray-300 text-[#1F2835] px-3 py-[4px] rounded-[4px] text-[11px] font-medium flex items-center gap-1.5 transition-colors"
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
                  Add record
                </button>
              </div>
            </div>
          </div>

          <!-- Loading State -->
          <div v-if="isLoading" class="flex-1 flex items-center justify-center">
            <div class="text-gray-400 text-[12px]">Loading records...</div>
          </div>

          <!-- Table -->
          <div v-else class="flex-1 overflow-auto custom-scroll relative">
            <table class="w-full border-collapse text-left">
              <thead
                class="bg-gray-50 border-b border-gray-200 sticky top-0 z-20"
              >
                <tr class="border-b border-gray-200">
                  <th
                    class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11] w-8 text-center"
                  ></th>
                  <th v-if="canEdit" class="w-6 px-1.5 py-[3px] text-center">
                    <input
                      type="checkbox"
                      :checked="isAllSelected"
                      @change="toggleAll"
                      class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                    />
                  </th>
                  <th
                    class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                  >
                    Date Recorded
                  </th>
                  <th
                    class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                  >
                    Client Name
                  </th>
                  <th
                    class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                  >
                    Service
                  </th>
                  <th
                    class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                  >
                    Onboarding Date
                  </th>
                  <th
                    class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11]"
                  >
                    Status
                  </th>
                  <th
                    class="px-2 py-[3px] font-semibold text-[11px] whitespace-nowrap text-[#F52C11] sticky right-0 z-30 bg-gray-50 shadow-[-2px_0_4px_rgba(0,0,0,0.05)]"
                  >
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  <tr
                  v-for="(record, index) in paginatedRecords"
                  :key="record.id"
                  class="transition-colors"
                  :class="{
                    'bg-[#F52C11]/15': isSelected(record.id),
                    'bg-white hover:bg-[#F52C11]/10': !isSelected(record.id),
                    'border-b border-gray-100':
                      index !== paginatedRecords.length - 1,
                  }"
                >
                  <!-- COUNT NUMBER CELL (moved before checkbox) -->
                  <td
                    class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-gray-500 text-center w-8"
                  >
                    {{
                      (recordsCurrentPage - 1) * recordsRowsPerPage + index + 1
                    }}
                  </td>
                  <td v-if="canEdit" class="px-1.5 py-[3px] text-center">
                    <input
                      type="checkbox"
                      :checked="isSelected(record.id)"
                      @change="toggleSelection(record.id)"
                      class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                    />
                  </td>
                  <td
                    class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]"
                  >
                    {{ record.dateRecorded }}
                  </td>
                  <td
                    class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]"
                  >
                    {{ record.clientName }}
                  </td>
                  <td
                    class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]"
                  >
                    {{ record.service }}
                  </td>
                  <td
                    class="px-2 py-[3px] whitespace-nowrap text-[11px] font-medium text-[#1F2835]"
                  >
                    {{ record.onboardingDate }}
                  </td>
                  <td class="px-2 py-[3px] whitespace-nowrap">
                    <div class="flex items-center gap-2">
                      <div
                        class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden"
                      >
                        <div
                          class="h-full rounded-full"
                          :style="{
                            width: record.status + '%',
                            backgroundColor: getStatusColor(record.status),
                          }"
                        ></div>
                      </div>
                      <span
                        class="text-[10px] font-semibold"
                        :style="{ color: getStatusColor(record.status) }"
                        >{{ record.status }}%</span
                      >
                    </div>
                  </td>
                  <td
                    class="px-2 py-[3px] whitespace-nowrap sticky right-0 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] transition-colors"
                    :class="
                      isSelected(record.id)
                        ? 'bg-[#F52C11]/0'
                        : 'bg-white hover:bg-[#F52C11]/0'
                    "
                  >
                    <div class="flex items-center gap-1.5">
                      <button
                        @click="openViewModal(record)"
                        class="text-gray-400 hover:text-[#F52C11] transition-colors"
                        title="View"
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
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                          />
                        </svg>
                      </button>

                      <button
                        v-if="canEdit"
                        @click="openEditModal(record)"
                        class="text-gray-400 hover:text-[#F52C11] transition-colors"
                        title="Edit"
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                          />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr v-if="paginatedRecords.length === 0">
                  <td
                    :colspan="canEdit ? 8 : 7"
                    class="px-4 py-12 text-center text-gray-400"
                  >
                    <div v-if="searchQuery">
                      No records found matching "<span
                        class="font-semibold text-[#1F2835]"
                        >{{ searchQuery }}</span
                      >"
                    </div>
                    <div v-else>No records available</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Archive Selected Bar -->
          <div
            v-if="canEdit && selectedCount > 0"
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
                >{{ selectedCount }} record(s) selected</span
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
          <!-- Pagination Footer - COPIED FROM LEADS -->
          <div
            class="shrink-0 bg-[#f0f0f0] px-2.5 py-1 flex items-center justify-between gap-2 flex-wrap"
          >
            <!-- Page X of Y -->
            <span class="text-[11px] text-gray-500"
              >Page {{ recordsCurrentPage }} of {{ totalRecordsPages }}</span
            >

            <!-- Go to page -->
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

            <!-- Page numbers -->
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

      <!-- View Archive Modal -->
      <div
        v-if="showArchiveModal"
        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
      >
        <div
          class="bg-white rounded-[12px] w-[800px] h-[550px] shadow-xl flex flex-col overflow-hidden"
        >
          <!-- Header -->
          <div
            class="flex items-center justify-between px-5 py-2 border-b border-gray-100 bg-white shrink-0"
          >
            <div class="flex items-center gap-2">
              <div
                class="w-7 h-7 rounded-[6px] bg-[#F52C11]/10 flex items-center justify-center"
              >
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
                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                  />
                </svg>
              </div>
              <div>
                <h3 class="text-[13px] font-bold text-[#1F2835]">
                  Archived items
                </h3>
                <p class="text-[9px] text-gray-400">
                  Performance Improvement Plan page
                </p>
              </div>
            </div>
            <button
              @click="closeArchiveModal"
              class="text-gray-400 hover:text-[#1F2835] transition-colors"
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

          <!-- Body -->
          <div class="flex-1 overflow-auto custom-scroll p-3">
            <!-- Archived Tabs -->
            <div class="flex items-center gap-4 border-b border-gray-200 mb-2">
              <button
                class="pb-1.5 border-b-2 border-[#F52C11] text-[11px] font-semibold text-[#F52C11] flex items-center gap-1.5"
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
                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                  />
                </svg>
                Archived records
                <span
                  class="bg-[#F52C11]/10 text-[#1F2835] text-[9px] px-1.5 py-[1px] rounded-full font-semibold"
                  >{{ archivedRecords.length }}</span
                >
              </button>
            </div>

            <!-- Search archived -->
            <div class="relative mb-2">
              <svg
                class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-[3px] pointer-events-none"
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
                v-model="archivedSearchQuery"
                type="text"
                placeholder="Search archived record..."
                class="pl-7 pr-2 py-[2px] w-full bg-white border border-gray-300 rounded-[6px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
              />
            </div>

            <!-- Loading -->
            <div v-if="isArchiveLoading" class="text-center py-8">
              <div class="text-gray-400 text-[12px]">
                Loading archived items...
              </div>
            </div>

            <!-- Empty -->
            <div
              v-else-if="filteredArchivedRecords.length === 0"
              class="text-center py-8"
            >
              <svg
                class="w-8 h-8 mx-auto mb-2 text-gray-300"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                />
              </svg>
              <p class="text-[12px] text-gray-400">No archived items</p>
            </div>

            <!-- Card List -->
            <div v-else class="space-y-2">
              <div
                v-for="record in filteredArchivedRecords"
                :key="record.id"
                class="flex items-center gap-3 p-1 bg-white rounded-[8px] border border-gray-200 hover:border-gray-300 transition-colors"
              >
                <!-- Checkbox -->
                <div v-if="canEdit" class="flex items-center justify-center">
                  <input
                    type="checkbox"
                    :checked="isArchivedSelected(record.id)"
                    @change="toggleArchivedSelection(record.id)"
                    class="w-3 h-3 rounded border-gray-200 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer accent-[#F52C11]"
                  />
                </div>

<!-- Two-Building / Skyline Icon in Gray Square -->
<div
  class="w-10 h-10 rounded-[12px] bg-gray-100 flex items-center justify-center flex-shrink-0"
>
  <svg
    class="w-4 h-4 text-gray-500"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
    viewBox="0 0 24 24"
  >
    <!-- Left building (taller) -->
    <path d="M7 21V9l4-2v14" />
    <!-- Right building (shorter) -->
    <path d="M11 21V13l4-2v10" />
    <!-- Base line -->
    <path d="M5 21h14" />
  </svg>
</div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                  <div class="text-[12px] font-semibold text-[#1F2835]">
                    {{ record.clientName }}
                  </div>
                  <div
                    class="flex items-center gap-1.5 text-[10px] text-gray-500 mt-0.5"
                  >
                    <span>Davao</span>
                    <span>•</span>
                    <span>Archived {{ record.dateArchived }}</span>
                    <span
                      class="inline-flex items-center px-1.5 py-[1px] rounded-[4px] bg-[#E8F4FD] text-[#1F2835] text-[9px] font-medium"
                    >
                      {{ record.service }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Bulk Actions Bar -->
          <div
            v-if="canEdit && archivedSelectedCount > 0"
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
              <span class="font-medium"
                >{{ archivedSelectedCount }} record(s) selected</span
              >
              <span v-if="archiveDeleteError" class="text-[#F52C11] ml-2">{{
                archiveDeleteError
              }}</span>
            </div>
            <div class="flex items-center gap-2">
              <!-- Select All Button -->
              <button
                @click="toggleAllArchived"
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
                @click="restoreSelectedArchivedRecords"
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
                @click="deleteSelectedArchivedRecords"
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

          <!-- Footer -->
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
              Restoring moves the record back to its active list
            </div>
            <button
              @click="closeArchiveModal"
              class="px-3 py-[4px] rounded-[6px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
            >
              Close
            </button>
          </div>
        </div>
      </div>

      <!-- Edit Record Modal -->
      <EditRecordModal
        v-if="showAddEditModal"
        :record="editingRecord"
        :prospect-technique-options="lookups.techniques"
        :sales-rep-options="lookups.salesReps"
        :communication-options="lookups.communications"
        :service-options="lookups.services"
        :status-options="lookups.statuses"
        :save-error="saveError"
        @close="closeAddEditModal"
        @save="handleEditSave"
      />

      <!-- View Record Modal -->
      <ViewRecordModal
        v-if="showViewModal"
        :record="viewingRecord"
        @close="closeViewModal"
      />

      <!-- Click outside to close dropdowns -->
      <div
        v-if="showDatePicker || showServicesDropdown"
        class="fixed inset-0 z-40"
        @click="closeAllDropdowns"
      ></div>
    </div>
  </template>

  <template v-else>
    <div
      class="flex items-center justify-center h-screen bg-[#f0f0f0] font-['Overpass'] text-[13px] text-gray-400"
    >
      {{
        permissionsLoading
          ? "Checking permissions..."
          : "You don't have permission to view this page."
      }}
    </div>
  </template>
</template>

<script setup>
definePageMeta({
  layout: "app",
  middleware: "auth",
});

import { ref, computed, watch, onMounted } from "vue";
import EditRecordModal from "./edit.vue";
import ViewRecordModal from "./view.vue";
import * as api from "./api.js";
import { useAuditLog } from "~/composables/useAuditLog";
import { useToast } from "~/composables/useToast";
import { usePermissions } from "~/composables/usePermissions";

// useRuntimeConfig() is auto-imported by Nuxt.
//
// NOTE: this app's login page (login.vue) does NOT use @sidebase/nuxt-auth's
// signIn() — it calls a custom useApi()/apiFetch() composable and then does
// localStorage.setItem('token', ...) / localStorage.setItem('user', ...)
// itself. That means useAuth()'s session (data/token) is never populated and
// is unrelated to how this app actually authenticates. So instead of
// useAuth(), we read the token/user from the same localStorage keys
// login.vue writes to.
const route = useRoute();
const router = useRouter();
const runtimeConfig = useRuntimeConfig();
api.configureApi({
  baseURL: runtimeConfig.public.apiBase,
  getToken: () =>
    typeof localStorage !== "undefined" ? localStorage.getItem("token") : null,
});

// ==================== STATE ====================
const searchQuery = ref("");
const selectedIds = ref([]);
const showArchiveModal = ref(false);
const showAddEditModal = ref(false);
const showViewModal = ref(false);
const isLoading = ref(false);
const viewingRecord = ref(null);
const editingRecord = ref(null);
const saveError = ref(""); // error message shown inside Create/Edit modal on a failed save
const archiveActionError = ref(""); // error message shown when archive/unarchive fails
const archiveDeleteError = ref(""); // error message shown when deleting archived records fails

// ==================== ARCHIVED SEARCH & LOADING ====================
const archivedSearchQuery = ref("");
const isArchiveLoading = ref(false);

// ==================== FILTERED ARCHIVED RECORDS ====================
const filteredArchivedRecords = computed(() => {
  let result = [...archivedRecords.value];

  const q = archivedSearchQuery.value.trim().toLowerCase();
  if (q) {
    result = result.filter(
      (r) =>
        r.clientName?.toLowerCase().includes(q) ||
        r.service?.toLowerCase().includes(q) ||
        r.dateRecorded?.toLowerCase().includes(q)
    );
  }

  return result;
});

// ==================== ARCHIVED SELECTION STATE ====================
const archivedSelectedIds = ref([]);

// ==================== ARCHIVED COMPUTED ====================
const archivedSelectedCount = computed(() => archivedSelectedIds.value.length);

const isArchivedAllSelected = computed(() => {
  if (filteredArchivedRecords.value.length === 0) return false;
  return filteredArchivedRecords.value.every((r) =>
    archivedSelectedIds.value.includes(r.id)
  );
});

// ==================== ARCHIVED SELECTION METHODS ====================
function isArchivedSelected(id) {
  return archivedSelectedIds.value.includes(id);
}

function toggleArchivedSelection(id) {
  if (!canEdit.value) return;
  const idx = archivedSelectedIds.value.indexOf(id);
  if (idx > -1) {
    archivedSelectedIds.value.splice(idx, 1);
  } else {
    archivedSelectedIds.value.push(id);
  }
}

function toggleAllArchived() {
  if (!canEdit.value) return;
  const visibleIds = filteredArchivedRecords.value.map((r) => r.id);

  const allVisibleSelected = visibleIds.every((id) =>
    archivedSelectedIds.value.includes(id)
  );

  if (allVisibleSelected) {
    archivedSelectedIds.value = archivedSelectedIds.value.filter(
      (id) => !visibleIds.includes(id)
    );
  } else {
    const newIds = visibleIds.filter(
      (id) => !archivedSelectedIds.value.includes(id)
    );
    archivedSelectedIds.value.push(...newIds);
  }
}

// Clear archived selection when modal closes or search changes
watch(showArchiveModal, (val) => {
  if (!val) archivedSelectedIds.value = [];
});
watch(archivedSearchQuery, () => {
  archivedSelectedIds.value = [];
});
// Backend lookups (populated on mount) + current logged-in user
// (currentUser is read from localStorage — see loadCurrentUser() below —
// since that's where login.vue actually stores it after a successful login)
const currentUser = ref(null);
const { logAuditAction } = useAuditLog();
const toast = useToast();
const {
  ready: permissionsReady,
  isLoading: permissionsLoading,
  canView,
  canEdit,
  canAdd,
} = usePermissions("performance-improvement-plan");
const lookups = ref({
  statuses: [],
  techniques: [],
  salesReps: [],
  services: [],
  communications: [],
});

// Date & Services filter state - COPIED FROM LEADS
const selectedDate = ref("");
const selectedService = ref("All Services");
const showDatePicker = ref(false);
const showServicesDropdown = ref(false);

// Service options - COPIED FROM LEADS
const serviceOptions = ref([
  "All Services",
  "Website Development",
  "Custom Software",
  "Mobile Application",
  "Digital Marketing",
  "Multimedia",
  "Hosting & Server",
]);

// Empty arrays — backend will populate these
const records = ref([]);
const archivedRecords = ref([]);

// Normalizes any reasonable date string ("2026-07-16", "7/16/2026",
// "July 16, 2026", "07/16/26", etc.) into the same MM/DD/YY shape
// selectDate() produces, so the filter comparison actually matches.
function toComparableDate(dateStr) {
  if (!dateStr) return "";

  // Already MM/DD/YY or M/D/YYYY etc.
  const mdy = /^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/.exec(dateStr);
  if (mdy) {
    let [, m, d, y] = mdy;
    if (y.length === 4) y = y.slice(-2);
    return `${m.padStart(2, "0")}/${d.padStart(2, "0")}/${y}`;
  }

  // ISO: YYYY-MM-DD
  const iso = /^(\d{4})-(\d{2})-(\d{2})/.exec(dateStr);
  if (iso) {
    const [, y, m, d] = iso;
    return `${m}/${d}/${y.slice(-2)}`;
  }

  // Fallback: let Date try to parse it
  const parsed = new Date(dateStr);
  if (!isNaN(parsed)) {
    return `${String(parsed.getMonth() + 1).padStart(2, "0")}/${String(
      parsed.getDate()
    ).padStart(2, "0")}/${String(parsed.getFullYear()).slice(-2)}`;
  }

  return dateStr;
}

// ==================== COMPUTED ====================
const filteredRecords = computed(() => {
  let result = records.value;

  const q = searchQuery.value.trim().toLowerCase();
  if (q) {
    result = result.filter(
      (r) =>
        r.clientName?.toLowerCase().includes(q) ||
        r.service?.toLowerCase().includes(q)
    );
  }

  // Date filter
if (selectedDate.value) {
  result = result.filter(
    (r) => toComparableDate(r.dateRecorded) === selectedDate.value
  );
}

  

  // Service filter
  if (selectedService.value !== "All Services") {
    result = result.filter((r) => r.service === selectedService.value);
  }

  return result;
});

const selectedCount = computed(() => selectedIds.value.length);
const isAllSelected = computed(() => {
  return (
    paginatedRecords.value.length > 0 &&
    paginatedRecords.value.every((r) => selectedIds.value.includes(r.id))
  );
});

// ==================== PAGINATION - COPIED FROM LEADS ====================
const rowsPerPageOptions = [13, 26, 39, 52, 65];
const recordsRowsPerPage = ref(13);
const recordsCurrentPage = ref(1);
const recordsPageInput = ref("");

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

watch(recordsRowsPerPage, () => {
  recordsCurrentPage.value = 1;
});
watch(filteredRecords, () => {
  if (recordsCurrentPage.value > totalRecordsPages.value) {
    recordsCurrentPage.value = totalRecordsPages.value;
  }
  selectedIds.value = [];
});

// ==================== CALENDAR - COPIED FROM LEADS ====================
const today = new Date();
const currentMonth = ref(today.getMonth());
const currentYear = ref(today.getFullYear());

// Same format used by selectDate()/filteredRecords: MM/DD/YY
const todayDateStr = `${String(today.getMonth() + 1).padStart(2, "0")}/${String(
  today.getDate()
).padStart(2, "0")}/${String(today.getFullYear()).slice(-2)}`;

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
  const days = [];
  const firstDay = new Date(currentYear.value, currentMonth.value, 1).getDay();
  const daysInMonth = new Date(
    currentYear.value,
    currentMonth.value + 1,
    0
  ).getDate();
  const daysInPrevMonth = new Date(
    currentYear.value,
    currentMonth.value,
    0
  ).getDate();

  for (let i = firstDay - 1; i >= 0; i--) {
    days.push({ day: daysInPrevMonth - i, isCurrentMonth: false, date: null });
  }
  for (let i = 1; i <= daysInMonth; i++) {
    const dateStr = `${String(currentMonth.value + 1).padStart(
      2,
      "0"
    )}/${String(i).padStart(2, "0")}/${String(currentYear.value).slice(-2)}`;
    days.push({
      day: i,
      isCurrentMonth: true,
      date: dateStr,
      isSelected: selectedDate.value === dateStr,
      isToday: dateStr === todayDateStr,
    });
  }
  const remaining = 42 - days.length;
  for (let i = 1; i <= remaining; i++) {
    days.push({ day: i, isCurrentMonth: false, date: null });
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
  if (date) { 
    selectedDate.value = date;
    showDatePicker.value = false;
  }
  
}

function clearDateFilter() {
  selectedDate.value = "";
}

function closeAllDropdowns() {
  showDatePicker.value = false;
  showServicesDropdown.value = false;
}

// ==================== API FUNCTIONS (BACKEND DEV REPLACES THESE) ====================

/**
 * FETCH all active records from backend
 * Backend dev: Replace with your API call (GET /api/pip-records)
 * Records are sorted newest-first so the most recently added/restored
 * record shows at the top of the table.
 */
async function fetchRecords() {
  isLoading.value = true;
  try {
    const plans = await api.getPerformancePlans();
    records.value = (plans || [])
      .map((plan) => api.toFrontendRecord(plan, lookups.value))
      .sort((a, b) => (b.id ?? 0) - (a.id ?? 0));
  } catch (error) {
    console.error("Failed to fetch records:", error);
    toast.error("Unable to load PIP records. Please try again.");
  } finally {
    isLoading.value = false;
  }
}

async function fetchArchivedRecords() {
  isArchiveLoading.value = true;
  try {
    const plans = await api.getArchivedPerformancePlans();
    archivedRecords.value = (plans || [])
      .map((plan) => ({
        ...api.toFrontendRecord(plan, lookups.value),
        dateArchived: plan.dateArchived || plan.archived_at || "",
      }))
      .sort((a, b) => {
        // Sort by dateArchived descending (most recent first)
        const dateA = new Date(a.dateArchived || 0);
        const dateB = new Date(b.dateArchived || 0);
        return dateB - dateA;
      });
    archivedSelectedIds.value = [];
    archiveDeleteError.value = "";
  } catch (error) {
    console.error("Failed to fetch archived records:", error);
    toast.error("Unable to load archived PIP records. Please try again.");
  } finally {
    isArchiveLoading.value = false;
  }
}

/**
 * UPDATE an existing record
 * Backend dev: Replace with your API call (PUT /api/pip-records/:id)
 */
async function updateRecord(id, recordData) {
  if (!canEdit.value) return;

  const payload = api.toBackendPayload(recordData, currentUser.value?.id);
  const plan = await api.updatePerformancePlan(id, payload);
  const idx = records.value.findIndex((r) => r.id === id);
  if (idx > -1) {
    records.value[idx] = api.toFrontendRecord(plan, lookups.value);
  }

  logAuditAction({
    module: "Performance Improvement Plan",
    description: `Updated PIP record for ${recordData.clientName}`,
  });
}

/**
 * ARCHIVE a single record
 * Backend dev: Replace with your API call (POST /api/pip-records/:id/archive)
 */
async function archiveRecordApi(id) {
  if (!canEdit.value) return;

  archiveActionError.value = "";
  try {
    await api.archivePerformancePlan(id);
    const idx = records.value.findIndex((r) => r.id === id);
    if (idx > -1) {
      const record = records.value[idx];
      archivedRecords.value.unshift({
        ...record,
        dateArchived: new Date().toLocaleDateString("en-US", {
          month: "short",
          day: "numeric",
          year: "numeric",
        }),
      });
      records.value.splice(idx, 1);
      selectedIds.value = selectedIds.value.filter((sid) => sid !== id);

      logAuditAction({
        module: "Performance Improvement Plan",
        description: `Archived PIP record: ${record.clientName}`,
      });

      toast.success(`${record.clientName} was archived successfully.`);
    }
  } catch (error) {
    console.error("Failed to archive record:", error);
    archiveActionError.value = describeApiError(error);
    toast.error("Unable to archive this record. Please try again.");
  }
}

/**
 * ARCHIVE multiple records
 * Backend dev: Replace with your API call (POST /api/pip-records/archive-batch)
 */
async function archiveRecordsBatchApi(ids) {
  if (!canEdit.value) return;

  archiveActionError.value = "";
  try {
    // No batch-archive route exists on the backend, so archive one by one.
    await Promise.all(ids.map((id) => api.archivePerformancePlan(id)));

    const now = new Date();
    const dateStr = now.toLocaleDateString("en-US", {
      month: "short",
      day: "numeric",
      year: "numeric",
    });

    const recordsToArchive = records.value.filter((r) => ids.includes(r.id));
    recordsToArchive
      .slice()
      .reverse()
      .forEach((record) => {
        archivedRecords.value.unshift({
          ...record,
          dateArchived: dateStr,
        });
      });

    records.value = records.value.filter((r) => !ids.includes(r.id));

    const archivedNames = recordsToArchive.map((r) => r.clientName).join(", ");
    logAuditAction({
      module: "Performance Improvement Plan",
      description:
        ids.length === 1
          ? `Archived PIP record: ${archivedNames}`
          : `Archived ${ids.length} PIP records: ${archivedNames}`,
    });

    toast.success(
      ids.length === 1
        ? "Record archived successfully."
        : `${ids.length} records archived successfully.`
    );

    selectedIds.value = [];
  } catch (error) {
    console.error("Failed to archive records:", error);
    archiveActionError.value = describeApiError(error);
    toast.error("Unable to archive the selected record(s). Please try again.");
  }
}

/**
 * UNARCHIVE a record
 * Backend dev: Replace with your API call (POST /api/pip-records/:id/unarchive)
 * Restored records are placed at the top (index 0) of the active list.
 */
async function unarchiveRecordApi(id) {
  if (!canEdit.value) return;

  try {
    await api.unarchivePerformancePlan(id);
    const idx = archivedRecords.value.findIndex((r) => r.id === id);
    if (idx > -1) {
      const record = archivedRecords.value[idx];
      const { dateArchived, ...restoredRecord } = record;
      records.value.unshift(restoredRecord);
      archivedRecords.value.splice(idx, 1);
      archivedSelectedIds.value = archivedSelectedIds.value.filter(
        (sid) => sid !== id
      );

      logAuditAction({
        module: "Performance Improvement Plan",
        description: `Restored PIP record: ${record.clientName}`,
      });

      toast.success(`${record.clientName} was restored successfully.`);
    }
  } catch (error) {
    console.error("Failed to unarchive record:", error);
    toast.error("Unable to restore this record. Please try again.");
  }
}

/**
 * UNARCHIVE multiple records
 * Backend dev: Replace with your API call (POST /api/pip-records/unarchive-batch)
 * Restored records are placed at the top of the active list, latest of the
 * batch first.
 */
async function unarchiveRecordsBatchApi(ids) {
  if (!canEdit.value) return;

  archiveActionError.value = "";
  try {
    // No batch-unarchive route exists on the backend, so restore one by one.
    await Promise.all(ids.map((id) => api.unarchivePerformancePlan(id)));

    const recordsToRestore = archivedRecords.value.filter((r) =>
      ids.includes(r.id)
    );
    recordsToRestore
      .slice()
      .reverse()
      .forEach((record) => {
        const { dateArchived, ...restoredRecord } = record;
        records.value.unshift(restoredRecord);
      });

    archivedRecords.value = archivedRecords.value.filter(
      (r) => !ids.includes(r.id)
    );

    const restoredNames = recordsToRestore.map((r) => r.clientName).join(", ");
    logAuditAction({
      module: "Performance Improvement Plan",
      description:
        ids.length === 1
          ? `Restored PIP record: ${restoredNames}`
          : `Restored ${ids.length} PIP records: ${restoredNames}`,
    });

    toast.success(
      ids.length === 1
        ? "Record restored successfully."
        : `${ids.length} records restored successfully.`
    );

    archivedSelectedIds.value = [];
  } catch (error) {
    console.error("Failed to restore records:", error);
    archiveActionError.value = describeApiError(error);
    toast.error("Unable to restore the selected record(s). Please try again.");
  }
}

/**
 * PERMANENTLY DELETE a single archived record
 * Backend dev: Replace with your API call (DELETE /api/pip-records/:id)
 */
async function deleteArchivedRecordApi(id) {
  if (!canEdit.value) return;

  archiveDeleteError.value = "";
  try {
    await api.deletePerformancePlan(id);
    const idx = archivedRecords.value.findIndex((r) => r.id === id);
    if (idx > -1) {
      const record = archivedRecords.value[idx];
      archivedRecords.value.splice(idx, 1);
      archivedSelectedIds.value = archivedSelectedIds.value.filter(
        (sid) => sid !== id
      );

      logAuditAction({
        module: "Performance Improvement Plan",
        description: `Permanently deleted PIP record: ${record.clientName}`,
      });

      toast.success(`${record.clientName} was permanently deleted.`);
    }
  } catch (error) {
    console.error("Failed to delete archived record:", error);
    archiveDeleteError.value = describeApiError(error);
    toast.error("Unable to delete this record. Please try again.");
  }
}

/**
 * PERMANENTLY DELETE multiple archived records
 * Backend dev: Replace with your API call (POST /api/pip-records/delete-batch)
 */
async function deleteArchivedRecordsBatchApi(ids) {
  if (!canEdit.value) return;

  archiveDeleteError.value = "";
  try {
    // No batch-delete route exists on the backend, so delete one by one.
    await Promise.all(ids.map((id) => api.deletePerformancePlan(id)));

    const recordsToDelete = archivedRecords.value.filter((r) =>
      ids.includes(r.id)
    );
    archivedRecords.value = archivedRecords.value.filter(
      (r) => !ids.includes(r.id)
    );

    const deletedNames = recordsToDelete.map((r) => r.clientName).join(", ");
    logAuditAction({
      module: "Performance Improvement Plan",
      description:
        ids.length === 1
          ? `Permanently deleted PIP record: ${deletedNames}`
          : `Permanently deleted ${ids.length} PIP records: ${deletedNames}`,
    });

    toast.success(
      ids.length === 1
        ? "Record permanently deleted."
        : `${ids.length} records permanently deleted.`
    );

    archivedSelectedIds.value = [];
  } catch (error) {
    console.error("Failed to delete archived records:", error);
    archiveDeleteError.value = describeApiError(error);
    toast.error("Unable to delete the selected record(s). Please try again.");
  }
}

// ==================== UI HANDLERS ====================

// Status color scale (10% -> 100%)
function getStatusColor(status) {
  if (status >= 100) return "#639922";
  if (status >= 90) return "#4f772d";
  if (status >= 80) return "#5e8c31";
  if (status >= 70) return "#7fb069";
  if (status >= 60) return "#6b7a8f";
  if (status >= 50) return "#888888";
  if (status >= 40) return "#ffd60a";
  if (status >= 30) return "#ffb300";
  if (status >= 20) return "#fa6f10";
  if (status >= 10) return "#f52c11";
  return "#9ca3af";
}

function isSelected(id) {
  return selectedIds.value.includes(id);
}

function toggleSelection(id) {
  if (!canEdit.value) return;
  const idx = selectedIds.value.indexOf(id);
  if (idx > -1) {
    selectedIds.value.splice(idx, 1);
  } else {
    selectedIds.value.push(id);
  }
}

function toggleAll() {
  if (!canEdit.value) return;
  const visibleIds = paginatedRecords.value.map((r) => r.id);
  const allVisibleSelected = visibleIds.every((id) =>
    selectedIds.value.includes(id)
  );

  if (allVisibleSelected) {
    selectedIds.value = selectedIds.value.filter(
      (id) => !visibleIds.includes(id)
    );
  } else {
    const newIds = visibleIds.filter((id) => !selectedIds.value.includes(id));
    selectedIds.value.push(...newIds);
  }
}

function openViewModal(record) {
  viewingRecord.value = record;
  showViewModal.value = true;
}

function closeViewModal() {
  showViewModal.value = false;
  viewingRecord.value = null;
}

function openEditModal(record) {
  if (!canEdit.value) return;
  editingRecord.value = record;
  saveError.value = "";
  showAddEditModal.value = true;
}

// Add is its own routed page (create.vue), not an inline modal — it fetches
// its own lookups and saves via api.js directly, then navigates back here
// on success. Navigating to a sibling "/create" route under the current
// path (e.g. "/performance-plan" -> "/performance-plan/create") mirrors
// create.vue's own goToList(), which strips the last path segment to get back.
function openAddRecordModal() {
  if (!canAdd.value) return;
  navigateTo(`${route.path.replace(/\/$/, "")}/create`);
}

function closeAddEditModal() {
  showAddEditModal.value = false;
  editingRecord.value = null;
  saveError.value = "";
}

async function handleEditSave(payload) {
  if (!canEdit.value) return;
  if (!editingRecord.value) return;
  saveError.value = "";
  try {
    await updateRecord(editingRecord.value.id, payload);
    closeAddEditModal();
    toast.success(`${payload.clientName} was updated successfully.`);
  } catch (error) {
    console.error("Failed to update record:", error);
    const message = describeApiError(error);
    saveError.value = message;
    toast.error(message);
  }
}

// Turns a thrown api.js error (see request() in api.js) into a readable
// message. Laravel validation errors (422) put field messages under
// error.data.errors — e.g. { user_id: ["The user_id field is required."] }.
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

function archiveSelectedRecords() {
  if (!canEdit.value) return;
  archiveRecordsBatchApi([...selectedIds.value]);
}

function unarchiveRecord(id) {
  if (!canEdit.value) return;
  unarchiveRecordApi(id);
}

function deleteArchivedRecord(id) {
  if (!canEdit.value) return;
  deleteArchivedRecordApi(id);
}

function deleteSelectedArchivedRecords() {
  if (!canEdit.value) return;
  deleteArchivedRecordsBatchApi([...archivedSelectedIds.value]);
}

function restoreSelectedArchivedRecords() {
  if (!canEdit.value) return;
  unarchiveRecordsBatchApi([...archivedSelectedIds.value]);
}

function closeArchiveModal() {
  showArchiveModal.value = false;
  archivedSelectedIds.value = [];
  archiveDeleteError.value = "";
}

// Reads the user object login.vue stored in localStorage after a
// successful sign-in. login.vue stores it via
// localStorage.setItem('user', JSON.stringify(user)), where `user` is
// LoginController::formatUser()'s shape: { id, full_name, email, role_id, role }.
function loadCurrentUser() {
  const { read } = useBrowserStorage();
  try {
    const raw = read("user");
    currentUser.value = raw ? JSON.parse(raw) : null;
  } catch (error) {
    console.error("Failed to parse stored user:", error);
    currentUser.value = null;
  }
}

// ==================== LIFECYCLE ====================
onMounted(async () => {
  await permissionsReady;

  if (!canView.value) {
    toast.error("You don't have permission to view this page.");
    router.push("/");
    return;
  }

  loadCurrentUser();
  isLoading.value = true;
  try {
    lookups.value = await api.fetchLookups();
  } catch (error) {
    console.error("Failed to load lookups:", error);
  }
  await fetchRecords();

  // Fetch archived records too, so the badge count on "View archive"
  // shows immediately instead of only after the modal is opened once.
  fetchArchivedRecords();
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  appearance: textfield;
}

.custom-scroll::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: #f52c11;
  border-radius: 3px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #d9250e;
}

input[type="checkbox"] {
  accent-color: #f52c11;
}

table th,
table td {
  border-left: none !important;
  border-right: none !important;
}
</style>
