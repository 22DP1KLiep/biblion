<template>
    <Navbar />
    <SortableBooks />
<!--    <showallbooks/>-->
<!--    <Partners />-->
    <Footer />
</template>
<script setup lang="ts">
import Navbar from "@/Components/navbar.vue";
import Footer from "@/Components/footer.vue";
import Showallbooks from "@/Components/showallbooks.vue";
import Partners from "@/Components/Partners.vue";
import SortableBooks from '@/Components/SortableBooks.vue'


</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

* {
    font-family: 'Poppins', sans-serif;
}
</style>
