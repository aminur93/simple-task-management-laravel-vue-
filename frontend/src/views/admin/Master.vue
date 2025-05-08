<template>
  <div class="flex h-screen overflow-hidden">
    <sidebar :sidebarOpen="sidebarOpen" :closeSidebar="closeSidebar" />

    <div class="flex-1 flex flex-col min-h-screen">
      <Header @toggle-sidebar="toggleSidebar" />
      <main class="mt-16 p-4 md:ml-64 bg-gray-100 min-h-[calc(100vh-4rem)]">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Header from '../../components/admin/Header.vue'
import Sidebar from '../../components/admin/Sidebar.vue'

const sidebarOpen = ref(false)

function toggleSidebar() {
  sidebarOpen.value = !sidebarOpen.value
}

function closeSidebar() {
  sidebarOpen.value = false
}
</script>

<style scoped>
/* Ensures that the layout works properly even on smaller screens */
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* Main content area */
main {
  overflow-y: auto; /* Ensures scrolling works */
}

/* For responsive behavior */
@media (max-width: 768px) {
  .md\:ml-64 {
    margin-left: 0 !important; /* Ensure sidebar is fully visible on mobile */
  }
}
</style>
