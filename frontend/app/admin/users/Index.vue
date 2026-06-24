<template>
  <aside class="w-64 h-screen bg-[#1f2835] text-white flex flex-col font-overpass select-none border-r border-[#2d3748]/30">
    
    <!-- Header -->
    <div class="p-4 border-b border-[#2d3748]/50 flex items-center space-x-3 bg-[#171c24]">
      <img src="/Rweb logo.png" alt="RWEB Solutions Logo" class="w-10 h-10 object-contain rounded bg-white p-0.5" />
      <div>
        <h2 class="text-white text-xs font-bold tracking-wider uppercase leading-tight">RWEB SOLUTIONS INC.</h2>
        <p class="text-[10px] text-gray-400 font-medium tracking-wide">Sales & Marketing MS</p>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-6">
      
      <!-- My Modules -->
      <div>
        <span class="px-3 text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">My Modules</span>
        <ul class="space-y-1">
          
          <!-- User Management -->
          <li>
            <a 
              href="#" 
              @click.prevent="activeItem = 'user-management'"
              :class="activeItem === 'user-management' ? 'bg-[#f52c11]/20 text-white' : 'hover:text-white'"
              class="flex items-center space-x-3 px-3 py-2 rounded text-sm transition-colors"
            >
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
              </svg>
              <span>User Management</span>
            </a>
          </li>

          <!-- Leads Tracker -->
          <li class="space-y-1">
            <div 
              @click="toggleLeadsTracker"
              :class="activeItem === 'leads-tracker' ? 'bg-[#f52c11]/20 text-white' : 'hover:text-white'"
              class="w-full flex items-center justify-between px-3 py-2 rounded text-sm cursor-pointer transition-colors"
            >
              <div class="flex items-center space-x-3">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="font-medium">Leads Tracker</span>
              </div>
              <svg 
                :class="isLeadsTrackerOpen ? 'rotate-180' : ''"
                class="w-3 h-3 text-white transition-transform duration-200"
                fill="none" 
                stroke="currentColor" 
                stroke-width="2" 
                viewBox="0 0 24 24"
              >
                <path d="M5 15l7-7 7 7"/>
              </svg>
            </div>

            <!-- Leads Tracker Sub-menu -->
            <ul 
              v-show="isLeadsTrackerOpen"
              class="pl-6 space-y-2 mt-1"
            >
              <!-- Leads (nested toggle) -->
              <li class="space-y-2">
                <div 
                  @click="isLeadsOpen = !isLeadsOpen; activeItem = 'leads'"
                  :class="activeItem === 'leads' ? 'bg-[#f52c11]/20 text-white' : 'hover:text-white'"
                  class="w-full flex items-center justify-between px-3 py-1.5 rounded text-sm cursor-pointer transition-colors"
                >
                  <span>Leads</span>
                  <svg 
                    :class="isLeadsOpen ? 'rotate-180' : ''"
                    class="w-3 h-3 text-white transition-transform duration-200"
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    viewBox="0 0 24 24"
                  >
                    <path d="M5 15l7-7 7 7"/>
                  </svg>
                </div>

                <!-- Leads Sub-menu (Industry) -->
                <ul 
                  v-show="isLeadsOpen"
                  class="space-y-2 mt-1"
                >
                  <li>
                    <a 
                      href="#" 
                      @click.prevent="activeItem = 'industry'"
                      :class="activeItem === 'industry' ? 'bg-[#f52c11]/20 text-white' : 'hover:text-white'"
                      class="block px-3 py-1.5 rounded text-xs transition-colors"
                    >
                      Industry
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Performance Improvement Plan -->
              <li>
                <a 
                  href="#" 
                  @click.prevent="activeItem = 'performance-improvement'"
                  :class="activeItem === 'performance-improvement' ? 'bg-[#f52c11]/20 text-white' : 'hover:text-white'"
                  class="block px-3 py-1.5 rounded text-xs transition-colors leading-snug"
                >
                  Performance Improvement Plan
                </a>
              </li>
            </ul>
          </li>

          <!-- Sales Task -->
          <li>
            <a 
              href="#" 
              @click.prevent="activeItem = 'sales-task'"
              :class="activeItem === 'sales-task' ? 'bg-[#f52c11]/20 text-white' : 'hover:text-white'"
              class="flex items-center space-x-3 px-3 py-2 rounded text-sm transition-colors"
            >
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span>Sales Task</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Others -->
      <div>
        <span class="px-3 text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Others</span>
        <ul class="space-y-1">
          <li>
            <a 
              href="#" 
              @click.prevent="activeItem = 'audit-logs'"
              :class="activeItem === 'audit-logs' ? 'bg-[#f52c11]/20 text-white' : 'hover:text-white'"
              class="flex items-center space-x-3 px-3 py-2 rounded text-sm transition-colors"
            >
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <span>Audit Logs</span>
            </a>
          </li>
        </ul>
      </div>

    </nav>

    <!-- Admin Account Footer (Compact) -->
    <div class="px-3 py-3 border-t border-[#FFFFFFFF]/25 flex items-center space-x-2 bg-[#1F2835]">
      <div class="w-7 h-7 rounded-full bg-[#1F2835] bg-[#ffffffff] flex items-center justify-center text-[#CC3300] font-bold font-overpass text-s">
        SA
      </div>
      <div>
        <p class="text-white text-[13px] font-overpass font-medium">Super Admin</p>
        <p class="text-[9px] font-overpass font-[13px] text-gray-400">super@company.com</p>
      </div>
    </div>

  </aside>
</template>

<script setup>
import { ref } from 'vue'

const isLeadsTrackerOpen = ref(false)
const isLeadsOpen = ref(false)
const activeItem = ref('user-management')

function toggleLeadsTracker() {
  isLeadsTrackerOpen.value = !isLeadsTrackerOpen.value
  if (!isLeadsTrackerOpen.value) {
    isLeadsOpen.value = false
  }
  activeItem.value = 'leads-tracker'
}
</script>