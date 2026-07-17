<template>
  <template v-if="canView">
  <div
    class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-[#f0f0f0] font-['Overpass'] text-[14px] text-[#1F2835]"
  >
    <ToastContainer />

    <!-- Top Header: Breadcrumb -->
    <div
      class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200"
    >
      <div class="flex items-center text-[11px] text-gray-500 gap-1">
        <svg
          class="w-3.5 h-3.5 text-black mr-0.5"
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
        <span class="text-[#F52C11] font-medium">Sales Task</span>
      </div>
    </div>

    <!-- Row 1: Title + View Archive -->
    <div class="px-4 py-1.5 flex items-center justify-between gap-4 shrink-0">
      <h1 class="font-bold text-[16px] tracking-tight whitespace-nowrap">
        Sales Task
      </h1>

      <button
        @click="openArchiveModal"
        class="relative bg-white border border-gray-300 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-2.5 py-[3px] rounded-[6px] text-[11px] font-medium flex items-center gap-1 transition-colors"
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
        View Archive
        <span
          v-if="archivedRecords.length > 0"
          class="absolute -top-1.5 -right-1.5 min-w-[16px] h-[16px] px-1 flex items-center justify-center rounded-full bg-[#F52C11] text-white text-[9px] font-bold leading-none"
        >
          {{ archivedBadgeCount }}
        </span>
      </button>
    </div>

    <!-- Row 2: Search + Date + Add -->
    <div class="px-4 py-1 flex items-center justify-between gap-2 shrink-0">
      <div class="relative flex items-center">
        <svg
          v-show="!searchQuery"
          class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-1/2 -translate-y-1/2 pointer-events-none"
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
          :placeholder="searchQuery ? '' : 'Search'"
          class="pl-7 pr-2 py-[3px] w-48 bg-white border border-gray-300 rounded-[6px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
        />
      </div>

      <div class="flex items-center gap-2">
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
                @click="clearDate"
                class="text-[10px] text-gray-400 hover:text-[#F52C11] transition-colors"
              >
                Clear date
              </button>
            </div>
          </div>
        </div>

        <button
          v-if="canAdd"
          @click="handleAddRecord"
          class="bg-white border border-gray-300 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-2.5 py-[3px] rounded-[6px] text-[11px] font-medium flex items-center gap-1 transition-colors"
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
          Add weekly task
        </button>
      </div>
    </div>

    <!-- Main Content: Table -->
    <main
      class="flex-1 flex justify-center pt-0.5 px-2.5 pb-2 gap-1.5 min-h-0 overflow-hidden"
    >
      <section
        class="w-full flex flex-col bg-white overflow-hidden relative rounded-[6px]"
      >
        <!-- Table Header Info -->
        <div
          class="flex items-center justify-between px-2 py-[2px] border-b border-gray-100 shrink-0"
        >
          <div class="flex items-center gap-3">
            <span class="text-[11px] text-gray-500 font-medium"
              >Showing {{ recordsRangeStart }}-{{ recordsRangeEnd }}</span
            >
            <span class="text-[11px] text-gray-400"
              >{{ totalRecords }} total records</span
            >
          </div>

          <div class="flex items-center gap-1.5">
            <span class="text-[10px] text-gray-500">Rows per page</span>
            <div class="relative">
              <select
                v-model.number="recordsRowsPerPage"
                class="bg-white border border-gray-300 rounded-[6px] pl-2 pr-6 py-[2px] text-[10px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] appearance-none cursor-pointer"
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
          </div>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="flex-1 flex items-center justify-center">
          <div class="text-gray-400 text-[12px]">Loading records...</div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="flex-1 flex items-center justify-center">
          <div class="text-center">
            <svg
              class="w-8 h-8 mx-auto mb-2 text-[#F52C11]"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
              />
            </svg>
            <p class="text-[12px] text-gray-500 mb-2">{{ error }}</p>
            <button
              @click="fetchRecords"
              class="text-[11px] text-[#F52C11] hover:underline font-medium"
            >
              Retry
            </button>
          </div>
        </div>

        <!-- Table -->
        <div v-else class="flex-1 overflow-auto custom-scroll relative">
          <table class="w-full border-collapse text-left table-fixed">
            <colgroup>
              <col class="w-[2%]" />
              <col v-if="canEdit" class="w-[2%]" />
              <col class="w-[15%]" />
              <col class="w-[57%]" />
              <col v-if="canEdit" class="w-[15%]" />
            </colgroup>
            <thead class="bg-gray-50 sticky top-0 z-20">
              <tr class="border-b border-gray-200">
                <th class="px-1.5 py-[2px]"></th>
                <th v-if="canEdit" class="px-1.5 py-[2px]">
                  <div class="flex items-center justify-center">
                    <input
                      type="checkbox"
                      :checked="isAllSelected"
                      @change="toggleAll"
                      class="w-3 h-3 rounded border-gray-300 bg-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                    />
                  </div>
                </th>
                <th
                  class="pl-1.5 pr-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#f52c11] text-left"
                >
                  Date
                </th>
                <th
                  class="px-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#f52c11] text-center"
                >
                  Status
                </th>
                <th
                  v-if="canEdit"
                  class="px-4 py-[2px] font-semibold text-[11px] whitespace-nowrap text-[#f52c11] text-center sticky right-0 z-20 bg-gray-50 shadow-[-2px_0_4px_rgba(0,0,0,0.05)]"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody>
             <tr
  v-for="(record, index) in paginatedRecords"
  :key="record.id"
  class="transition-colors group"
                :class="{
                  'bg-[#FCE4E2]': isSelected(record.id), // ← HIGHLIGHTED (red)
                  'bg-white hover:bg-[#F52C11]/10': !isSelected(record.id), // ← NORMAL
                  'border-b border-gray-100':
                    index !== paginatedRecords.length - 1,
                }"
              >
                <td
                  class="px-1.5 py-[2px] text-center text-[11px] font-medium text-gray-500"
                >
                  {{ recordsRangeStart + index }}
                </td>
                <td v-if="canEdit" class="px-1.5 py-[2px]">
                  <div class="flex items-center justify-center h-full">
                    <input
                      type="checkbox"
                      :checked="isSelected(record.id)"
                      @change="toggleSelection(record.id)"
                      class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                    />
                  </div>
                </td>
                <td
                  class="pl-1.5 pr-4 py-[2px] whitespace-nowrap text-[11px] font-medium text-left"
                  :class="
                    isSelected(record.id) ? 'text-[#1F2835]' : 'text-[#1F2835]'
                  "
                >
                  {{ record.date }}
                </td>
                <td class="px-4 py-[2px] whitespace-nowrap text-center">
                  <div class="flex items-center justify-center gap-2">
                    <div
                      class="w-64 h-1.5 bg-gray-200 rounded-full overflow-hidden"
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
                      :style="{
                        color: getStatusColor(record.status),
                      }"
                      >{{ record.status }}%</span
                    >
                  </div>
                </td>
                                <td
                  v-if="canEdit"
                  class="px-4 py-[2px] whitespace-nowrap text-center sticky right-0 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] transition-colors"
                  :class="
                    isSelected(record.id)
                      ? 'bg-[#FCE4E2]'
                      : 'bg-white group-hover:bg-[#F52C11]/5'
                  "
                >
                  <div class="flex items-center justify-center gap-1.5">
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
                  :colspan="canEdit ? 5 : 3"
                  class="px-4 py-12 text-center text-gray-400"
                >
                  <div v-if="searchQuery || selectedDate">
                    No records found<span v-if="searchQuery">
                      matching "<span class="font-semibold text-[#1F2835]">{{
                        searchQuery
                      }}</span
                      >"</span
                    ><span v-if="selectedDate">
                      for
                      <span class="font-semibold text-[#1F2835]">{{
                        selectedDate
                      }}</span></span
                    >
                  </div>
                  <div v-else>No records available</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Archive Action Error -->
        <div
          v-if="archiveActionError"
          class="shrink-0 bg-red-50 border-t border-red-200 px-3 py-1.5 flex items-center justify-between gap-2"
        >
          <span class="text-[11px] text-red-600 font-medium">{{
            archiveActionError
          }}</span>
          <button
            @click="archiveActionError = null"
            class="text-[10px] text-red-500 hover:underline"
          >
            Dismiss
          </button>
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

        <!-- Pagination Footer -->
        <div
          class="shrink-0 bg-[#f0f0f0] px-2.5 py-1 flex items-center justify-between gap-2 flex-wrap"
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
              class="w-10 bg-white border border-gray-300 rounded-[6px] px-1.5 py-[1px] text-[11px] text-[#1F2835] text-center focus:outline-none focus:border-[#F52C11] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
              @keyup.enter="goToTypedRecordsPage"
            />
            <button
              @click="goToTypedRecordsPage"
              class="bg-gray-200 border border-gray-300 hover:bg-gray-300 text-[#1F2835] px-1.5 py-[1px] rounded-[6px] text-[9px] font-medium transition-colors"
            >
              Go
            </button>
          </div>

          <div class="flex items-center gap-0.5">
            <button
              @click="goToRecordsPage(recordsCurrentPage - 1)"
              :disabled="recordsCurrentPage === 1"
              class="w-5 h-5 flex items-center justify-center rounded-[6px] text-gray-400 hover:text-[#1F2835] hover:bg-gray-100 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-400 transition-colors"
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
              class="w-5 h-5 flex items-center justify-center rounded-[6px] text-[10px] font-medium transition-colors"
            >
              {{ page }}
            </button>
            <button
              @click="goToRecordsPage(recordsCurrentPage + 1)"
              :disabled="recordsCurrentPage === totalRecordsPages"
              class="w-5 h-5 flex items-center justify-center rounded-[6px] text-gray-400 hover:text-[#1F2835] hover:bg-gray-100 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-400 transition-colors"
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

    <!-- Archived Items Modal -->
    <div
      v-if="showArchiveModal"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
    >
      <div
        class="bg-white rounded-[12px] w-[800px] h-[550px] shadow-xl flex flex-col overflow-hidden"
      >
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
              <p class="text-[9px] text-gray-400">Sales task page</p>
            </div>
          </div>
          <button
            @click="showArchiveModal = false"
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
              Archived tasks
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
              placeholder="Search archived task..."
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

          <div v-else class="space-y-2">
            <div
              v-for="record in filteredArchivedRecords"
              :key="record.id"
              class="flex items-start gap-2 p-2 bg-gray-50 rounded-[6px] border border-gray-200 hover:border-gray-300 transition-colors"
            >
              <div v-if="canEdit" class="flex items-center justify-center pt-0.5">
                <input
                  type="checkbox"
                  :checked="isArchivedSelected(record.id)"
                  @change="toggleArchivedSelection(record.id)"
                  class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer accent-[#F52C11]"
                />
              </div>

              <svg
                class="w-3.5 h-3.5 text-gray-400 mt-0.5 flex-shrink-0"
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

              <div class="flex-1 min-w-0">
                <div class="text-[11px] font-semibold text-[#1F2835]">
                  {{ record.date }}
                </div>
                <div class="text-[9px] text-gray-500">
                  Archived {{ record.dateArchived }} •
                  <span
                    v-if="Number(record.status) >= 100"
                    class="text-green-600 font-medium"
                    >Completed</span
                  >
                  <span v-else class="text-gray-500 font-medium"
                    >{{ Number(record.status) || 0 }}% complete</span
                  >
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
              @click="bulkUnarchiveSelected"
              :disabled="isBulkRestoring"
              class="inline-flex items-center gap-1 px-2.5 py-[4px] rounded-[6px] border border-gray-200 bg-white text-[#1F2835] hover:border-[#F52C11] text-[10px] font-medium transition-colors disabled:opacity-50"
            >
              <svg
                class="w-3 h-3 text-green-500"
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
              {{ isBulkRestoring ? "Restoring..." : "Restore" }}
            </button>
            <button
              @click="bulkDeleteSelected"
              :disabled="isBulkDeleting"
              class="inline-flex items-center gap-1 px-2.5 py-[4px] rounded-[6px] border border-gray-200 bg-white text-[#1F2835] hover:border-red-400 text-[10px] font-medium transition-colors disabled:opacity-50"
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
              {{ isBulkDeleting ? "Deleting..." : "Delete" }}
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
            Restoring moves the task back to its active list
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
  </div>

  <!-- Create Task Modal -->
  <CreateTaskModal
    v-if="showCreateModal"
    :default-date="selectedDate"
    :saving="createSaving"
    :error-message="createError"
    @close="closeCreateModal"
    @save="handleCreateSave"
  />

  <!-- Edit Task Modal -->
  <EditTaskModal
    v-if="showEditModal"
    :task="editingRecord"
    :saving="editSaving"
    :error-message="editError"
    @close="closeEditModal"
    @save="handleEditSave"
  />

  <!-- Click outside to close dropdowns -->
  <div
    v-if="showDatePicker"
    class="fixed inset-0 z-40"
    @click="showDatePicker = false"
  ></div>
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
import { ref, computed, watch, onMounted } from "vue";
import CreateTaskModal from "./create.vue";
import EditTaskModal from "./edit.vue";
import { useAuditLog } from "~/composables/useAuditLog";
import { useToast } from "~/composables/useToast";
import { usePermissions } from "~/composables/usePermissions";

// ==================== API SETUP ====================
const { apiFetch } = useApi();
const { logAuditAction } = useAuditLog();
const toast = useToast();
const router = useRouter();

const {
  ready: permissionsReady,
  isLoading: permissionsLoading,
  canView,
  canEdit,
  canAdd,
} = usePermissions("sales-task");

// Archivable::discoverArchivableModels() keys types by Str::snake(ClassName),
// so the SalesTask model resolves to "sales_task".
const ARCHIVE_TYPE = "sales_task";

function getCurrentUserId() {
  try {
    const user = JSON.parse(localStorage.getItem("user") || "null");
    return user?.id ?? null;
  } catch {
    return null;
  }
}

// The stored "user" object (see login flow) currently has no `id` field —
// only full_name, email, role, role_id, permissions. So getCurrentUserId()
// can't be used to gate "am I logged in" checks. The auth token is the
// reliable signal that a session exists.
function isLoggedIn() {
  try {
    return !!localStorage.getItem("token");
  } catch {
    return false;
  }
}

// ==================== STATE ====================
const searchQuery = ref("");
const selectedIds = ref([]);
const showArchiveModal = ref(false);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editingRecord = ref(null);
const isLoading = ref(false);
const isArchiveLoading = ref(false);
const error = ref(null);
const archiveActionError = ref(null);
const archivedSearchQuery = ref("");
const isRestoring = ref({}); // Track per-record restore state
const isDeleting = ref({}); // Track per-record permanent-delete state
const showDatePicker = ref(false);
// ==================== ARCHIVED SELECTION STATE ====================
// ==================== ARCHIVED SELECTION STATE ====================
const archivedSelectedIds = ref([]);
const isBulkRestoring = ref(false);
const isBulkDeleting = ref(false);

// ==================== ARCHIVED COMPUTED ====================
const archivedSelectedCount = computed(() => archivedSelectedIds.value.length);

const isAllArchivedSelected = computed(() => {
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

  // If all visible are already selected, deselect all
  const allVisibleSelected = visibleIds.every((id) =>
    archivedSelectedIds.value.includes(id)
  );

  if (allVisibleSelected) {
    // Deselect all visible
    archivedSelectedIds.value = archivedSelectedIds.value.filter(
      (id) => !visibleIds.includes(id)
    );
  } else {
    // Select all visible (avoid duplicates)
    const newIds = visibleIds.filter(
      (id) => !archivedSelectedIds.value.includes(id)
    );
    archivedSelectedIds.value.push(...newIds);
  }
}

// ==================== BULK ACTIONS ====================
async function bulkUnarchiveSelected() {
  if (!canEdit.value) return;
  if (archivedSelectedIds.value.length === 0) return;
  isBulkRestoring.value = true;

  try {
    await Promise.all(
      archivedSelectedIds.value.map((id) => unarchiveRecordApi(id))
    );
    archivedSelectedIds.value = [];
  } catch (err) {
    console.error("Bulk unarchive error:", err);
  } finally {
    isBulkRestoring.value = false;
  }
}

async function bulkDeleteSelected() {
  if (!canEdit.value) return;
  if (archivedSelectedIds.value.length === 0) return;

  const confirmed = window.confirm(
    `This will permanently delete ${archivedSelectedIds.value.length} task(s). This cannot be undone. Continue?`
  );
  if (!confirmed) return;

  isBulkDeleting.value = true;

  try {
    await Promise.all(
      archivedSelectedIds.value.map((id) => deleteRecordApi(id))
    );
    archivedSelectedIds.value = [];
  } catch (err) {
    console.error("Bulk delete error:", err);
  } finally {
    isBulkDeleting.value = false;
  }
}

// Clear archived selection when modal closes or search changes
watch(showArchiveModal, (val) => {
  if (!val) archivedSelectedIds.value = [];
});
watch(archivedSearchQuery, () => {
  archivedSelectedIds.value = [];
});

// Real saving/error state for the Create and Edit modals, driven by the
// actual API calls below (not a fake timer inside the modals).
const createSaving = ref(false);
const createError = ref("");
const editSaving = ref(false);
const editError = ref("");

// Date filter state
const selectedDate = ref("");

// Empty arrays — backend will populate these
const records = ref([]);
const archivedRecords = ref([]);

// ==================== COMPUTED ====================
const filteredRecords = computed(() => {
  let result = [...records.value];

  const q = searchQuery.value.trim().toLowerCase();
  if (q) {
    result = result.filter((r) => r.date?.toLowerCase().includes(q));
  }

  // Filter by the date selected in the header date picker. Both sides
  // are normalized to YYYY-MM-DD via toIsoDate() so it doesn't matter
  // whether the record date is MM/DD/YYYY or the picker gave MM/DD/YY.
  if (selectedDate.value) {
    const target = toIsoDate(selectedDate.value);
    result = result.filter((r) => toIsoDate(r.date) === target);
  }

  return result;
});

const filteredArchivedRecords = computed(() => {
  let result = [...archivedRecords.value];

  const q = archivedSearchQuery.value.trim().toLowerCase();
  if (q) {
    result = result.filter((r) => r.date?.toLowerCase().includes(q));
  }

  return result;
});

// Badge shown on the "View Archive" button. Caps the display at "99+" so
// a large archive count doesn't blow up the pill's layout.
const archivedBadgeCount = computed(() => {
  const count = archivedRecords.value.length;
  return count > 99 ? "99+" : String(count);
});

const selectedCount = computed(() => selectedIds.value.length);
const isAllSelected = computed(() => {
  return (
    paginatedRecords.value.length > 0 &&
    paginatedRecords.value.every((r) => selectedIds.value.includes(r.id))
  );
});

const currentMonth = ref(new Date().getMonth());
const currentYear = ref(new Date().getFullYear());

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
  const today = new Date();
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
      isToday:
        currentYear.value === today.getFullYear() &&
        currentMonth.value === today.getMonth() &&
        i === today.getDate(),
    });
  }
  const remaining = 42 - days.length;
  for (let i = 1; i <= remaining; i++) {
    days.push({ day: i, isCurrentMonth: false, date: null });
  }
  return days;
});

