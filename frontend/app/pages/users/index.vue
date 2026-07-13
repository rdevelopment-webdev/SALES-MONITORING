<template>
  <div
    class="flex flex-col min-w-0 overflow-hidden bg-[#f4f6fa] font-['Overpass'] text-[14px] text-[#1F2835] h-screen"
  >
    <div
      class="bg-white px-6 py-2.5 flex items-center shrink-0 border-b border-gray-200 shadow-sm z-30"
    >
      <div class="flex items-center text-[12px] text-gray-500 gap-1.5">
        <svg
          class="w-4 h-4 text-[#f52c11]"
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
        <span
          class="text-[#f52c11] cursor-pointer font-medium transition-colors"
          >User Management</span
        >
      </div>
    </div>

    <div
      class="bg-[#f4f6fa] px-8 py-6 flex items-center justify-between shrink-0 flex-wrap gap-4"
    >
      <div>
        <h1 class="font-bold text-[20px] tracking-tight text-[#1F2835]">
          System Users
        </h1>
        <span class="text-[12px] text-gray-400 mt-0.5 block">
          {{ filteredUsers.length }} users total · {{ adminCount }} admins ·
          {{ salesCount }} sales
        </span>
      </div>

      <div class="flex items-center gap-3">
        <div class="relative flex items-center">
          <svg
            class="w-4 h-4 text-gray-400 absolute left-3 pointer-events-none"
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
            class="pl-9 pr-3 py-1.5 w-64 bg-white border border-gray-200 rounded-[6px] focus:outline-none focus:border-[#F52C11] text-[12px] placeholder:text-gray-400 transition-colors shadow-sm"
          />
        </div>

        <button
          @click="openArchiveModal"
          class="bg-white border border-gray-200 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-4 py-1.5 rounded-[6px] text-[12px] font-medium flex items-center gap-2 transition-colors shadow-sm"
        >
          <svg
            class="w-4 h-4 text-[#f52c11]"
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
            v-if="archivedUsers.length > 0"
            class="bg-[#F52C11] text-white text-[10px] px-2 py-[1px] rounded-full font-bold ml-0.5"
          >
            {{ archivedUsers.length }}
          </span>
        </button>

        <button
          @click="navigateToAddUser"
          class="bg-[#F52C11] hover:bg-[#d9250e] text-white px-4 py-1.5 rounded-[6px] text-[12px] font-medium flex items-center gap-1.5 transition-colors shadow-sm"
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
              d="M12 4v16m8-8H4"
            />
          </svg>
          Add user
        </button>
      </div>
    </div>

    <main
      class="flex-1 flex flex-col px-8 pb-4 gap-4 min-h-0 overflow-hidden bg-[#f4f6fa]"
    >
      <section
        class="flex-1 flex flex-col min-w-0 bg-white overflow-hidden relative rounded-[12px] shadow-sm border border-gray-100"
      >
        <div
          v-if="isLoading"
          class="absolute inset-0 bg-white/70 z-40 flex items-center justify-center"
        >
          <span class="text-[#F52C11] font-medium text-[13px]"
            >Loading data...</span
          >
        </div>

        <div class="flex-1 overflow-auto custom-scroll relative">
          <table class="w-full border-collapse text-left">
            <thead
              class="bg-[#f8fafc] sticky top-0 z-20 border-b border-gray-100"
            >
              <tr>
                <th class="w-12 px-3 py-1.5 text-center">
                  <input
                    type="checkbox"
                    :checked="isAllSelected"
                    @change="toggleAll"
                    class="w-3.5 h-3.5 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  />
                </th>
                <th
                  class="px-3 py-1.5 font-bold text-[13px] whitespace-nowrap text-[#1F2835]"
                >
                  Full Name
                </th>
                <th
                  class="px-3 py-1.5 font-bold text-[13px] whitespace-nowrap text-[#1F2835]"
                >
                  Email
                </th>
                <th
                  class="px-3 py-1.5 font-bold text-[13px] whitespace-nowrap text-[#1F2835]"
                >
                  Role
                </th>
                <th
                  class="px-3 py-1.5 font-bold text-[13px] whitespace-nowrap text-[#1F2835]"
                >
                  Date added
                </th>
                <th
                  class="px-4 py-1.5 font-bold text-[13px] whitespace-nowrap text-[#1F2835] text-center w-28"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr
                v-for="user in paginatedUsers"
                :key="user.id"
                class="transition-colors bg-white hover:bg-[#f8fafc]"
                :class="{ 'bg-[#F52C11]/5': isSelected(user.id) }"
              >
                <td class="px-3 py-1.5 text-center">
                  <input
                    type="checkbox"
                    :checked="isSelected(user.id)"
                    @change="toggleSelection(user.id)"
                    class="w-3.5 h-3.5 rounded border-gray-300 text-[#F52C11] focus:ring-[#F52C11] cursor-pointer"
                  />
                </td>

                <td
                  class="px-3 py-1.5 whitespace-nowrap text-[12.5px] text-[#1F2835]"
                >
                  {{ user.name || user.full_name || user.fullName }}
                </td>

                <td
                  class="px-3 py-1.5 whitespace-nowrap text-[12.5px] text-[#1F2835]"
                >
                  {{ user.email }}
                </td>

                <td class="px-3 py-1.5 whitespace-nowrap">
                  <span
                    class="inline-flex items-center px-2.5 py-[2px] rounded-[6px] text-[11px] font-semibold tracking-wide"
                    :class="getRoleBadgeClass(user.role)"
                  >
                    {{ user.role?.role_name || user.role || "No Role" }}
                  </span>
                </td>

                <td
                  class="px-3 py-1.5 whitespace-nowrap text-[12.5px] text-gray-500"
                >
                  {{ formatDate(user.created_at || user.dateAdded) }}
                </td>

                <td class="px-4 py-1.5 whitespace-nowrap">
                  <div class="flex items-center justify-center gap-2">
                    <button
                      @click="goToEditUser(user)"
                      class="p-1.5 text-gray-400 hover:text-[#F52C11] border border-gray-200 rounded-[6px] bg-white transition-colors hover:shadow-sm"
                      title="Edit"
                      aria-label="Edit user"
                    >
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                      </svg>
                    </button>
                    <button
                      @click="openResetPasswordModal(user)"
                      class="relative p-1.5 text-gray-400 hover:text-amber-500 border border-gray-200 rounded-[6px] bg-white transition-colors hover:shadow-sm"
                      :title="
                        user.passwordChanged
                          ? 'User changed password - Click to reset'
                          : 'Reset password'
                      "
                    >
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                        />
                      </svg>
                      <span
                        v-if="user.passwordChanged"
                        class="absolute top-1 right-1 w-1.5 h-1.5 bg-red-500 rounded-full border border-white"
                      ></span>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>

    <footer
      class="shrink-0 bg-[#f8fafc] px-8 pb-6 pt-2 flex flex-col gap-2.5 border-t border-gray-200/40 z-20"
    >
      <div
        v-if="selectedCount > 0"
        class="w-full h-[42px] px-2 bg-[#f8fafc] flex items-center justify-between border-b border-gray-100"
      >
        <div class="flex items-center gap-2 text-[12.5px] text-[#1F2835]">
          <svg
            class="w-4 h-4 text-[#F52C11]"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 9v4m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"
            />
          </svg>

          <span class="font-normal">
            <span class="font-medium">{{ selectedCount }}</span>
            {{ selectedCount === 1 ? "user" : "users" }} selected
          </span>
        </div>

        <button
          @click="archiveSelectedUsers"
          class="flex items-center gap-1.5 bg-[#F52C11] hover:bg-[#d9250e] text-white px-3 py-1.5 rounded-[6px] text-[12px] font-medium transition-colors shadow-sm"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-3.5 h-3.5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M4 7h16M6 7V5a1 1 0 011-1h10a1 1 0 011 1v2m-1 0v11a1 1 0 01-1 1H7a1 1 0 01-1-1V7"
            />
          </svg>

          <span>Archive selected</span>
        </button>
      </div>

      <div
        class="flex items-center justify-between px-2 text-[12px] text-gray-400 select-none"
      >
        <div>
          Page
          <span class="font-bold text-[#1F2835]">{{ currentPage }}</span> of
          <span class="font-bold text-[#1F2835]">{{ totalPages }}</span>
        </div>

        <div class="flex items-center gap-2">
          <span>Go to page</span>
          <input
            v-model.number="goToPageInput"
            type="number"
            min="1"
            :max="totalPages"
            class="w-14 text-center bg-white border border-gray-200 rounded-[6px] py-1 text-[12px] text-[#1F2835] focus:outline-none focus:border-[#F52C11] transition-colors shadow-sm"
            @keyup.enter="handleGoToPage"
          />
          <button
            @click="handleGoToPage"
            class="bg-white border border-gray-200 hover:border-[#F52C11] hover:text-[#F52C11] text-[#1F2835] px-4 py-1 rounded-[6px] font-medium transition-colors shadow-sm bg-gradient-to-b from-white to-gray-50/50"
          >
            Go
          </button>
        </div>

        <div class="flex items-center gap-1.5">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="w-7 h-7 flex items-center justify-center rounded-[6px] border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 disabled:opacity-40 disabled:hover:bg-white disabled:cursor-not-allowed transition-colors shadow-sm"
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
            v-for="page in totalPages"
            :key="page"
            @click="currentPage = page"
            :class="
              currentPage === page
                ? 'bg-[#FFFFFF] text-black shadow-sm font-bold'
                : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 shadow-sm'
            "
            class="w-7 h-7 flex items-center justify-center rounded-[6px] text-[12px] transition-colors"
          >
            {{ page }}
          </button>

          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="w-7 h-7 flex items-center justify-center rounded-[6px] border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 disabled:opacity-40 disabled:hover:bg-white disabled:cursor-not-allowed transition-colors shadow-sm"
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
    </footer>
  </div>

  <div
    v-if="showResetPasswordModal && resettingUser"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-[2px]"
  >
    <div
      class="bg-white rounded-[12px] w-[480px] shadow-2xl flex flex-col overflow-hidden"
    >
      <div
        class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white"
      >
        <h3 class="text-[15px] font-bold text-[#1F2835]">Reset Password</h3>
        <button
          @click="closeResetPasswordModal"
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

      <div class="px-6 py-5 bg-white space-y-4">
        <div>
          <label class="block text-[12px] font-medium text-[#1F2835] mb-1.5"
            >New Password *</label
          >
          <input
            v-model="resetPasswordData.newPassword"
            type="password"
            class="w-full border border-gray-300 rounded-[6px] px-3 py-2 text-[13px] focus:outline-none focus:border-[#F52C11]"
          />
        </div>
        <div>
          <label class="block text-[12px] font-medium text-[#1F2835] mb-1.5"
            >Confirm New Password *</label
          >
          <input
            v-model="resetPasswordData.confirmPassword"
            type="password"
            class="w-full border border-gray-300 rounded-[6px] px-3 py-2 text-[13px] focus:outline-none focus:border-[#F52C11]"
          />
        </div>
      </div>

      <div
        class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-2 bg-white"
      >
        <button
          @click="closeResetPasswordModal"
          class="px-4 py-2 rounded-[6px] text-[12px] font-medium border border-gray-300 hover:bg-gray-50"
        >
          Cancel
        </button>
        <button
          @click="submitPasswordReset"
          :disabled="!isResetPasswordValid"
          :class="
            isResetPasswordValid
              ? 'bg-[#F52C11] text-white'
              : 'bg-gray-300 text-gray-500 cursor-not-allowed'
          "
          class="px-4 py-2 rounded-[6px] text-[12px] font-medium"
        >
          Reset password
        </button>
      </div>
    </div>
  </div>

  <div
    v-if="showArchiveModal"
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 backdrop-blur-[1px]"
  >
    <div
      class="bg-white rounded-[16px] w-[850px] max-h-[85vh] shadow-2xl flex flex-col overflow-hidden font-['Overpass']"
    >
      <div
        class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white shrink-0"
      >
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-[10px] bg-red-50 flex items-center justify-center text-[#F52C11]"
          >
            <svg
              class="w-5 h-5"
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
            <h3 class="text-[16px] font-bold text-[#1F2835] leading-tight">
              Archived users
            </h3>
            <p class="text-[12px] text-gray-400 mt-0.5">User management page</p>
          </div>
        </div>
        <button
          @click="showArchiveModal = false"
          class="text-gray-400 hover:text-gray-600 transition-colors"
        >
          <svg
            class="w-5 h-5"
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
        class="flex items-center justify-between px-6 py-4 bg-white shrink-0 gap-4"
      >
        <p class="text-[12px] text-gray-400">
          These users have been archived and can no longer access the system.
        </p>
        <div class="relative flex items-center">
          <svg
            class="w-4 h-4 text-gray-400 absolute left-3 pointer-events-none"
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
            placeholder="Search archived users..."
            class="pl-9 pr-3 py-1.5 w-64 bg-white border border-gray-200 rounded-[6px] focus:outline-none focus:border-[#F52C11] text-[12px] placeholder:text-gray-400 transition-colors"
          />
        </div>
      </div>

      <div class="flex-1 overflow-auto custom-scroll px-6 pb-4 bg-white">
        <table
          v-if="filteredArchivedUsers.length > 0"
          class="w-full border-collapse text-left table-fixed border-t border-gray-100"
        >
          <thead class="bg-gray-50/70 sticky top-0 z-10">
            <tr>
              <th
                class="w-[20%] px-3 py-2.5 text-[12px] font-bold text-gray-500 tracking-wider"
              >
                Full Name
              </th>
              <th
                class="w-[23%] px-3 py-2.5 text-[12px] font-bold text-gray-500 tracking-wider"
              >
                Email
              </th>
              <th
                class="w-[12%] px-3 py-2.5 text-[12px] font-bold text-gray-500 tracking-wider"
              >
                Role
              </th>
              <th
                class="w-[16%] px-3 py-2.5 text-[12px] font-bold text-gray-500 tracking-wider"
              >
                Date Archived
              </th>
              <th
                class="w-[16%] px-3 py-2.5 text-[12px] font-bold text-gray-500 tracking-wider"
              >
                Archived By
              </th>
              <th
                class="w-[13%] px-3 py-2.5 text-[12px] font-bold text-gray-500 tracking-wider text-center"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr
              v-for="user in filteredArchivedUsers"
              :key="user.id"
              class="bg-white hover:bg-gray-50/80 transition-colors"
            >
              <td
                class="px-3 py-3 text-[12px] text-[#1F2835] truncate"
                :title="user.fullName || user.name || user.full_name"
              >
                {{ user.fullName || user.name || user.full_name }}
              </td>
              <td
                class="px-3 py-3 text-[12px] text-gray-600 truncate"
                :title="user.email"
              >
                {{ user.email }}
              </td>
              <td class="px-3 py-3 whitespace-nowrap">
                <span
                  class="inline-flex items-center px-2 py-[2px] rounded-[6px] text-[11px] font-semibold"
                  :class="getRoleBadgeClass(user.role)"
                >
                  {{ user.role?.role_name || user.role || "No Role" }}
                </span>
              </td>
              <td class="px-3 py-3 text-[12px] text-gray-500 leading-normal">
                <div>
                  {{
                    formatArchiveDate(
                      user.deleted_at || user.archivedAt || user.archived_date
                    )
                  }}
                </div>
                <div class="text-[11px] text-gray-400">
                  {{
                    formatArchiveTime(
                      user.deleted_at || user.archivedAt || user.archived_time
                    )
                  }}
                </div>
              </td>
              <td class="px-3 py-3 text-[12px] text-gray-500 leading-normal">
                <div
                  class="text-gray-700 truncate"
                  :title="
                    user.archived_by_name ||
                    user.archivedBy?.name ||
                    user.archivedBy?.fullName
                  "
                >
                  {{
                    user.archived_by_name ||
                    user.archivedBy?.name ||
                    user.archivedBy?.fullName ||
                    "System"
                  }}
                </div>
                <div
                  class="text-[11px] text-gray-400 truncate"
                  :title="user.archived_by_email || user.archivedBy?.email"
                >
                  {{ user.archived_by_email || user.archivedBy?.email || "" }}
                </div>
              </td>
              <td class="px-3 py-3 text-center whitespace-nowrap">
                <div class="flex items-center justify-center gap-1.5">
                  <button
                    @click="unarchiveUser(user.id)"
                    class="border border-gray-200 rounded-[6px] px-2 py-1 flex items-center gap-1 text-[11px] font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm"
                    title="Restore user"
                  >
                    <svg
                      class="w-3.5 h-3.5 text-green-600"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 6H16"
                      />
                    </svg>
                    Restore
                  </button>
                  <button
                    @click="deleteArchivedUser(user.id)"
                    class="border border-gray-200 hover:border-red-500 hover:text-red-500 rounded-[6px] px-2 py-1 flex items-center gap-1 text-[11px] font-medium text-gray-700 bg-white hover:bg-red-50/30 transition-colors shadow-sm"
                    title="Permanently delete user"
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
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <p v-else class="text-center py-12 text-gray-400 text-[12px]">
          No archived users found
        </p>
      </div>

      <div
        class="border-t border-gray-100 px-6 py-4 flex items-center justify-between bg-white shrink-0"
      >
        <div class="flex items-center gap-1.5 text-[12px] text-gray-400">
          <div
            class="w-4 h-4 rounded-full border border-red-400 flex items-center justify-center text-red-500 text-[11px] font-bold shrink-0"
          >
            !
          </div>
          <span
            >Restoring moves the user back to the active user list and restores
            their system access.</span
          >
        </div>
        <button
          @click="showArchiveModal = false"
          class="border border-gray-300 rounded-[6px] px-4 py-1.5 text-gray-700 text-[12px] hover:bg-gray-50 transition-colors font-medium"
        >
          Close
        </button>
      </div>
    </div>
  </div>

  <div
    v-if="showRoleDropdown"
    class="fixed inset-0 z-40"
    @click="showRoleDropdown = false"
  ></div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useRouter } from "vue-router";
