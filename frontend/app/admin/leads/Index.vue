<template>
  <div class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden bg-white font-['Overpass'] text-[14px] text-[#1F2835]">

    <!-- Top Header: Breadcrumb only -->
    <div class="bg-white px-4 py-1.5 flex items-center shrink-0 border-b border-gray-200">
      <div class="flex items-center text-[11px] text-gray-500 gap-1">
        <!-- Lead Tracker icon matching sidebar style -->
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 17V9"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 17V5"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 17v-3"/>
        </svg>
        <span class="hover:text-[#1F2835] cursor-pointer transition-colors">Leads Tracker</span>
        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="hover:text-[#1F2835] cursor-pointer transition-colors">Leads</span>
        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#F52C11] font-semibold">Industry</span>
      </div>
    </div>

    <!-- Title + Archive (same row) - COMPRESSED -->
    <div class="bg-white px-4 py-1 flex items-center justify-between shrink-0">
      <h1 class="font-bold text-[16px] tracking-tight">Industry – Leads listing</h1>
      
      <button 
        @click="showArchiveModal = true"
        class="bg-[#1F2835] hover:bg-black text-white px-2.5 py-[3px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
      >
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
        </svg>
        View archive
      </button>
    </div>

    <!-- Filters Row - COMPRESSED -->
    <div class="bg-white px-4 py-1 flex items-center justify-between gap-2 shrink-0">
      <!-- Left: Davao, Manila, Search -->
      <div class="flex items-center gap-1.5">
        <button 
          @click="switchLocation('Davao')"
          :class="selectedLocation === 'Davao' ? 'bg-[#F52C11] text-white' : 'bg-gray-100 text-[#1F2835] border border-gray-200'"
          class="pl-1.5 pr-2 py-[2px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
        >
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          Davao
        </button>
        <button 
          @click="switchLocation('Manila')"
          :class="selectedLocation === 'Manila' ? 'bg-[#F52C11] text-white' : 'bg-gray-100 text-[#1F2835] border border-gray-200'"
          class="pl-1.5 pr-2 py-[2px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
        >
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          Manila
        </button>
        <div class="relative flex items-center">
          <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-[4px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Search business name, contact..." 
            class="pl-7 pr-2 py-[2px] w-48 bg-white border border-gray-300 rounded-[4px] focus:outline-none focus:border-[#F52C11] text-[11px] placeholder:text-gray-400 transition-colors"
          >
        </div>
      </div>

      <!-- Right: Date, Services, Status -->
      <div class="flex items-center gap-1.5">
        <!-- Date Picker -->
        <div class="relative">
          <button 
            @click="showDatePicker = !showDatePicker"
            class="bg-white border border-gray-300 px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-1.5 text-[#1F2835] hover:border-gray-400 transition-colors"
          >
            {{ selectedDate }}
            <svg class="w-3 h-3 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </button>
          <!-- Calendar Dropdown -->
          <div v-if="showDatePicker" class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 p-3 w-64">
            <div class="flex items-center justify-between mb-2">
              <button @click="prevMonth" class="text-gray-400 hover:text-[#1F2835]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
              </button>
              <span class="text-[12px] font-semibold">{{ currentMonthYear }}</span>
              <button @click="nextMonth" class="text-gray-400 hover:text-[#1F2835]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
              </button>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center text-[10px] text-gray-400 mb-1">
              <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
            </div>
            <div class="grid grid-cols-7 gap-1">
              <button 
                v-for="day in calendarDays" 
                :key="day.date"
                @click="selectDate(day.date)"
                :class="[
                  'w-7 h-7 rounded-[4px] text-[11px] flex items-center justify-center transition-colors',
                  day.isCurrentMonth ? 'text-[#1F2835]' : 'text-gray-300',
                  day.isSelected ? 'bg-[#F52C11] text-white' : 'hover:bg-gray-100'
                ]"
              >
                {{ day.day }}
              </button>
            </div>
          </div>
        </div>

        <!-- Services Dropdown -->
        <div class="relative">
          <button 
            @click="showServicesDropdown = !showServicesDropdown; showStatusDropdown = false"
            :class="selectedService !== 'All Services' ? 'border-[#F52C11] text-[#F52C11]' : 'border-gray-300 text-[#1F2835]'"
            class="bg-white border px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-1 hover:border-gray-400 transition-colors"
          >
            {{ selectedService }}
            <svg class="w-2.5 h-2.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div v-if="showServicesDropdown" class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[160px]">
            <button 
              v-for="service in serviceOptions" 
              :key="service"
              @click="selectedService = service; showServicesDropdown = false"
              :class="selectedService === service ? 'bg-[#F52C11]/10 text-[#F52C11] font-medium' : 'text-[#1F2835] hover:bg-gray-50'"
              class="w-full text-left px-3 py-1.5 text-[11px] transition-colors"
            >
              {{ service }}
            </button>
          </div>
        </div>

        <!-- Status Dropdown -->
        <div class="relative">
          <button 
            @click="showStatusDropdown = !showStatusDropdown; showServicesDropdown = false"
            :class="selectedStatus !== 'All Status' ? 'border-[#F52C11] text-[#F52C11]' : 'border-gray-300 text-[#1F2835]'"
            class="bg-white border px-2 py-[2px] rounded-[4px] text-[11px] flex items-center gap-1 hover:border-gray-400 transition-colors"
          >
            {{ selectedStatus }}
            <svg class="w-2.5 h-2.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div v-if="showStatusDropdown" class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[140px]">
            <button 
              v-for="status in statusOptions" 
              :key="status"
              @click="selectedStatus = status; showStatusDropdown = false"
              :class="selectedStatus === status ? 'bg-[#F52C11]/10 text-[#F52C11] font-medium' : 'text-[#1F2835] hover:bg-gray-50'"
              class="w-full text-left px-3 py-1.5 text-[11px] transition-colors"
            >
              {{ status }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex p-2 gap-1.5 min-h-0 overflow-hidden">

      <!-- Left: Industries Panel -->
      <aside class="w-48 shrink-0 flex flex-col bg-white border border-gray-200 rounded-[6px] overflow-hidden">
        <!-- Header - Dark #1F2835 with centered text and clear add icon -->
        <div class="bg-[#1F2835] text-white px-2.5 py-1 flex items-center justify-center relative">
          <button 
            @click="showAddIndustryModal = true"
            class="absolute left-2.5 w-5 h-5 bg-white/20 rounded-[4px] flex items-center justify-center hover:bg-white/30 transition-colors"
          >
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
          </button>
          <span class="font-bold text-[11px] tracking-wide uppercase">Industries</span>
        </div>
        <!-- List -->
        <div class="flex-1 overflow-y-auto custom-scroll relative">
          <div 
            v-for="(industry, index) in sortedIndustries" 
            :key="industry"
            class="px-2.5 py-[3px] text-[12px] cursor-pointer transition-all flex items-center justify-between"
            :class="[
              selectedIndustry === industry 
                ? 'bg-[#F52C11]/15 text-[#F52C11] font-medium' 
                : 'text-[#1F2835] hover:bg-[#F52C11]/15 hover:text-[#F52C11]'
            ]"
            @click="selectedIndustry = industry"
          >
            <!-- Inline rename input -->
            <div v-if="editingIndex === index" class="flex-1 flex items-center gap-1" @click.stop>
              <input 
                :ref="el => setRenameInput(el, index)"
                v-model="renameValue"
                type="text" 
                class="flex-1 bg-white border border-gray-300 rounded-[3px] px-1.5 py-0.5 text-[11px] focus:outline-none focus:border-[#F52C11]"
                @blur="finishRename(index)"
                @keyup.enter="finishRename(index)"
                @keyup.esc="cancelRename"
              >
            </div>
            <span v-else class="truncate">{{ industry }}</span>
            
            <div class="relative" v-if="editingIndex !== index">
              <button 
                @click.stop="toggleIndustryMenu(index)"
                class="transition-colors p-0.5 rounded"
                :class="selectedIndustry === industry ? 'text-[#F52C11]/60 hover:text-[#F52C11]' : 'text-gray-400 hover:text-[#1F2835]'"
              >
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                </svg>
              </button>
              <!-- Industry Menu Dropdown -->
              <div 
                v-if="openIndustryMenuIndex === index" 
                class="absolute right-0 top-full mt-1 bg-white border border-gray-200 rounded-[6px] shadow-lg z-50 py-1 min-w-[100px]"
              >
                <button 
                  @click.stop="startInlineRename(industry, index)"
                  class="w-full text-left px-3 py-1.5 text-[11px] text-[#1F2835] hover:bg-gray-50 transition-colors flex items-center gap-1.5"
                >
                  <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  Rename
                </button>
                <button 
                  @click.stop="archiveIndustry(industry)"
                  class="w-full text-left px-3 py-1.5 text-[11px] text-red-500 hover:bg-red-50 transition-colors flex items-center gap-1.5"
                >
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                  Archive
                </button>
              </div>
            </div>
          </div>
        </div>
      </aside>

      <!-- Right: Table Section -->
      <section class="flex-1 flex flex-col min-w-0 bg-white border border-gray-200 overflow-hidden relative">
        
        <!-- Top Bar: Record Count + Add Record - COMPRESSED -->
        <div class="flex items-center justify-between px-2 py-[2px] border-b border-gray-100 shrink-0">
          <span class="text-[11px] text-gray-500 font-medium">{{ filteredRecords.length }} records</span>
          
          <button class="bg-[#F52C11] hover:bg-[#d9250e] active:bg-[#bf200c] text-white px-2 py-[1px] rounded-[4px] text-[10px] font-medium flex items-center gap-0.5 transition-colors">
            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add record
          </button>
        </div>

        <!-- Table -->
        <div class="flex-1 overflow-auto custom-scroll relative">
          <table class="w-full border-collapse text-left">
            <thead class="bg-[#f2f2f2] sticky top-0 z-20">
              <tr>
                <th class="w-6 px-1.5 py-[3px] border border-gray-200 text-center">
                  <input 
                    type="checkbox" 
                    :checked="isAllSelected"
                    @change="toggleAll"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  >
                </th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Date</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Business Name</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Contact Person</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Job Position</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Contact No.</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Email</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Service</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Status</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Remarks</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11]">Location</th>
                <th class="px-2 py-[3px] border border-gray-200 font-semibold text-[11px] whitespace-nowrap text-[#F52C11] sticky right-0 z-30 bg-[#f2f2f2] shadow-[-2px_0_4px_rgba(0,0,0,0.05)]">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="record in filteredRecords" 
                :key="record.id"
                class="transition-colors"
                :class="{
                  'bg-[#F52C11]/15': isSelected(record.id),
                  'bg-white hover:bg-[#F52C11]/10': !isSelected(record.id)
                }"
              >
                <td class="px-1.5 py-[3px] border border-gray-200 text-center">
                  <input 
                    type="checkbox" 
                    :checked="isSelected(record.id)"
                    @change="toggleSelection(record.id)"
                    class="w-3 h-3 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  >
                </td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px]">{{ record.date }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px] font-bold">{{ record.businessName }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px]">{{ record.contactPerson }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px]">{{ record.jobPosition }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px]">{{ record.contactNo }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px] text-gray-600">{{ record.email }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px]">{{ record.service }}</td>
                
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap">
                  <div class="flex flex-col gap-0.5 min-w-[70px]">
                    <div class="flex items-center justify-between">
                      <span class="text-[10px] font-semibold" :class="getStatusTextColor(record.status)">{{ record.status }}</span>
                      <span class="text-[10px] font-bold" :class="getStatusTextColor(record.status)">{{ record.statusPercent }}%</span>
                    </div>
                    <div class="w-full h-[4px] bg-gray-200 rounded-full overflow-hidden">
                      <div 
                        class="h-full rounded-full transition-all duration-500"
                        :class="getStatusBarColor(record.status)"
                        :style="{ width: record.statusPercent + '%' }"
                      ></div>
                    </div>
                  </div>
                </td>

                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px] text-gray-600">{{ record.remarks }}</td>
                <td class="px-2 py-[3px] border border-gray-200 whitespace-nowrap text-[11px]">{{ record.location }}</td>
                
                <td 
                   class="px-2 py-[3px] border border-gray-200 whitespace-nowrap sticky right-0 shadow-[-2px_0_4px_rgba(0,0,0,0.05)] transition-colors"
                   :class="isSelected(record.id) ? 'bg-[#F52C11]/0' : 'bg-white hover:bg-[#F52C11]/0'"
                  >
                  <div class="flex items-center gap-1.5">
                    <button class="text-gray-400 hover:text-[#1F2835] transition-colors" title="View">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </button>
















                    <button @click="openEditModal(record)" class="text-gray-400 hover:text-[#F52C11] transition-colors" title="Edit">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              
              <tr v-if="filteredRecords.length === 0">
                <td colspan="12" class="px-4 py-12 text-center text-gray-400 border border-gray-200">
                  <div v-if="searchQuery">
                    No records found matching "<span class="font-semibold text-[#1F2835]">{{ searchQuery }}</span>"
                  </div>
                  <div v-else>No records available for {{ selectedIndustry }}</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Bottom Selection Bar - COMPRESSED -->
        <div 
          v-if="selectedCount > 0"
          class="shrink-0 bg-white border-t border-gray-200 px-3 py-[3px] flex items-center justify-between"
        >
          <div class="flex items-center gap-2 text-[11px] text-[#1F2835]">
            <svg class="w-3.5 h-3.5 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ selectedCount }} record(s) selected</span>
          </div>
          <button 
            @click="archiveSelectedRecords"
            class="bg-[#F52C11] hover:bg-[#d9250e] text-white px-2.5 py-[2px] rounded-[4px] text-[11px] font-medium flex items-center gap-1 transition-colors"
          >
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            Archive selected
          </button>
        </div>
      </section>
    </main>

    <!-- Add Industry Modal -->
    <div v-if="showAddIndustryModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white rounded-[8px] p-4 w-80 shadow-xl">
        <input 
          v-model="newIndustryName"
          type="text" 
          placeholder="Type new industry name..." 
          class="w-full bg-gray-100 border-0 rounded-[6px] px-3 py-2.5 text-[12px] text-[#1F2835] placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F52C11]/30 mb-3"
          @keyup.enter="addIndustry"
        >
        <div class="flex justify-end gap-2">
          <button 
            @click="showAddIndustryModal = false; newIndustryName = ''" 
            class="px-4 py-1.5 rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-gray-200 hover:bg-gray-300 transition-colors"
          >
            Cancel
          </button>
          <button 
            @click="addIndustry"
            :disabled="!newIndustryName.trim()"
            :class="newIndustryName.trim() ? 'bg-[#F52C11] hover:bg-[#d9250e] text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
            class="px-4 py-1.5 rounded-[4px] text-[11px] font-medium transition-colors"
          >
            Add
          </button>
        </div>
      </div>
    </div>

    <!-- Archive Modal -->
    <div v-if="showArchiveModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white rounded-[8px] w-[520px] shadow-xl flex flex-col overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-[#F52C11]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <div>
              <h3 class="text-[13px] font-bold text-[#1F2835]">Archived items</h3>
              <p class="text-[10px] text-gray-400">Industry page</p>
            </div>
          </div>
          <button @click="showArchiveModal = false" class="text-gray-400 hover:text-[#1F2835]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
        
        <!-- Tabs -->
        <div class="flex border-b border-gray-200 px-4">
          <button 
            @click="archiveTab = 'records'"
            :class="archiveTab === 'records' ? 'border-b-2 border-[#F52C11] text-[#F52C11] font-medium' : 'text-gray-500 hover:text-[#1F2835]'"
            class="px-3 py-2 text-[11px] transition-colors flex items-center gap-1.5"
          >
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Archived records
            <span v-if="currentArchivedRecords.length > 0" class="bg-gray-200 text-gray-600 text-[9px] px-1.5 py-0.5 rounded-full">{{ currentArchivedRecords.length }}</span>
          </button>
          <button 
            @click="archiveTab = 'industries'"
            :class="archiveTab === 'industries' ? 'border-b-2 border-[#F52C11] text-[#F52C11] font-medium' : 'text-gray-500 hover:text-[#1F2835]'"
            class="px-3 py-2 text-[11px] transition-colors flex items-center gap-1.5"
          >
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Archived Industries
            <span v-if="currentArchivedIndustries.length > 0" class="bg-[#F52C11]/10 text-[#F52C11] text-[9px] px-1.5 py-0.5 rounded-full">{{ currentArchivedIndustries.length }}</span>
          </button>
        </div>

        <!-- Search -->
        <div class="px-4 py-2 border-b border-gray-100">
          <div class="relative">
            <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-[6px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input 
              v-model="archiveSearchQuery"
              type="text" 
              :placeholder="archiveTab === 'industries' ? 'Search archived industries...' : 'Search archived records...'" 
              class="w-full pl-8 pr-3 py-1.5 bg-gray-50 border border-gray-200 rounded-[4px] text-[11px] focus:outline-none focus:border-[#F52C11] placeholder:text-gray-400"
            >
          </div>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-auto custom-scroll max-h-[320px] min-h-[150px] p-3">
          <!-- Industries Archive -->
          <div v-if="archiveTab === 'industries'">
            <div v-if="filteredArchivedIndustries.length === 0" class="text-center text-gray-400 py-8 text-[12px]">
              No archived industries
            </div>
            <div v-else class="space-y-2">
              <div 
                v-for="industry in filteredArchivedIndustries" 
                :key="industry"
                class="flex items-center justify-between px-3 py-2.5 bg-gray-50 rounded-[6px] border border-gray-100"
              >
                <div class="flex items-center gap-2">
                  <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                  </svg>
                  <div>
                    <div class="text-[12px] font-medium text-[#1F2835]">{{ industry }}</div>
                    <div class="text-[10px] text-gray-400">Archived recently</div>
                  </div>
                </div>
                <button 
                  @click="restoreIndustry(industry)"
                  class="flex items-center gap-1 text-[11px] text-[#F52C11] hover:text-[#d9250e] font-medium transition-colors"
                >
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                  Restore
                </button>
              </div>
            </div>
          </div>

          <!-- Records Archive -->
          <div v-if="archiveTab === 'records'">
            <div v-if="groupedArchivedRecords.length === 0" class="text-center text-gray-400 py-8 text-[12px]">
              No archived leads
            </div>
            <div v-else class="space-y-5">
              <div v-for="group in groupedArchivedRecords" :key="group.industry" class="space-y-2">
                <!-- Industry Group Divider -->
                <div class="flex items-center gap-2 px-1">
                  <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ group.industry }}</span>
                  <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                
                <div 
                  v-for="record in group.records" 
                  :key="record.id"
                  class="flex items-center justify-between px-3 py-2.5 bg-gray-50 rounded-[6px] border border-gray-100"
                >
                  <div class="flex items-center gap-2.5 min-w-0">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div class="min-w-0">
                      <div class="text-[12px] font-semibold text-[#1F2835] truncate">{{ record.businessName }}</div>
                      <div class="text-[10px] text-gray-400 mt-0.5">
                        {{ record.industry }} • Archived {{ record.archivedDate }} • 
                        <span 
                          class="font-medium"
                          :class="getStatusTextColor(record.status)"
                        >
                          {{ record.status }}
                        </span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="flex items-center gap-2 shrink-0 ml-3">
                    <button 
                      @click="restoreRecord(record.id)"
                      class="flex items-center gap-1 text-[11px] text-[#F52C11] hover:text-[#d9250e] font-medium transition-colors"
                    >
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                      Restore
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-2.5 border-t border-gray-100 flex items-center justify-between bg-gray-50">
          <div class="flex items-center gap-1 text-[10px] text-gray-400">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ archiveTab === 'records' ? 'Restoring moves the record back to its active list' : 'Restoring brings the industry back to the sidebar' }}
          </div>
          <button 
            @click="showArchiveModal = false" 
            class="px-3 py-1 rounded-[4px] text-[11px] font-medium text-gray-500 hover:text-[#1F2835] hover:bg-gray-200 transition-colors"
          >
            Close
          </button>
        </div>
      </div>
    </div>


















