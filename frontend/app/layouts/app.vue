<template>
  <div class="h-screen w-screen flex bg-[#F8FAFC] text-[#1F2835] font-sans overflow-hidden box-border select-none m-0 p-0">
    
    <aside class="w-[260px] h-full bg-[#1F2835] flex flex-col justify-between text-gray-300 border-r border-[#2A374A] flex-shrink-0">
      <div>
        <div class="p-5 flex items-center gap-3 border-b border-[#2A374A]">
          <div class="w-10 h-10 bg-white rounded flex items-center justify-center overflow-hidden flex-shrink-0 p-1">
            <img src="/Rweb logo.png" alt="Logo" class="max-w-full max-h-full object-contain">
          </div>
          <div>
            <h2 class="text-white text-sm font-bold tracking-wide uppercase leading-tight">RWEB SOLUTIONS INC.</h2>
            <p class="text-[11px] text-gray-400">Sales & Marketing MS</p>
          </div>
        </div>

        <nav class="p-4 space-y-6">
          <div>
            <p class="text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-2 px-3">My Modules</p>
            <ul class="space-y-1">
              <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm rounded hover:bg-[#2A374A] transition-colors">
                  <i class="fa-solid fa-users-gear text-xs"></i> User Management
                </a>
              </li>
              <li>
                <div class="px-3 py-2 text-sm rounded bg-[#2A374A] text-white flex items-center justify-between cursor-pointer">
                  <span class="flex items-center gap-3">
                    <i class="fa-solid fa-chart-line text-xs"></i> Leads Tracker
                  </span>
                  <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
                <ul class="pl-7 mt-1 space-y-1 text-xs">
                  <li>
                    <a href="#" class="block px-3 py-2 rounded bg-[#F25C11] text-white font-medium">Leads</a>
                  </li>
                  <li>
                    <a href="#" class="block px-3 py-2 rounded text-gray-400 hover:text-white hover:bg-[#334257]">Industry</a>
                  </li>
                  <li>
                    <a href="#" class="block px-3 py-2 rounded text-gray-400 hover:text-white hover:bg-[#334257]">Performance Improvement Plan</a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm rounded hover:bg-[#2A374A] transition-colors">
                  <i class="fa-solid fa-wallet text-xs"></i> Sales Task
                </a>
              </li>
            </ul>
          </div>

          <div>
            <p class="text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-2 px-3">Others</p>
            <ul class="space-y-1">
              <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm rounded hover:bg-[#2A374A] transition-colors">
                  <i class="fa-solid fa-file-invoice text-xs"></i> Audit Logs
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </aside>

    <main class="flex-1 h-full flex flex-col overflow-hidden">
      
      <header class="h-[70px] bg-white border-b border-gray-200 px-8 flex items-center justify-between flex-shrink-0">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Leads Listing</h1>
        
        <div class="flex items-center gap-4">
          <div class="relative w-[320px]">
            <input type="text" placeholder="Search" class="w-full h-9 pl-4 pr-10 border border-gray-300 bg-gray-50 rounded-full text-sm outline-none focus:border-gray-400">
            <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
          </div>
          <button class="h-9 px-4 bg-white border border-red-200 text-[#F52C11] font-semibold text-xs rounded shadow-sm hover:bg-red-50 flex items-center gap-2 transition-colors">
            <span class="text-base font-normal">+</span> Add Record
          </button>
        </div>
      </header>

      <div class="flex-1 flex overflow-hidden p-6 gap-6">
        
        <section class="w-[280px] h-full flex flex-col gap-4 flex-shrink-0 overflow-y-auto pr-1">
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Location</label>
            <select class="w-full h-9 border border-gray-300 rounded bg-gray-50 px-3 text-xs outline-none focus:border-gray-400 shadow-sm">
              <option>Davao</option>
            </select>
          </div>

          <div class="flex-1 bg-white border border-gray-300 rounded p-3 flex flex-col shadow-sm min-h-0">
            <p class="text-xs font-semibold text-center text-gray-500 mb-3 border-b pb-2">Select Industry</p>
            <div class="flex-1 overflow-y-auto space-y-1 pr-1 custom-scrollbar">
              <div v-for="n in 25" :key="n" class="px-3 py-1.5 border border-gray-200 text-xs rounded text-gray-700 font-medium hover:bg-gray-50 cursor-pointer">
                Food Industry
              </div>
            </div>
            <button class="w-full h-8 mt-3 bg-white border border-red-100 text-[#F52C11] font-semibold text-[11px] rounded hover:bg-red-50 flex items-center justify-center gap-1">
              <span class="text-sm font-normal">+</span> Add Industry
            </button>
          </div>
        </section>

        <section class="flex-1 h-full bg-white border border-gray-300 rounded flex flex-col overflow-hidden shadow-sm">
          <div class="flex-1 overflow-auto custom-scrollbar">
            <table class="w-full border-collapse text-left text-xs">
              <thead class="bg-gray-50 border-b border-gray-300 sticky top-0 z-10 font-bold text-gray-700 text-[13px]">
                <tr>
                  <th class="p-3 border-r border-gray-200">Business Name</th>
                  <th class="p-3 border-r border-gray-200">Contact Person</th>
                  <th class="p-3 border-r border-gray-200">Job Position</th>
                  <th class="p-3 border-r border-gray-200">Contact Number</th>
                  <th class="p-3">Email</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 text-gray-600">
                <tr v-for="n in 25" :key="n" class="hover:bg-slate-50 transition-colors">
                  <td class="p-3 border-r border-gray-100 font-medium">First Middle Last</td>
                  <td class="p-3 border-r border-gray-100">First Middle Last</td>
                  <td class="p-3 border-r border-gray-100">Cold Calling</td>
                  <td class="p-3 border-r border-gray-100 tracking-wide">0123456789</td>
                  <td class="p-3 text-blue-600 font-medium underline cursor-pointer hover:text-blue-800">firstmiddlelast@gmail.com</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

      </div>
    </main>
  </div>
</template>

<style scoped>
.font-sans {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

/* Custom Scrollbar formatting to keep the layout extremely clean */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #CBD5E1;
  border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #94A3B8;
}
</style>