import { useAuditLog } from "~/composables/useAuditLog";

const router = useRouter();
const { logAuditAction } = useAuditLog();
const {
  fetchUsers: getUsers,
  archiveUsers,
  fetchArchivedUsers,
  restoreUser,
  deleteUser,
} = useUserApi();

definePageMeta({
  layout: "app",
  middleware: "auth",
});

// --- API CONFIGURATION ---
// Safely maps to fallback route if API endpoints are standard
const API_BASE_URL = "/api";

// --- STATE VARIABLES ---
const isLoading = ref(false);
const searchQuery = ref("");
const archivedSearchQuery = ref("");
const selectedRole = ref("All roles");
const selectedIds = ref([]);
const roleOptions = ["All roles", "Admin", "Sales"];

const showRoleDropdown = ref(false);
const showArchiveModal = ref(false);
const showResetPasswordModal = ref(false);

const resettingUser = ref(null);
const resetPasswordData = ref({ newPassword: "", confirmPassword: "" });

// --- PAGINATION STATE ---
const currentPage = ref(1);
const itemsPerPage = ref(10);
const goToPageInput = ref("");

// --- DATA CONTAINERS ---
const users = ref([]);
const archivedUsers = ref([]);

// --- LIFECYCLE ---
onMounted(() => {
  fetchUsers();
});

