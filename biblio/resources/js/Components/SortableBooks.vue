<template>
    <div class="flex flex-col md:flex-row relative min-h-screen">

        <!-- Mobile toggle button -->
        <button
            class="md:hidden bg-blue-500 text-white px-4 py-2 m-4 rounded w-fit"
            @click="sidebarOpen = true"
        >
            ☰ Filtri
        </button>

        <!-- Sidebar (desktop & mobile) -->
        <transition name="slide">
            <aside
                v-show="sidebarOpen"
                class="fixed md:relative z-40 md:z-0 top-0 left-0 w-64 bg-gray-100 p-4 h-full md:min-h-screen overflow-y-auto shadow-lg md:shadow-none"
            >
                <!-- Mobile close button -->
                <div class="flex justify-between items-center mb-4 md:hidden">
                    <h2 class="text-lg font-bold">Filtri</h2>
                    <button @click="sidebarOpen = false" class="text-xl font-bold">&times;</button>
                </div>

                <!-- Žanru filtrs -->
                <!-- Sidebar žanru daļā (replace esošo žanru sadaļu ar šo) -->
                <div class="mb-4">
                    <button
                        class="flex items-center justify-between w-full text-left font-bold text-lg mb-2"
                        @click="genresOpen = !genresOpen"
                    >
                        Žanri
                        <span class="text-sm">
            <span v-if="genresOpen">▲</span>
            <span v-else>▼</span>
        </span>
                    </button>

                    <transition name="fade">
                        <div v-show="genresOpen" class="space-y-2 pl-2">
                            <label
                                v-for="genre in genres"
                                :key="genre.id"
                                class="flex items-center gap-2 text-sm"
                            >
                                <input
                                    type="checkbox"
                                    :value="genre.id"
                                    v-model="selectedGenres"
                                    @change="fetchBooks"
                                >
                                {{ genre.name }}
                            </label>
                        </div>
                    </transition>
                </div>

                <!-- Kārtošana -->
                <div class="mt-6">
                    <h3 class="text-md font-semibold mb-2">Kārtot pēc:</h3>
                    <select v-model="sortBy" @change="fetchBooks" class="w-full border rounded px-2 py-1 mb-2">
                        <option value="title">Nosaukuma</option>
                        <option value="author">Autora</option>
                        <option value="published_year">Iznākšanas gada</option>
                    </select>

                    <select v-model="direction" @change="fetchBooks" class="w-full border rounded px-2 py-1">
                        <option value="asc">Augošā secībā</option>
                        <option value="desc">Dilstošā secībā</option>
                    </select>
                </div>
            </aside>
        </transition>

        <!-- Overlay when sidebar is open (only on mobile) -->
        <div
            v-show="sidebarOpen"
            class="fixed inset-0 bg-black bg-opacity-40 z-30 md:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Main content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-6 text-center">Grāmatu saraksts</h1>

            <div v-if="books.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div v-for="book in books" :key="book.id" class="p-4 bg-white rounded-lg shadow-lg">
                    <img
                        :src="book.image"
                        :alt="book.title"
                        class="w-full h-48 object-cover rounded-md mb-4"
                    >
                    <h2 class="text-lg font-semibold">{{ book.title }}</h2>
                    <p class="text-gray-600 text-sm">by {{ book.author }}</p>
                    <div v-if="book.genres && book.genres.length" class="mt-2">
                        <span
                            v-for="genre in book.genres"
                            :key="genre.id"
                            class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1"
                        >
                            {{ genre.name }}
                        </span>
                    </div>
                    <p class="text-sm mt-2 text-gray-700">{{ book.description }}</p>

                    <button
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="inspectBook(book.id)"
                    >
                        Apskatīt
                    </button>
                </div>
            </div>

            <p v-else class="text-gray-500 text-center">Notiek ielāde...</p>
        </main>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            books: [],
            genres: [],
            selectedGenres: [],
            sortBy: 'title',
            direction: 'asc',
            sidebarOpen: true,
            genresOpen: true,
        };
    },
    mounted() {
        axios.get('/api/genres').then(response => {
            this.genres = response.data;
        });
        this.fetchBooks();

        // Automātiski aizver sidebar mobilajās ierīcēs
        if (window.innerWidth < 768) {
            this.sidebarOpen = false;
        }
    },
    methods: {
        fetchBooks() {
            axios
                .get('/get/all/books', {
                    params: {
                        sort: this.sortBy,
                        direction: this.direction,
                        genres: this.selectedGenres,
                    },
                })
                .then((response) => {
                    this.books = response.data;
                })
                .catch((error) => {
                    console.error('Kļūda ielādējot grāmatas:', error);
                });
        },
        inspectBook(id) {
            this.$inertia.visit(`/book/${id}`);
        },
    },
};
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
    transform: translateX(-100%);
}
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    max-height: 0;
}
.fade-enter-to,
.fade-leave-from {
    opacity: 1;
    max-height: 500px;
}
</style>