<!-- Edit Record Modal -->
<div v-if="showEditModal && editingRecord" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-[2px]">
  <div class="bg-white rounded-[8px] w-[680px] shadow-2xl flex flex-col overflow-hidden">
    
    <!-- Modal Header -->
    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-white">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        <div>
          <h3 class="text-[14px] font-bold text-[#1F2835]">Edit record</h3>
          <p class="text-[10px] text-gray-400">{{ editingRecord.businessName }} – {{ editingRecord.industry }}</p>
        </div>
      </div>
      <button @click="closeEditModal" class="text-gray-400 hover:text-[#1F2835] transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Modal Body - Two Column Layout -->
    <div class="px-5 py-4 bg-white">
      <div class="grid grid-cols-2 gap-x-6 gap-y-3">
        
        <!-- Left Column -->
        <div class="space-y-3">
          <!-- Business name -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Business name <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="editingRecord.businessName"
              type="text" 
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <!-- Contact person -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Contact person <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="editingRecord.contactPerson"
              type="text" 
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <!-- Contact number - Philippine format with permanent dashes -->
<div>
  <label class="block text-[11px] font-medium text-[#1F2835] mb-1">Contact number</label>
  <input 
    v-model="displayContactNo"
    type="text" 
    maxlength="13"
    @input="formatContactNumber"
    @keydown="handleContactKeydown"
    placeholder="0917-123-4567"
    class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
  >