// --- WATCHERS ---
watch([searchQuery, selectedRole], () => {
  currentPage.value = 1;
});

// --- NAVIGATION ---
function navigateToAddUser() {
  router.push("/users/create");
}

function goToEditUser(user) {
  router.push({
    path: "/users/edit",
    query: { id: user.id },
  });
}

// --- FORMATTERS ---
function formatDate(dateString) {
  if (!dateString) return "";
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
}

// --- FORMAT ARCHIVE DATES ---
function formatArchiveDate(dateString) {
  if (!dateString) return "N/A";
  const date = new Date(dateString);
  if (isNaN(date.getTime())) return dateString;
  return date.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
}

function formatArchiveTime(dateString) {
  if (!dateString) return "";
  const date = new Date(dateString);
  if (isNaN(date.getTime())) return dateString.includes(":") ? dateString : "";
  return date.toLocaleTimeString("en-US", {
    hour: "numeric",
    minute: "2-digit",
    hour12: true,
  });
}

// --- PAGINATION METHODS ---
function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
}

function handleGoToPage() {
  const targetPage = parseInt(goToPageInput.value);
  if (targetPage && targetPage >= 1 && targetPage <= totalPages.value) {
    currentPage.value = targetPage;
  }
  goToPageInput.value = "";
}

// --- API ACTIONS ---
async function fetchUsers() {
  isLoading.value = true;
  try {
    const response = await getUsers();
    users.value = response.data || [];
  } catch (error) {
    console.error("Error connecting to database:", error);
  } finally {
    isLoading.value = false;
  }
}

