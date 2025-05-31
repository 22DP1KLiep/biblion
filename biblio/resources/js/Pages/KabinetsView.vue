<template>
    <div>
        <Navbar />
        <div v-if="$page.props.auth.user">
            <!-- Lietotāja kabineta saturs -->
            <div class="container">
                <!-- Left Sorting Sidebar -->
                <div class="sidebar">
                    <h2>Laipni lūdzam, {{ $page.props.auth.user.username }}!</h2>
                    <!-- 🔥 Logout poga -->
                    <button @click="logout" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Izrakstīties
                    </button>
                    <h3>Kabineta kārtošana:</h3>

                    <!-- Mapes -->
                    <div class="sort-section">
                        <h3 @click="showMoreMapes = !showMoreMapes" class="toggle-header">
                            Mapes <span>{{ showMoreMapes ? '▲' : '▼' }}</span>
                        </h3>
                        <div v-for="(folder, index) in visibleMapes" :key="index" class="list__item">
                            <label class="label--checkbox">
                                <input type="checkbox" class="checkbox" v-model="selectedMapes" :value="folder" />
                                {{ folder }}
                            </label>
                        </div>
                        <div v-if="showMoreMapes">
                            <div v-for="(folder, index) in hiddenMapes" :key="'hidden-' + index" class="list__item">
                                <label class="label--checkbox">
                                    <input type="checkbox" class="checkbox" v-model="selectedMapes" :value="folder" />
                                    {{ folder }}
                                </label>
                            </div>
                        </div>

                        <!-- Jauna mape -->
                        <div class="new-folder">
                            <input type="text" v-model="newMape" placeholder="Jauna mape..." />
                            <button @click="addMape" class="create-btn">Pievienot</button>
                        </div>
                    </div>

                    <!-- Žanri -->
                    <div class="sort-section">
                        <h3 @click="showMoreGenres = !showMoreGenres" class="toggle-header">
                            Žanrs <span>{{ showMoreGenres ? '▲' : '▼' }}</span>
                        </h3>
                        <div v-for="(genre, index) in visibleGenres" :key="index" class="list__item">
                            <label class="label--checkbox">
                                <input type="checkbox" class="checkbox" v-model="selectedGenres" :value="genre" />
                                {{ genre }}
                            </label>
                        </div>
                        <div v-if="showMoreGenres">
                            <div v-for="(genre, index) in hiddenGenres" :key="'hidden-' + index" class="list__item">
                                <label class="label--checkbox">
                                    <input type="checkbox" class="checkbox" v-model="selectedGenres" :value="genre" />
                                    {{ genre }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Main Content Area -->
                <div class="main-content">
                    <h1>Visas grāmatas</h1>
                    <p><strong>Atlasītās mapes:</strong> {{ selectedMapes.join(', ') || 'Nav atlasītas' }}</p>
                    <p><strong>Atlasītie žanri:</strong> {{ selectedGenres.join(', ') || 'Nav atlasīti' }}</p>

                    <div class="book-list">
                        <div v-for="(book, index) in filteredBooks" :key="index" class="book-card">
                            <div class="book-info">
                                <img :src="book.cover" alt="Book Cover" class="book-cover" />
                                <div class="book-text">
                                    <h3>{{ book.title }}</h3>
                                    <p><strong>Autors:</strong> {{ book.author }}</p>
                                    <div class="rating">
                                        <span v-for="star in 5" :key="star" @click="rateBook(index, star)">
                                            {{ star <= book.rating ? '⭐' : '☆' }}
                                        </span>
                                    </div>
                                    <p><strong>Mape:</strong> {{ book.folder }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-center mt-20">
            <h1 class="text-3xl font-bold">Jūs neesat autorizējies!</h1>
            <p class="mt-4">
                Lūdzu <a href="/login" class="text-blue-500 underline">ienāc sistēmā</a>, lai piekļūtu šai sadaļai.
            </p>
        </div>
        <Footer />
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { router } from '@inertiajs/vue3';
import Navbar from "@/Components/navbar.vue";
import Footer from "@/Components/footer.vue";

const logout = () => {
    router.post('/logout');
};

// Mapes un žanri
const mapes = ref(["Darbs", "Personīgais", "Ceļojumi", "Projekti", "Mācības", "Cits"]);
const zanri = ref(["Fantasija", "Romāns", "Vēsturiskais", "Trilleris", "Zinātniskā fantastika"]);

// Mapes un žanri pieejami
const showMoreMapes = ref(false);
const showMoreGenres = ref(false);

// Pirmās 3 redzamās opcijas
const visibleMapes = computed(() => mapes.value.slice(0, 3));
const hiddenMapes = computed(() => mapes.value.slice(3));

const visibleGenres = computed(() => zanri.value.slice(0, 3));
const hiddenGenres = computed(() => zanri.value.slice(3));

// Atlasītie filtri
const selectedMapes = ref<string[]>([]);
const selectedGenres = ref<string[]>([]);

// Jaunas mapes pievienošana
const newMape = ref("");
const addMape = () => {
    if (newMape.value.trim() !== "") {
        mapes.value.push(newMape.value.trim());
        newMape.value = "";
    }
};

// Grāmatu saraksts
const books = ref([
    {
        title: "1984",
        author: "George Orwell",
        genre: "Distopija",
        folder: "Mācības",
        rating: 4,
        cover: "https://covers.openlibrary.org/b/id/15354110-L.jpg",
    },
    {
        title: "Pride and Prejudice",
        author: "Jane Austen",
        genre: "Romāns",
        folder: "Personīgais",
        rating: 5,
        cover: "https://covers.openlibrary.org/b/id/15353412-L.jpg",
    },
    {
        title: "The Hobbit",
        author: "J.R.R. Tolkien",
        genre: "Fantasija",
        folder: "Ceļojumi",
        rating: 3,
        cover: "https://covers.openlibrary.org/b/id/15351532-L.jpg",
    },
]);

// Filtrētās grāmatas pēc atlasītajiem filtriem
const filteredBooks = computed(() => {
    return books.value.filter((book) => {
        const inSelectedMapes = selectedMapes.value.length === 0 || selectedMapes.value.includes(book.folder);
        const inSelectedGenres = selectedGenres.value.length === 0 || selectedGenres.value.includes(book.genre);
        return inSelectedMapes && inSelectedGenres;
    });
});

// Vērtēšanas funkcija
const rateBook = (index: number, stars: number) => {
    books.value[index].rating = stars;
};
</script>

<style scoped>
/* Main container */
.container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: #f4f4f4;
    padding: 20px;
    border-right: 2px solid #ccc;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

/* Sorting section */
.sort-section {
    margin-bottom: 20px;
}

/* Checkbox items */
.list__item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 5px;
}

.label--checkbox {
    position: relative;
    font-family: Arial, sans-serif;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
}

.checkbox {
    position: relative;
    top: -2px;
    cursor: pointer;
}

.checkbox:before {
    content: "";
    position: absolute;
    left: 0;
    width: 16px;
    height: 16px;
    border: 2px solid #f2f2f2;
    background: white;
    border-radius: 3px;
    transition: all 0.3s ease-in-out;
}

.checkbox:checked:before {
    background: #009688;
    border-color: #009688;
}

.checkbox:checked:after {
    content: "";
    position: absolute;
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

/* Toggle header with triangle */
.toggle-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

.toggle-header span {
    font-size: 14px;
    color: #000000;
}

/* New folder creation */
.new-folder {
    margin-top: 15px;
}

.new-folder input {
    width: calc(100% - 20px);
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 5px;
}

.create-btn {
    width: 100%;
    padding: 8px;
    background: #2a436d;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.create-btn:hover {
    background: #0d3a8c;
}

/* Main Content */
.main-content {
    flex-grow: 1;
    padding: 20px;
}

.book-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}

.book-card {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.book-info {
    display: flex;
    gap: 15px;
    align-items: center;
}

.book-cover {
    width: 80px;
    height: auto;
    border-radius: 5px;
}

.book-text {
    display: flex;
    flex-direction: column;
}

.rating {
    margin: 10px 0;
}

.rating span {
    cursor: pointer;
}
</style>