</div>

          <!-- Service -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Service <span class="text-[#F52C11]">*</span>
            </label>
            <div class="relative">
              <select 
                v-model="editingRecord.service"
                class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors appearance-none cursor-pointer"
              >
                <option v-for="svc in serviceOptions.filter(s => s !== 'All Services')" :key="svc" :value="svc">{{ svc }}</option>
              </select>
              <svg class="w-3 h-3 text-[#F52C11] absolute right-2.5 top-[9px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>
          </div>

          <!-- Remarks - Textarea for multi-line -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">Remarks</label>
            <textarea 
              v-model="editingRecord.remarks"
              rows="2"
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors resize-none"
            ></textarea>
          </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-3">
          <!-- Location -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">
              Location <span class="text-[#F52C11]">*</span>
            </label>
            <input 
              v-model="editingRecord.location"
              type="text" 
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <!-- Job position -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">Job position</label>
            <input 
              v-model="editingRecord.jobPosition"
              type="text" 
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <!-- Email -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">Email</label>
            <input 
              v-model="editingRecord.email"
              type="email" 
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <!-- Date - No icon -->
          <div>
            <label class="block text-[11px] font-medium text-[#1F2835] mb-1">Date</label>
            <input 
              v-model="editingRecord.date"
              type="date" 
              class="w-full bg-white border border-gray-300 rounded-[4px] px-2.5 py-1.5 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors"
            >
          </div>

          <!-- Status - Compact with red arrows stepping 0,20,40,60,80,100 -->
          <div>
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-1.5">
                <label class="text-[11px] font-medium text-[#1F2835]">Status</label>
              </div>
              <div class="flex items-center gap-0.5">
                <input 
                  v-model.number="editingRecord.statusPercent"
                  type="number" 
                  min="0"
                  max="100"
                  step="20"
                  class="w-12 bg-white border border-gray-300 rounded-[4px] px-1.5 py-1 text-[11px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors text-right [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                >
                <span class="text-[11px] text-[#1F2835]">%</span>
              </div>
            </div>
            <p class="text-[9px] text-gray-400 mt-1">Progress bar updates automatically</p>
            <!-- Progress bar -->
            <div class="w-full h-[6px] bg-gray-200 rounded-full overflow-hidden mt-1">
              <div 
                class="h-full bg-[#F52C11] rounded-full transition-all duration-300"
                :style="{ width: Math.min(100, Math.max(0, editingRecord.statusPercent || 0)) + '%' }"
              ></div>
            </div>
            <!-- Legend -->
            <p class="text-[9px] text-[#F52C11] mt-1">
              Legend: 20% Rejected, 40% Prospect, 60% Emailed, 80% Called, 100% Client
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-end gap-2 bg-white">
      <button 
        @click="closeEditModal" 
        class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-[#1F2835] bg-white border border-gray-300 hover:bg-gray-50 transition-colors"
      >
        Cancel
      </button>
      <button 
        @click="saveEditChanges"
        class="px-4 py-[6px] rounded-[4px] text-[11px] font-medium text-white bg-[#F52C11] hover:bg-[#d9250e] transition-colors shadow-sm"
      >
        Save changes
      </button>
    </div>
  </div>
</div>














    <!-- Click outside to close dropdowns -->
    <div 
      v-if="showDatePicker || showServicesDropdown || showStatusDropdown || openIndustryMenuIndex !== null"
      class="fixed inset-0 z-40"
      @click="closeAllDropdowns"
    ></div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'

const searchQuery = ref('')
const selectedLocation = ref('Davao')
const selectedIndustry = ref('Healthcare')
const selectedIds = ref([])
const selectedDate = ref('07/03/26')
const selectedService = ref('All Services')
const selectedStatus = ref('All Status')

const showDatePicker = ref(false)
const showServicesDropdown = ref(false)
const showStatusDropdown = ref(false)
const showArchiveModal = ref(false)
const showAddIndustryModal = ref(false)
const archiveTab = ref('records')
const openIndustryMenuIndex = ref(null)













const showEditModal = ref(false)
const editingRecord = ref(null)

const editingIndex = ref(null)
const renameValue = ref('')
const renameInputs = ref([])

const newIndustryName = ref('')
const archiveSearchQuery = ref('')

const serviceOptions = ['All Services', 'Web Development', 'Custom Software', 'Mobile Application', 'Digital Marketing', 'Multimedia', 'Hosting & Server']
const statusOptions = ['All Status', 'Emailed', 'Called', 'Rejected', 'Prospect', 'Client']

// Separate data for each location - each record now has an 'industry' field
const locationData = ref({
  Davao: {
    industries: ['Advertising', 'Beauty', 'E-commerce', 'Education', 'Entertainment', 'Event Management', 'Film', 'Healthcare', 'Logistics', 'Manufacturing', 'Marketing', 'Music', 'Property Management', 'Publishing', 'Shipping', 'Sports', 'Telecommunications'],
    records: [
      { id: 1, date: '06/22/26', businessName: 'GSK Philippines', contactPerson: 'Ana Smith', jobPosition: 'Owner', contactNo: '0917-111-2233', email: 'ana@gsk.ph', service: 'Multimedia', status: 'Called', statusPercent: 50, remarks: 'Interested', location: 'Poblacion', industry: 'Healthcare' },
      { id: 2, date: '06/22/26', businessName: 'Lumina Events', contactPerson: 'Mia Santos', jobPosition: 'OP Manager', contactNo: '0917-011-2233', email: 'mia@lumina.ph', service: 'Hosting & Server', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Dumoy', industry: 'Event Management' },
      { id: 3, date: '06/21/26', businessName: 'Nexora Philippines', contactPerson: 'Atasha Cabrera', jobPosition: 'COO', contactNo: '0917-101-2103', email: 'atasha@nex.ph', service: 'Custom Software', status: 'Prospect', statusPercent: 15, remarks: 'Awaiting budget', location: 'Calinan', industry: 'Technology' },
      { id: 4, date: '06/21/26', businessName: 'Infinity Production', contactPerson: 'Daniel Garcia', jobPosition: 'Producer', contactNo: '0917-101-0000', email: 'daniel@infinity.ph', service: 'Multimedia', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Mintal', industry: 'Film' },
      { id: 5, date: '06/22/26', businessName: 'MediCard Philippines', contactPerson: 'Riza Mallari', jobPosition: 'HR Officer', contactNo: '0917-123-4567', email: 'riza@medic.ph', service: 'Digital Marketing', status: 'Prospect', statusPercent: 15, remarks: 'Awaiting budget', location: 'Bunawan', industry: 'Healthcare' },
      { id: 6, date: '06/22/26', businessName: 'DreamScene', contactPerson: 'Chloe Mendoza', jobPosition: 'Agent', contactNo: '0917-123-5678', email: 'chloe@scene.ph', service: 'Digital Marketing', status: 'Rejected', statusPercent: 10, remarks: 'Not interested', location: 'Maa', industry: 'Entertainment' },
      { id: 7, date: '06/18/26', businessName: 'ElevateMart', contactPerson: 'Marie Carvajal', jobPosition: 'CEO', contactNo: '0917-103-6568', email: 'marie@mart.ph', service: 'Web Development', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Toril', industry: 'E-commerce' },
      { id: 8, date: '06/18/26', businessName: 'Apex Solutions', contactPerson: 'Adrian Ramos', jobPosition: 'Secretary', contactNo: '0917-103-9999', email: 'adri@apex.ph', service: 'Custom Software', status: 'Prospect', statusPercent: 15, remarks: 'Awaiting budget', location: 'Paquibato', industry: 'Logistics' },
      { id: 9, date: '06/23/26', businessName: 'Generika Drugstore', contactPerson: 'Carlo Reyes', jobPosition: 'Marketing Head', contactNo: '0918-907-6514', email: 'reyes@generik.ph', service: 'Digital Marketing', status: 'Rejected', statusPercent: 10, remarks: 'Not interested', location: 'Talomo', industry: 'Healthcare' },
      { id: 10, date: '06/23/26', businessName: 'Elite Vision', contactPerson: 'Angela Castillo', jobPosition: 'Supervisor', contactNo: '0918-907-3102', email: 'angela@vision.ph', service: 'Multimedia', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Matiog', industry: 'Film' },
      { id: 11, date: '06/29/26', businessName: 'OmniTrade', contactPerson: 'Karl Wartz', jobPosition: 'Manager', contactNo: '0918-987-6543', email: 'karl@trade.ph', service: 'Digital Marketing', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Matina', industry: 'E-commerce' },
      { id: 12, date: '07/03/26', businessName: 'BeautyOVO', contactPerson: 'Charm Torres', jobPosition: 'Owner', contactNo: '0920-515-9934', email: 'charm@beauty.ph', service: 'Mobile Application', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Bajada', industry: 'Beauty' },
      { id: 13, date: '06/24/26', businessName: 'ShopNova', contactPerson: 'Andrei Silverio', jobPosition: 'Executive', contactNo: '0920-555-1234', email: 'andrei@nova.ph', service: 'Mobile Application', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Larang', industry: 'E-commerce' },
      // Advertising industry records
      { id: 14, date: '06/25/26', businessName: 'AdMax Media', contactPerson: 'Jose Cruz', jobPosition: 'Director', contactNo: '0917-444-1111', email: 'jose@admax.ph', service: 'Digital Marketing', status: 'Called', statusPercent: 50, remarks: 'Interested', location: 'Poblacion', industry: 'Advertising' },
      { id: 15, date: '06/26/26', businessName: 'Pixel Creative', contactPerson: 'Maria Lim', jobPosition: 'Manager', contactNo: '0917-444-2222', email: 'maria@pixel.ph', service: 'Multimedia', status: 'Prospect', statusPercent: 20, remarks: 'Follow up', location: 'Maa', industry: 'Advertising' },
      // Education industry records
      { id: 16, date: '06/27/26', businessName: 'Bright Academy', contactPerson: 'Pedro Santos', jobPosition: 'Principal', contactNo: '0917-444-3333', email: 'pedro@bright.ph', service: 'Web Development', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Toril', industry: 'Education' },
      { id: 17, date: '06/28/26', businessName: 'LearnFast Inc', contactPerson: 'Anna Reyes', jobPosition: 'Coordinator', contactNo: '0917-444-4444', email: 'anna@learnfast.ph', service: 'Custom Software', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Calinan', industry: 'Education' },
      // Manufacturing industry records
      { id: 18, date: '06/29/26', businessName: 'SteelWorks Corp', contactPerson: 'Robert Tan', jobPosition: 'Supervisor', contactNo: '0917-444-5555', email: 'robert@steel.ph', service: 'Hosting & Server', status: 'Called', statusPercent: 50, remarks: 'Interested', location: 'Bunawan', industry: 'Manufacturing' },
      { id: 19, date: '06/30/26', businessName: 'Green Factory', contactPerson: 'Lisa Gomez', jobPosition: 'Engineer', contactNo: '0917-444-6666', email: 'lisa@green.ph', service: 'Web Development', status: 'Prospect', statusPercent: 15, remarks: 'Awaiting budget', location: 'Dumoy', industry: 'Manufacturing' },
    ],
    archivedIndustries: [],
    archivedRecords: []
  },
  Manila: {
    industries: ['Agriculture', 'Automotive', 'Banking', 'Construction', 'Consulting', 'Energy', 'Fashion', 'Food & Beverage', 'Hospitality', 'Insurance', 'Real Estate', 'Retail', 'Technology', 'Tourism', 'Transportation'],
    records: [
      { id: 101, date: '06/20/26', businessName: 'MetroBank Corp', contactPerson: 'Juan Dela Cruz', jobPosition: 'Branch Manager', contactNo: '0917-222-3333', email: 'juan@metrobank.ph', service: 'Web Development', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Makati', industry: 'Banking' },
      { id: 102, date: '06/19/26', businessName: 'SM Retail Inc', contactPerson: 'Maria Santos', jobPosition: 'Marketing Director', contactNo: '0917-333-4444', email: 'maria@smretail.ph', service: 'Digital Marketing', status: 'Called', statusPercent: 50, remarks: 'Interested', location: 'Ortigas', industry: 'Retail' },
      { id: 103, date: '06/18/26', businessName: 'Ayala Land', contactPerson: 'Pedro Reyes', jobPosition: 'Sales Head', contactNo: '0917-444-5555', email: 'pedro@ayala.ph', service: 'Custom Software', status: 'Prospect', statusPercent: 15, remarks: 'Awaiting budget', location: 'BGC', industry: 'Real Estate' },
      { id: 104, date: '06/17/26', businessName: 'Jollibee Foods', contactPerson: 'Ana Lim', jobPosition: 'IT Manager', contactNo: '0917-555-6666', email: 'ana@jollibee.ph', service: 'Mobile Application', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Quezon City', industry: 'Food & Beverage' },
      { id: 105, date: '06/16/26', businessName: 'PLDT Inc', contactPerson: 'Roberto Tan', jobPosition: 'CTO', contactNo: '0917-666-7777', email: 'roberto@pldt.ph', service: 'Hosting & Server', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Makati', industry: 'Technology' },
      { id: 106, date: '06/15/26', businessName: 'San Miguel Corp', contactPerson: 'Carmen Go', jobPosition: 'Digital Head', contactNo: '0917-777-8888', email: 'carmen@smc.ph', service: 'Multimedia', status: 'Rejected', statusPercent: 10, remarks: 'Not interested', location: 'Ortigas', industry: 'Food & Beverage' },
      { id: 107, date: '06/14/26', businessName: 'BDO Unibank', contactPerson: 'Luis Garcia', jobPosition: 'Operations Manager', contactNo: '0917-888-9999', email: 'luis@bdo.ph', service: 'Digital Marketing', status: 'Prospect', statusPercent: 15, remarks: 'Awaiting budget', location: 'BGC', industry: 'Banking' },
      { id: 108, date: '06/13/26', businessName: 'Meralco', contactPerson: 'Elena Cruz', jobPosition: 'Project Lead', contactNo: '0917-999-0000', email: 'elena@meralco.ph', service: 'Web Development', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Quezon City', industry: 'Energy' },
      { id: 109, date: '06/12/26', businessName: 'Globe Telecom', contactPerson: 'Miguel Torres', jobPosition: 'Innovation Head', contactNo: '0918-111-2222', email: 'miguel@globe.ph', service: 'Custom Software', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Makati', industry: 'Technology' },
      { id: 110, date: '06/11/26', businessName: 'Megaworld', contactPerson: 'Sofia Reyes', jobPosition: 'Brand Manager', contactNo: '0918-222-3333', email: 'sofia@megaworld.ph', service: 'Mobile Application', status: 'Called', statusPercent: 50, remarks: 'Interested', location: 'Ortigas', industry: 'Real Estate' },
      // Agriculture industry records
      { id: 111, date: '06/25/26', businessName: 'AgriGrow Inc', contactPerson: 'Manuel Cruz', jobPosition: 'Farmer', contactNo: '0918-333-4444', email: 'manuel@agrigrow.ph', service: 'Web Development', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Quezon City', industry: 'Agriculture' },
      { id: 112, date: '06/26/26', businessName: 'GreenHarvest', contactPerson: 'Cecilia Lim', jobPosition: 'Supervisor', contactNo: '0918-333-5555', email: 'cecilia@green.ph', service: 'Custom Software', status: 'Prospect', statusPercent: 20, remarks: 'Follow up', location: 'Makati', industry: 'Agriculture' },
      // Automotive industry records
      { id: 113, date: '06/27/26', businessName: 'AutoMax Dealers', contactPerson: 'Ricardo Reyes', jobPosition: 'Sales Manager', contactNo: '0918-333-6666', email: 'ricardo@automax.ph', service: 'Digital Marketing', status: 'Called', statusPercent: 50, remarks: 'Interested', location: 'BGC', industry: 'Automotive' },
      { id: 114, date: '06/28/26', businessName: 'Speed Motors', contactPerson: 'Patricia Tan', jobPosition: 'Director', contactNo: '0918-333-7777', email: 'patricia@speed.ph', service: 'Multimedia', status: 'Client', statusPercent: 100, remarks: 'Signed contract', location: 'Ortigas', industry: 'Automotive' },
      // Construction industry records
      { id: 115, date: '06/29/26', businessName: 'BuildRight Corp', contactPerson: 'Fernando Go', jobPosition: 'Engineer', contactNo: '0918-333-8888', email: 'fernando@build.ph', service: 'Web Development', status: 'Prospect', statusPercent: 15, remarks: 'Awaiting budget', location: 'Makati', industry: 'Construction' },
      { id: 116, date: '06/30/26', businessName: 'Solid Foundations', contactPerson: 'Diana Santos', jobPosition: 'Architect', contactNo: '0918-333-9999', email: 'diana@solid.ph', service: 'Hosting & Server', status: 'Emailed', statusPercent: 30, remarks: 'Sent proposal', location: 'Quezon City', industry: 'Construction' },
    ],
    archivedIndustries: [],
    archivedRecords: []
  }
})

// Computed for current location
const currentIndustries = computed(() => locationData.value[selectedLocation.value].industries)
const currentRecords = computed(() => locationData.value[selectedLocation.value].records)
const currentArchivedIndustries = computed(() => locationData.value[selectedLocation.value].archivedIndustries)
const currentArchivedRecords = computed(() => locationData.value[selectedLocation.value].archivedRecords)

// Sorted industries alphabetically
const sortedIndustries = computed(() => {
  return [...currentIndustries.value].sort((a, b) => a.localeCompare(b))
})

const filteredRecords = computed(() => {
  let result = currentRecords.value
  
  // Filter by selected industry first
  result = result.filter(r => r.industry === selectedIndustry.value)
  
  const q = searchQuery.value.trim().toLowerCase()
  if (q) {
    result = result.filter(r => Object.values(r).some(v => String(v).toLowerCase().includes(q)))
  }
  
  if (selectedService.value !== 'All Services') {
    result = result.filter(r => r.service === selectedService.value)
  }
  
  if (selectedStatus.value !== 'All Status') {
    result = result.filter(r => r.status === selectedStatus.value)
  }
  
  return result
})

const filteredArchivedIndustries = computed(() => {
  const q = archiveSearchQuery.value.trim().toLowerCase()
  if (!q) return currentArchivedIndustries.value
  return currentArchivedIndustries.value.filter(i => i.toLowerCase().includes(q))
})

const filteredArchivedRecords = computed(() => {
  const q = archiveSearchQuery.value.trim().toLowerCase()
  if (!q) return currentArchivedRecords.value
  return currentArchivedRecords.value.filter(r => 
    r.businessName.toLowerCase().includes(q) || 
    r.contactPerson.toLowerCase().includes(q)
  )
})

// Group archived records by industry, sorted alphabetically
const groupedArchivedRecords = computed(() => {
  const filtered = filteredArchivedRecords.value
  const groups = {}
  filtered.forEach(record => {
    if (!groups[record.industry]) groups[record.industry] = []
    groups[record.industry].push(record)
  })
  const sortedIndustryNames = Object.keys(groups).sort((a, b) => a.localeCompare(b))
  return sortedIndustryNames.map(industry => ({
    industry,
    records: groups[industry].sort((a, b) => a.businessName.localeCompare(b.businessName))
  }))
})

const selectedCount = computed(() => selectedIds.value.length)
const isAllSelected = computed(() => {
  return filteredRecords.value.length > 0 && filteredRecords.value.every(r => selectedIds.value.includes(r.id))
})

// Calendar
const currentMonth = ref(new Date().getMonth())
const currentYear = ref(new Date().getFullYear())

const currentMonthYear = computed(() => {
  const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
  return `${months[currentMonth.value]} ${currentYear.value}`
})

const calendarDays = computed(() => {
  const days = []
  const firstDay = new Date(currentYear.value, currentMonth.value, 1).getDay()
  const daysInMonth = new Date(currentYear.value, currentMonth.value + 1, 0).getDate()
  const daysInPrevMonth = new Date(currentYear.value, currentMonth.value, 0).getDate()
  
  for (let i = firstDay - 1; i >= 0; i--) {
    days.push({ day: daysInPrevMonth - i, isCurrentMonth: false, date: null })
  }
  
  for (let i = 1; i <= daysInMonth; i++) {
    const dateStr = `${String(currentMonth.value + 1).padStart(2, '0')}/${String(i).padStart(2, '0')}/${String(currentYear.value).slice(-2)}`
    days.push({ 
      day: i, 
      isCurrentMonth: true, 
      date: dateStr,
      isSelected: selectedDate.value === dateStr
    })
  }
  
  const remaining = 42 - days.length
  for (let i = 1; i <= remaining; i++) {
    days.push({ day: i, isCurrentMonth: false, date: null })
  }
  
  return days
})

function prevMonth() {
  if (currentMonth.value === 0) {
    currentMonth.value = 11
    currentYear.value--
  } else {
    currentMonth.value--
  }
}

function nextMonth() {
  if (currentMonth.value === 11) {
    currentMonth.value = 0
    currentYear.value++
  } else {
    currentMonth.value++
  }
}

function selectDate(date) {
  if (date) {
    selectedDate.value = date
    showDatePicker.value = false
  }
}

function switchLocation(location) {
  selectedLocation.value = location
  selectedIds.value = []
  // Select first industry of new location
  const firstIndustry = sortedIndustries.value[0] || ''
  selectedIndustry.value = firstIndustry
}

function isSelected(id) {
  return selectedIds.value.includes(id)
}

function toggleSelection(id) {
  const idx = selectedIds.value.indexOf(id)
  if (idx > -1) {
    selectedIds.value.splice(idx, 1)
  } else {
    selectedIds.value.push(id)
  }
}

function toggleAll() {
  const visibleIds = filteredRecords.value.map(r => r.id)
  const allVisibleSelected = visibleIds.every(id => selectedIds.value.includes(id))
  
  if (allVisibleSelected) {
    selectedIds.value = selectedIds.value.filter(id => !visibleIds.includes(id))
  } else {
    const newIds = visibleIds.filter(id => !selectedIds.value.includes(id))
    selectedIds.value.push(...newIds)
  }
}

function toggleIndustryMenu(index) {
  if (openIndustryMenuIndex.value === index) {
    openIndustryMenuIndex.value = null
  } else {
    openIndustryMenuIndex.value = index
  }
}
 














function openEditModal(record) {
  editingRecord.value = { ...record } // clone to avoid direct mutation
  showEditModal.value = true
}

function closeEditModal() {
  showEditModal.value = false
  editingRecord.value = null
}

function saveEditChanges() {
  if (!editingRecord.value) return
  
  const idx = currentRecords.value.findIndex(r => r.id === editingRecord.value.id)
  if (idx > -1) {
    currentRecords.value[idx] = { ...editingRecord.value }
  }
  closeEditModal()
}

















// Store each rename input element by its index
function setRenameInput(el, index) {
  if (el) {
    renameInputs.value[index] = el
  }
}

// Inline rename with auto-highlight
function startInlineRename(industry, index) {
  renameValue.value = industry
  editingIndex.value = index
  openIndustryMenuIndex.value = null
  nextTick(() => {
    const input = renameInputs.value[index]
    if (input) {
      input.focus()
      input.select()
    }
  })
}

function finishRename(index) {
  if (renameValue.value.trim()) {
    const oldName = currentIndustries.value[index]
    currentIndustries.value[index] = renameValue.value.trim()
    if (selectedIndustry.value === oldName) {
      selectedIndustry.value = renameValue.value.trim()
    }
  }
  editingIndex.value = null
  renameValue.value = ''
}

function cancelRename() {
  editingIndex.value = null
  renameValue.value = ''
}

function archiveIndustry(industry) {
  const idx = currentIndustries.value.indexOf(industry)
  if (idx > -1) {
    currentIndustries.value.splice(idx, 1)
    currentArchivedIndustries.value.push(industry)
    if (selectedIndustry.value === industry) {
      selectedIndustry.value = sortedIndustries.value[0] || ''
    }
  }
  openIndustryMenuIndex.value = null
}

function restoreIndustry(industry) {
  const idx = currentArchivedIndustries.value.indexOf(industry)
  if (idx > -1) {
    currentArchivedIndustries.value.splice(idx, 1)
    currentIndustries.value.push(industry)
  }
}

function addIndustry() {
  if (newIndustryName.value.trim()) {
    currentIndustries.value.push(newIndustryName.value.trim())
    newIndustryName.value = ''
    showAddIndustryModal.value = false
  }
}

function archiveSelectedRecords() {
  const now = new Date()
  const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
  const toArchive = currentRecords.value.filter(r => selectedIds.value.includes(r.id)).map(r => ({
    ...r,
    archivedDate: dateStr
  }))
  currentArchivedRecords.value.push(...toArchive)
  const idsToRemove = new Set(selectedIds.value)
  locationData.value[selectedLocation.value].records = currentRecords.value.filter(r => !idsToRemove.has(r.id))
  selectedIds.value = []
}

function restoreRecord(id) {
  const idx = currentArchivedRecords.value.findIndex(r => r.id === id)
  if (idx > -1) {
    const record = currentArchivedRecords.value.splice(idx, 1)[0]
    currentRecords.value.push(record)
  }
}

function closeAllDropdowns() {
  showDatePicker.value = false
  showServicesDropdown.value = false
  showStatusDropdown.value = false
  openIndustryMenuIndex.value = null
}

function getStatusTextColor(status) {
  const map = {
    'Client': 'text-green-600',
    'Called': 'text-orange-500',
    'Prospect': 'text-red-500',
    'Emailed': 'text-blue-500',
    'Rejected': 'text-red-500'
  }
  return map[status] || 'text-gray-500'
}

function getStatusBarColor(status) {
  const map = {
    'Client': 'bg-[#639922]',
    'Called': 'bg-[#fa6f10]',
    'Prospect': 'bg-[#888780]',
    'Emailed': 'bg-[#378add]',
    'Rejected': 'bg-[#e24b4a]'
  }
  return map[status] || 'bg-gray-400'
}

function getStatusBadgeClass(status) {
  const map = {
    'Client': 'bg-green-50 text-green-700 border-green-200',
    'Called': 'bg-orange-50 text-orange-700 border-orange-200',
    'Prospect': 'bg-gray-100 text-gray-700 border-gray-200',
    'Emailed': 'bg-blue-50 text-blue-700 border-blue-200',
    'Rejected': 'bg-red-50 text-red-700 border-red-200'
  }
  return map[status] || 'bg-gray-100 text-gray-700 border-gray-200'
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap');

.custom-scroll::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
table th,
table td {
  border-left: none !important;
  border-right: none !important;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: #F52C11;
  border-radius: 3px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #d9250e;
}

input[type="checkbox"] {
  accent-color: #F52C11;
}
</style>