async function openArchiveModal() {
  showArchiveModal.value = true;
  archivedSearchQuery.value = "";
  try {
    const response = await fetchArchivedUsers();
    archivedUsers.value = response.data || [];
  } catch (error) {
    console.error("Error fetching archived users:", error);
  }
}

async function archiveSelectedUsers() {
  if (selectedIds.value.length === 0) return;
  try {
    const archivedNames = users.value
      .filter((u) => selectedIds.value.includes(u.id))
      .map((u) => u.full_name || u.name || u.email)
      .join(", ");

    await archiveUsers(selectedIds.value);
    users.value = users.value.filter((u) => !selectedIds.value.includes(u.id));

    logAuditAction({
      module: "User Management",
      description:
        selectedIds.value.length === 1
          ? `Archived user account: ${archivedNames}`
          : `Archived ${selectedIds.value.length} user accounts: ${archivedNames}`,
    });

    selectedIds.value = [];
  } catch (error) {
    console.error("Error archiving users:", error);
  }
}

async function unarchiveUser(id) {
  try {
    const restoredUser = archivedUsers.value.find((u) => u.id === id);
    const restoredName =
      restoredUser?.full_name ||
      restoredUser?.name ||
      restoredUser?.email ||
      "user";

    await restoreUser(id);
    await fetchUsers();
    await openArchiveModal();

    logAuditAction({
      module: "User Management",
      description: `Restored user account: ${restoredName}`,
    });
  } catch (error) {
    console.error("Error restoring user:", error);
  }
}