// ==================== PAGINATION ====================
const rowsPerPageOptions = [13, 26, 39, 52, 65];
const recordsRowsPerPage = ref(13);
const recordsCurrentPage = ref(1);
const recordsPageInput = ref("");

const totalRecords = computed(() => filteredRecords.value.length);

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
function clearDate() {
  selectedDate.value = "";
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

// ==================== API FUNCTIONS ====================

/**
 * Format a 'YYYY-MM-DD' / 'YYYY-MM-DD HH:mm:ss' date string as 'MM/DD/YYYY'
 * without going through the Date constructor (avoids timezone shifting).
 */
function formatDateForDisplay(value) {
  if (!value) return "";
  const match = String(value).match(/^(\d{4})-(\d{2})-(\d{2})/);
  if (!match) return value;
  const [, year, month, day] = match;
  return `${month}/${day}/${year}`;
}

/**
 * The date picker in create.vue/edit.vue produces 'MM/DD/YYYY' (for
 * display). Laravel's `date`/`date_format:Y-m-d` validation and date
 * columns expect 'YYYY-MM-DD'. Convert before sending to the API so the
 * request doesn't get rejected or stored as the wrong date.
 * NOTE: if your `task_date` column/validation expects a different
 * format, adjust the return value here.
 */
function toIsoDate(value) {
  if (!value) return null;
  const str = String(value).trim();

  // MM/DD/YYYY — what the create/edit date picker produces.
  let match = str.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
  if (match) {
    const [, month, day, year] = match;
    return `${year}-${month}-${day}`;
  }

  // MM/DD/YY — what the header search-date filter produces.
  match = str.match(/^(\d{2})\/(\d{2})\/(\d{2})$/);
  if (match) {
    const [, month, day, year] = match;
    return `20${year}-${month}-${day}`;
  }

  return str; // already ISO or unrecognized — pass through
}

/**
 * Map a record from the API into the shape the table/modals use
 * ({ id, date, status, checklist }).
 *
 * Handles two different response shapes:
 * - SalesTaskController (index/store/show/update) already returns
 *   { date, checklist, progress } decoded from task_notes.
 * - ArchiveController (archive/unarchive/archived) returns the raw
 *   Eloquent model instead: { task_date, task_notes (JSON string) }.
 */
function mapApiRecord(record) {
  if (Array.isArray(record.checklist)) {
    return {
      id: record.id,
      user_id: record.user_id,
      date: record.date,
      status: record.progress ?? 0,
      checklist: record.checklist,
    };
  }

  let notes = { checklist: [], progress: 0 };
  try {
    const parsed = JSON.parse(record.task_notes || "{}");
    notes = {
      checklist: parsed.checklist || [],
      progress: parsed.progress ?? 0,
    };
  } catch {
    // task_notes wasn't valid JSON (e.g. legacy plain-text note) — fall back to empty.
  }

  return {
    id: record.id,
    user_id: record.user_id,
    date: formatDateForDisplay(record.task_date),
    status: notes.progress,
    checklist: notes.checklist,
    archivedAt: record.archived_at ?? null,
  };
}

/**
 * Sort archived records so the most recently archived task is always
 * first in the list (falls back to 0 for records with no archivedAt,
 * which just pushes them to the bottom instead of crashing the sort).
 */
function sortArchivedByLatest() {
  archivedRecords.value.sort((a, b) => {
    const aTime = a.archivedAt ? new Date(a.archivedAt).getTime() : 0;
    const bTime = b.archivedAt ? new Date(b.archivedAt).getTime() : 0;
    return bTime - aTime;
  });
}

/**
 * FETCH all active records from backend
 */
async function fetchRecords() {
  isLoading.value = true;
  error.value = null;

  try {
    const response = await apiFetch("/salestasks");
    const data = response?.data ?? response;
    records.value = (data ?? []).map(mapApiRecord);
  } catch (err) {
    error.value = err.message || "Failed to load records";
    console.error("Fetch records error:", err);
    toast.error("Unable to load sales tasks. Please try again.");
  } finally {
    isLoading.value = false;
  }
}

/**
 * FETCH archived records from backend
 */
async function fetchArchivedRecords() {
  isArchiveLoading.value = true;

  try {
    const response = await apiFetch(`/archived/${ARCHIVE_TYPE}`);
    const data = response?.data ?? response;
    archivedRecords.value = (data ?? []).map((record) => {
      const mapped = mapApiRecord(record);
      return {
        ...mapped,
        dateArchived: formatDateForDisplay(mapped.archivedAt) || null,
      };
    });
    sortArchivedByLatest();
  } catch (err) {
    console.error("Fetch archived error:", err);
    toast.error("Unable to load archived tasks. Please try again.");
  } finally {
    isArchiveLoading.value = false;
  }
}

/**
 * CREATE a new record
 */
async function createRecord(recordData) {
  if (!canAdd.value) return;

  const response = await apiFetch("/salestasks", {
    method: "POST",
    body: {
      user_id: getCurrentUserId(),
      task_date: toIsoDate(recordData.date),
      checklist: recordData.checklist || [],
      progress: recordData.progress ?? 0,
    },
  });

  const newRecord = response?.task ?? response;
  records.value.push(mapApiRecord(newRecord));

  logAuditAction({
    module: "Sales Task",
    description: `Created new sales task for ${recordData.date} (${
      recordData.checklist?.length || 0
    } checklist item(s))`,
  });
}

/**
 * UPDATE an existing record
 */
async function updateRecord(id, recordData) {
  if (!canEdit.value) return;

  const response = await apiFetch(`/salestasks/${id}`, {
    method: "PUT",
    body: {
      task_date: toIsoDate(recordData.date),
      checklist: recordData.checklist || [],
      progress: recordData.progress ?? 0,
    },
  });

  const updated = response?.task ?? response;
  const idx = records.value.findIndex((r) => r.id === id);
  if (idx > -1) {
    records.value[idx] = mapApiRecord(updated);
  }

  logAuditAction({
    module: "Sales Task",
    description: `Updated sales task for ${recordData.date} (progress: ${
      recordData.progress ?? 0
    }%)`,
  });
}

/**
 * ARCHIVE multiple records
 * The backend route only archives one record at a time
 * (POST /archive/{type}/{id}), so we fire one request per selected id.
 */
async function archiveRecordsBatchApi(ids) {
  if (!canEdit.value) return;

  archiveActionError.value = null;
  try {
    await Promise.all(
      ids.map((id) =>
        apiFetch(`/archive/${ARCHIVE_TYPE}/${id}`, { method: "POST" })
      )
    );

    const recordsToArchive = records.value.filter((r) => ids.includes(r.id));
    const now = new Date();
    const dateStr = now
      .toLocaleDateString("en-US", {
        month: "2-digit",
        day: "2-digit",
        year: "2-digit",
      })
      .replace(/\//g, "-");
    // Full ISO timestamp so sortArchivedByLatest() can compare these
    // freshly-archived records against ones already fetched from the API.
    const nowIso = now.toISOString();

    recordsToArchive.forEach((record) => {
      archivedRecords.value.unshift({
        ...record,
        dateArchived: dateStr,
        archivedAt: nowIso,
      });
    });
    // Re-sort (rather than relying purely on unshift order) so the newest
    // archived task is always first, even across repeated archive actions
    // and previously-fetched archive data.
    sortArchivedByLatest();

    records.value = records.value.filter((r) => !ids.includes(r.id));

    const archivedDates = recordsToArchive.map((r) => r.date).join(", ");
    logAuditAction({
      module: "Sales Task",
      description:
        ids.length === 1
          ? `Archived sales task: ${archivedDates}`
          : `Archived ${ids.length} sales tasks: ${archivedDates}`,
    });

    toast.success(
      ids.length === 1
        ? "Task archived successfully."
        : `${ids.length} tasks archived successfully.`
    );

    selectedIds.value = [];
  } catch (err) {
    archiveActionError.value =
      "Failed to archive selected record(s). Please try again.";
    console.error("Archive error:", err);
    toast.error("Unable to archive the selected task(s). Please try again.");
  }
}

/**
 * UNARCHIVE a record (POST /unarchive/{type}/{id})
 */
async function unarchiveRecordApi(id) {
  if (!canEdit.value) return;

  isRestoring.value[id] = true;

  try {
    await apiFetch(`/unarchive/${ARCHIVE_TYPE}/${id}`, { method: "POST" });

    const record = archivedRecords.value.find((r) => r.id === id);
    if (record) {
      const { dateArchived, archivedAt, ...rest } = record;
      records.value.push(rest);
      archivedRecords.value = archivedRecords.value.filter((r) => r.id !== id);

      logAuditAction({
        module: "Sales Task",
        description: `Restored sales task: ${record.date}`,
      });

      toast.success(`Task for ${record.date} was restored successfully.`);
    }
  } catch (err) {
    console.error("Unarchive error:", err);
    toast.error("Unable to restore this task. Please try again.");
  } finally {
    isRestoring.value[id] = false;
  }
}

/**
 * PERMANENTLY DELETE an archived record (DELETE /salestasks/{id})
 * Unlike unarchive, this does not bring the record back — it's gone for good.
 */
async function deleteRecordApi(id) {
  if (!canEdit.value) return;

  isDeleting.value[id] = true;

  try {
    const record = archivedRecords.value.find((r) => r.id === id);

    await apiFetch(`/salestasks/${id}`, { method: "DELETE" });
    archivedRecords.value = archivedRecords.value.filter((r) => r.id !== id);

    logAuditAction({
      module: "Sales Task",
      description: `Permanently deleted sales task: ${
        record?.date || "record"
      }`,
    });

    toast.success(
      `Task for ${record?.date || "record"} was permanently deleted.`
    );
  } catch (err) {
    archiveActionError.value = "Failed to delete record. Please try again.";
    console.error("Delete error:", err);
    toast.error("Unable to delete this task. Please try again.");
  } finally {
    isDeleting.value[id] = false;
  }
}

// ==================== UI HANDLERS ====================

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

function getStatusColor(status) {
  const value = Number(status) || 0;
  const bucket = Math.min(10, Math.max(1, Math.ceil(value / 10) || 1));
  return progressColorPalette[bucket - 1];
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

function openArchiveModal() {
  showArchiveModal.value = true;
  archivedSelectedIds.value = [];
  fetchArchivedRecords();
}

function openEditModal(record) {
  if (!canEdit.value) return;
  editingRecord.value = record;
  showEditModal.value = true;
}

function closeEditModal() {
  showEditModal.value = false;
  editingRecord.value = null;
  editError.value = "";
}

function handleAddRecord() {
  if (!canAdd.value) return;
  showCreateModal.value = true;
}

function closeCreateModal() {
  showCreateModal.value = false;
  createError.value = "";
}

function extractErrorMessage(err, fallback) {
  // Laravel validation errors typically arrive as { message, errors: {...} }.
  return (
    err?.data?.message ||
    err?.response?._data?.message ||
    err?.message ||
    fallback
  );
}

async function handleCreateSave(payload) {
  if (!canAdd.value) return;

  if (!isLoggedIn()) {
    createError.value =
      "You're not logged in (no auth token found). Please sign in and try again.";
    toast.error("You're not logged in. Please sign in and try again.");
    return;
  }

  createSaving.value = true;
  createError.value = "";
  try {
    await createRecord(payload);
    // Only close once the task is actually saved.
    showCreateModal.value = false;
    toast.success(`Task for ${payload.date} was created successfully.`);
  } catch (err) {
    const message = extractErrorMessage(
      err,
      "Failed to save task. Please try again."
    );
    createError.value = message;
    console.error("Failed to create record:", err);
    toast.error(message);
  } finally {
    createSaving.value = false;
  }
}

async function handleEditSave(payload) {
  if (!canEdit.value) return;
  if (!editingRecord.value) return;
  editSaving.value = true;
  editError.value = "";
  try {
    await updateRecord(editingRecord.value.id, payload);
    closeEditModal();
    toast.success(`Task for ${payload.date} was updated successfully.`);
  } catch (err) {
    const message = extractErrorMessage(
      err,
      "Failed to update task. Please try again."
    );
    editError.value = message;
    console.error("Failed to update record:", err);
    toast.error(message);
  } finally {
    editSaving.value = false;
  }
}

function archiveSelectedRecords() {
  if (!canEdit.value) return;
  if (selectedIds.value.length === 0) return;
  archiveRecordsBatchApi([...selectedIds.value]);
}

function unarchiveRecord(id) {
  if (!canEdit.value) return;
  unarchiveRecordApi(id).then(() => {
    const idx = archivedSelectedIds.value.indexOf(id);
    if (idx > -1) archivedSelectedIds.value.splice(idx, 1);
  });
}

function deleteArchivedRecord(id) {
  if (!canEdit.value) return;
  const confirmed = window.confirm(
    "This will permanently delete this task. This cannot be undone. Continue?"
  );
  if (confirmed) {
    deleteRecordApi(id).then(() => {
      const idx = archivedSelectedIds.value.indexOf(id);
      if (idx > -1) archivedSelectedIds.value.splice(idx, 1);
    });
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

  fetchRecords();
  // Fetch archived records on load too (not just when the modal opens) so
  // the notification badge on "View Archive" is accurate right away.
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
