<template>
  <Navbar />
  <!-- <SortableBooks /> -->
  <GoogleBookSearch />
  <Footer />
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/footer.vue'
// import SortableBooks from '@/Components/SortableBooks.vue'
import GoogleBookSearch from '@/Components/GoogleBookSearch.vue'
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');
* { font-family: 'Poppins', sans-serif; }
</style>