async function deleteArchivedUser(id) {
  if (
    !window.confirm(
      "Are you sure you want to permanently delete this user? This action cannot be undone."
    )
  ) {
    return;
  }
  try {
    const deletedUser = archivedUsers.value.find((u) => u.id === id);
    const deletedName =
      deletedUser?.full_name ||
      deletedUser?.name ||
      deletedUser?.email ||
      "user";

    await deleteUser(id);
    archivedUsers.value = archivedUsers.value.filter((u) => u.id !== id);

    logAuditAction({
      module: "User Management",
      description: `Permanently deleted user account: ${deletedName}`,
    });
  } catch (error) {
    console.error("Error deleting user from database:", error);
  }
}

async function submitPasswordReset() {
  if (!isResetPasswordValid.value || !resettingUser.value) return;
  try {
    const response = await fetch(
      `${API_BASE_URL}/users/${resettingUser.value.id}/reset-password`,
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ password: resetPasswordData.value.newPassword }),
      }
    );
    if (response.ok) {
      const resetName =
        resettingUser.value.full_name ||
        resettingUser.value.name ||
        resettingUser.value.email ||
        "user";

      logAuditAction({
        module: "User Management",
        description: `Reset password for user: ${resetName}`,
      });

      closeResetPasswordModal();
      fetchUsers();
    }
  } catch (error) {
    console.error("Error resetting password:", error);
  }
}

