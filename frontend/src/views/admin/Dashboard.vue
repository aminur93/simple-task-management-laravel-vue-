<template>
  <div id="dashboard" class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card 1 -->
    <div class="bg-blue-500 text-white rounded-lg shadow-lg p-6">
      <h3 class="text-xl font-semibold">Card 1</h3>
      <p class="mt-4">This is the first card with a blue background.</p>
    </div>

    <!-- Card 2 -->
    <div class="bg-green-500 text-white rounded-lg shadow-lg p-6">
      <h3 class="text-xl font-semibold">Card 2</h3>
      <p class="mt-4">This is the second card with a green background.</p>
    </div>

    <!-- Card 3 -->
    <div class="bg-yellow-500 text-white rounded-lg shadow-lg p-6">
      <h3 class="text-xl font-semibold">Card 3</h3>
      <p class="mt-4">This is the third card with a yellow background.</p>
    </div>

    <!-- Card 4 -->
    <div class="bg-red-500 text-white rounded-lg shadow-lg p-6">
      <h3 class="text-xl font-semibold">Card 4</h3>
      <p class="mt-4">This is the fourth card with a red background.</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Dashboard",
  created() {},

  data() {
    return {};
  },

  props: {},

  methods: {},
};
</script>

<style scoped></style>
