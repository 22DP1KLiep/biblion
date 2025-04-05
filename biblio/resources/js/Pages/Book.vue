<template>
    <div class="container mx-auto p-6">
        <div v-if="book" class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
            <img :src="book.image || 'https://via.placeholder.com/300'" alt="Book cover" class="w-full h-64 object-cover rounded mb-4">
            <h1 class="text-3xl font-bold mb-2">{{ book.title }}</h1>
            <p class="text-xl text-gray-700 mb-4">by {{ book.author }}</p>
            <p class="text-gray-600">{{ book.description }}</p>
        </div>
        <div v-else class="text-center text-gray-500">Loading book info...</div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id'],
    data() {
        return {
            book: null,
        };
    },
    mounted() {
        axios.get(`/books/${this.id}`)
            .then(response => {
                this.book = response.data;
            })
            .catch(error => {
                console.error("Failed to load book:", error);
            });
    }
};
</script>