// --- COMPUTED PROPERTIES ---
const filteredUsers = computed(() => {
  let result = users.value;
  const q = searchQuery.value.trim().toLowerCase();

  if (q) {
    result = result.filter(
      (u) =>
        (u.full_name || u.name || "").toLowerCase().includes(q) ||
        (u.email || "").toLowerCase().includes(q)
    );
  }

  if (selectedRole.value !== "All roles") {
    result = result.filter((u) => {
      const roleName = u.role?.role_name || "";
      return roleName.toLowerCase() === selectedRole.value.toLowerCase();
    });
  }
  return result;
});

const paginatedUsers = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return filteredUsers.value.slice(startIndex, endIndex);
});

const totalPages = computed(() => {
  return Math.ceil(filteredUsers.value.length / itemsPerPage.value) || 1;
});

const filteredArchivedUsers = computed(() => {
  let result = archivedUsers.value;
  const q = archivedSearchQuery.value.trim().toLowerCase();
  if (q) {
    result = result.filter(
      (u) =>
        (u.fullName || u.name || u.full_name || "").toLowerCase().includes(q) ||
        (u.email || "").toLowerCase().includes(q)
    );
  }
  return result;
});

const adminCount = computed(
  () =>
    users.value.filter(
      (u) => (u.role?.role_name || u.role || "").toLowerCase() === "admin"
    ).length
);
const salesCount = computed(
  () =>
    users.value.filter(
      (u) => (u.role?.role_name || u.role || "").toLowerCase() === "sales"
    ).length
);

