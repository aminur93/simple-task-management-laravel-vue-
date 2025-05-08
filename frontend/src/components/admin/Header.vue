<template>
  <header
    class="h-16 bg-white shadow-md flex justify-between items-center px-4 fixed top-0 left-0 right-0 z-20 md:ml-64"
  >

    <div class="flex items-center space-x-4">
      <button class="md:hidden" @click="toggleSidebar">
        <svg
          class="w-6 h-6 text-gray-800"
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
      </button>
      <h1 class="text-xl font-semibold">Dashboard</h1>

      <div class="relative w-full max-w-sm">
        <input
          type="text"
          placeholder="Search..."
          class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="searchQuery"
        />
        <svg
          class="absolute left-3 top-2.5 h-5 w-5 text-gray-400"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"
          />
        </svg>
      </div>
    </div>

    <div class="relative">
      <button @click="toggleProfileMenu">
        <img
          src="https://i.pravatar.cc/40"
          alt="User Avatar"
          class="w-10 h-10 rounded-full object-cover"
        />
      </button>
      <div
        v-if="profileMenuOpen"
        class="absolute right-0 mt-2 w-40 bg-white rounded shadow-lg py-2 z-30"
        >
       <!-- Profile Link with Icon -->
       <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 flex items-center space-x-2">
        <svg class="w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
        </svg>
        <span>Profile</span>
      </a>
      
      <!-- Settings Link with Icon -->
      <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 flex items-center space-x-2">
        <svg class="w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M2 12h20"/>
        </svg>
        <span>Settings</span>
      </a>
      
      <!-- Logout Link with Icon -->
      <a @click="logout" class="block px-4 py-2 text-sm hover:bg-gray-100 flex items-center space-x-2">
        <svg class="w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"/>
        </svg>
        <span>Logout</span>
      </a>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  data() {
    return {
      profileMenuOpen: false,  // Manage the profile menu's open/close state
    }
  },

  methods: {
    toggleSidebar() {
      console.log('Toggle sidebar in Header')  // Debugging line
      this.$emit('toggle-sidebar')
    },

    toggleProfileMenu() {
      this.profileMenuOpen = !this.profileMenuOpen;  // Toggle the profile menu state
    },

    logout(){
      this.$store.dispatch('logout').then(() => {
        this.$router.push('/');
      })
    }
  }
}
</script>

<style lang="scss" scoped></style>
