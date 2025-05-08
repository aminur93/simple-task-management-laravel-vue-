<template>
  <aside
    ref="sidebarRef"
    :class="[
      'bg-gray-800 text-white w-64 pt-16 fixed top-0 left-0 z-30 transition-transform duration-300',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full',
      'md:translate-x-0',
    ]"
    style="height: 100vh"
  >
    <!-- Logo Section -->
    <div class="p-4 text-lg font-bold border-b border-gray-700" style="margin-top:-61px; margin-bottom: 10px">
      <h1 style="margin-left:20px">Admin Panel</h1>
    </div>

    <nav class="px-4">
      <!-- Dashboard -->
      <router-link
        to="/dashboard"
        class="flex items-center space-x-2 px-3 py-2 rounded"
        :class="route.path === '/dashboard' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300'"
      >
      <svg
        class="w-5 h-5"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24"
      >
        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
      </svg>
      <span>Dashboard</span>
    </router-link>

      <!-- Task -->
      <router-link
        to="/task"
        class="flex items-center space-x-2 px-3 py-2 rounded text-gray-300 hover:bg-gray-700 hover:text-white"
        active-class="bg-gray-700 text-white"
      >
      <svg
        class="w-5 h-5"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24"
      >
        <path d="M9 17v-6h13v6M9 5v6h13V5zM4 5h.01M4 12h.01M4 19h.01" />
      </svg>
      <span>Task</span>
    </router-link>

      <!-- User Management Dropdown -->
      <!-- <div>
        <button
          class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-700 focus:outline-none"
        >
          <div class="flex items-center space-x-2">
            <svg
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 110-8 4 4 0 010 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
              />
            </svg>
            <span>User Management</span>
          </div>
          <svg
            class="w-4 h-4 transform transition-transform duration-200"
            :class="{ 'rotate-180': userMenuOpen }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div v-if="userMenuOpen" class="pl-10 space-y-1">
          <a href="#" class="block py-1 text-sm hover:text-gray-300">All Users</a>
          <a href="#" class="block py-1 text-sm hover:text-gray-300">Roles</a>
          <a href="#" class="block py-1 text-sm hover:text-gray-300">Permissions</a>
        </div>
      </div> -->
    </nav>
  </aside>
</template>

<script>
import { useRoute } from 'vue-router'

export default {
    setup() {
      const route = useRoute()
      return { route }
    },

    props: {
      sidebarOpen: {
        type: Boolean,
        required: true
      },
      closeSidebar: {
        type: Function,
        required: true
      }
    },


    data() {
      return {
        sidebarRef: null,
      }
    },


    mounted() {
      document.addEventListener('click', this.handleClickOutside)
    },

    beforeUnmount() {
      document.removeEventListener('click', this.handleClickOutside)
    },

    methods: {
      handleClickOutside(e) {
        if (
          this.$refs.sidebarRef &&
          !this.$refs.sidebarRef.contains(e.target) &&
          !e.target.closest('header')
        ) {
          this.closeSidebar()
        }
      },
    }
}
</script>

<style lang="scss" scoped></style>