const selectedCount = computed(() => selectedIds.value.length);

const isAllSelected = computed(
  () =>
    paginatedUsers.value.length > 0 &&
    paginatedUsers.value.every((u) => selectedIds.value.includes(u.id))
);

const isResetPasswordValid = computed(() => {
  return (
    resetPasswordData.value.newPassword.trim() &&
    resetPasswordData.value.confirmPassword.trim() &&
    resetPasswordData.value.newPassword ===
      resetPasswordData.value.confirmPassword
  );
});

// --- HELPER FUNCTIONS ---
function isSelected(id) {
  return selectedIds.value.includes(id);
}

function toggleSelection(id) {
  const idx = selectedIds.value.indexOf(id);
  if (idx > -1) selectedIds.value.splice(idx, 1);
  else selectedIds.value.push(id);
}

function toggleAll() {
  const visibleIds = paginatedUsers.value.map((u) => u.id);
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

function getRoleBadgeClass(roleObj) {
  const roleName =
    typeof roleObj === "string" ? roleObj : roleObj?.role_name || "";
  const normalizedRole = roleName.toLowerCase();

  if (normalizedRole === "admin")
    return "bg-red-50 text-red-600 border border-red-100/60";
  if (normalizedRole === "sales")
    return "bg-green-50 text-green-600 border border-green-100/60";

  return "bg-gray-50 text-gray-600 border border-gray-200";
}

function openResetPasswordModal(user) {
  resettingUser.value = { ...user };
  resetPasswordData.value = { newPassword: "", confirmPassword: "" };
  showResetPasswordModal.value = true;
}

function closeResetPasswordModal() {
  showResetPasswordModal.value = false;
  resettingUser.value = null;
  resetPasswordData.value = { newPassword: "", confirmPassword: "" };
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Overpass:wght@400;500;600;700&display=swap");

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

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  appearance: textfield;
}
</style>
