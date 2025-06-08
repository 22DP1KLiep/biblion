<template>
    <div class="min-h-screen flex flex-col bg-[#f0f4f8]">
        <Navbar />

        <div class="flex-grow container mx-auto p-6">
            <div v-if="book" class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg flex flex-col lg:flex-row gap-8">
                <!-- Grāmatas attēls un vērtējums -->
                <div class="w-full lg:w-1/3 flex flex-col items-center">
                    <img
                        :src="book.image ? `/${book.image}` : 'https://via.placeholder.com/300'"
                        alt="Book cover"
                        class="w-full h-auto object-cover rounded-lg shadow mb-4"
                    />
                    <div v-if="$page.props.auth.user" class="flex flex-col items-center mt-4">
                        <div class="flex items-center space-x-1">
                            <label v-for="n in 5" :key="n" class="cursor-pointer transition-transform hover:scale-110">
                                <input
                                    type="radio"
                                    :id="`star${n}`"
                                    name="rating"
                                    :value="n"
                                    v-model="selectedRating"
                                    class="hidden"
                                />
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6"
                                    :class="n <= selectedRating ? 'text-yellow-400' : 'text-gray-300'"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.178 3.622a1 1 0 00.95.69h3.805c.969 0 1.371 1.24.588 1.81l-3.077 2.234a1 1 0 00-.364 1.118l1.179 3.623c.3.921-.755 1.688-1.54 1.118l-3.077-2.234a1 1 0 00-1.176 0l-3.077 2.234c-.784.57-1.838-.197-1.54-1.118l1.179-3.623a1 1 0 00-.364-1.118L2.43 9.05c-.783-.57-.38-1.81.588-1.81h3.805a1 1 0 00.95-.69l1.178-3.622z"
                                    />
                                </svg>
                            </label>
                        </div>
                        <button @click="saveRating" class="mt-2 bg-[#213555] hover:bg-[#3e5879] text-white px-4 py-2 rounded">
                            Apstiprināt vērtējumu
                        </button>
                        <p v-if="ratingSaved" class="text-green-600 text-sm mt-1">✔️ Vērtējums saglabāts!</p>
                    </div>
                </div>

                <!-- Saturs -->
                <div class="w-full lg:w-2/3 flex flex-col">
                    <h1 class="text-3xl font-bold text-[#213555] mb-2">{{ book.title }}</h1>
                    <p class="text-lg text-gray-700 italic mb-4">by {{ book.author }}</p>

                    <!-- Žanri -->
                    <div v-if="book.genres?.length" class="flex flex-wrap gap-2 mb-4">
            <span
                v-for="genre in book.genres"
                :key="genre.id"
                class="bg-[#e0ecff] text-[#213555] px-3 py-1 rounded-full text-xs font-medium"
            >
              {{ genre.name }}
            </span>
                    </div>

                    <p class="text-gray-600 mb-6">{{ book.description }}</p>

                    <!-- Mape + komentārs -->
                    <div v-if="$page.props.auth.user">
                        <!-- Mape -->
                        <div class="flex flex-col sm:flex-row items-center gap-3 mt-6">
                            <div class="relative w-full sm:w-64">
                                <select
                                    v-model="selectedFolderId"
                                    class="appearance-none w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#213555]"
                                >
                                    <option disabled value="">-- Izvēlies mapi --</option>
                                    <option v-for="folder in folders" :key="folder.id" :value="folder.id">
                                        {{ folder.name }}
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <button
                                @click="saveBookToFolder"
                                class="bg-[#213555] hover:bg-[#3e5879] text-white px-4 py-2 rounded-lg shadow"
                            >
                                Pievienot mapē
                            </button>
                        </div>
                        <p v-if="isSavedToFolder" class="text-green-600 mt-2 text-sm">✔️ Grāmata pievienota</p>

                        <!-- Komentārs -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">Tavs komentārs:</label>
                            <textarea
                                v-model="comment"
                                class="w-full border rounded p-3"
                                rows="4"
                                placeholder="Ieraksti savas domas..."
                            ></textarea>
                            <button
                                class="mt-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
                                @click="submitFeedback"
                            >
                                Iesniegt
                            </button>
                        </div>
                    </div>

                    <!-- Ja nav pieslēdzies -->
                    <div v-else class="mt-6 bg-yellow-100 border border-yellow-400 p-4 rounded">
                        Lai komentētu vai vērtētu šo grāmatu, lūdzu
                        <a href="/auth" class="text-blue-600 font-semibold underline">ienāc sistēmā</a>.
                    </div>

                    <!-- Vidējais vērtējums -->
                    <div v-if="averageRating !== null" class="mt-8 flex items-center gap-2">
                        <span class="text-xl font-semibold">Vidējais vērtējums:</span>
                        <span class="text-yellow-500 text-2xl">
              <template v-for="n in 5">
                <span v-if="n <= Math.round(averageRating)">★</span>
                <span v-else class="text-gray-300">★</span>
              </template>
            </span>
                        <span class="text-gray-700">({{ averageRating.toFixed(1) }} / 5)</span>
                    </div>

                    <!-- Atsauksmes -->
                    <div class="mt-10">
                        <h2 class="text-2xl font-semibold text-[#213555] mb-4">Lasītāju atsauksmes</h2>
                        <div v-if="comments.length" class="space-y-3">
                            <div
                                v-for="c in showAllComments ? comments : comments.slice(0, visibleCommentsCount)"
                                :key="c.id"
                                class="bg-white border rounded-md p-3 shadow-sm text-sm flex justify-between items-start"
                            >
                                <div>
                                    <p class="text-gray-800 font-semibold mb-1">{{ c.user?.username || 'Anonīms' }}</p>
                                    <p class="text-gray-600 whitespace-pre-wrap">{{ c.comment }}</p>
                                </div>
                                <button
                                    v-if="$page.props.auth.user &&
        (c.user_id === $page.props.auth.user.id || $page.props.auth.user.role === 'admin')"
                                    @click="confirmDelete(c.id)"
                                    title="Dzēst komentāru"
                                    class="text-red-500 hover:text-red-700 text-xl ml-4"
                                >
                                    🗑️
                                </button>

                            </div>

                            <div v-if="comments.length > 2" class="text-center mt-4">
                                <button
                                    @click="toggleComments"
                                    class="text-sm text-[#213555] font-medium hover:underline"
                                >
                                    {{ showAllComments ? 'Rādīt mazāk ↑' : 'Rādīt vairāk ↓' }}
                                </button>
                            </div>
                        </div>
                        <div v-else class="text-gray-500">Vēl nav atsauksmju. Esi pirmais!</div>
                    </div>

                    <!-- Dzēšanas apstiprinājuma logs -->
                    <div v-if="deleteModalVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Apstiprināt dzēšanu</h2>
                            <p class="text-gray-700 mb-6">Vai tiešām vēlies dzēst šo komentāru?</p>
                            <div class="flex justify-end gap-4">
                                <button
                                    @click="cancelDelete"
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-800"
                                >
                                    Atcelt
                                </button>
                                <button
                                    @click="deleteCommentConfirmed"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded text-white"
                                >
                                    Dzēst
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div v-else class="text-center text-gray-500">Notiek ielāde...</div>
        </div>

        <Footer />
    </div>
</template>



<script>
import axios from 'axios';
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";

export default {
    components: { Footer, Navbar },
    props: ['id'],
    data() {
        return {
            book: null,
            rating: 0,
            selectedRating: 0,
            ratingSaved: false,
            comment: '',
            comments: [],
            averageRating: null,
            folders: [],
            selectedFolderId: null,
            isSavedToFolder: false,
            visibleCommentsCount: 2,
            showAllComments: false,
            deleteModalVisible: false,
            commentToDeleteId: null,
            showAddedToFolderModal: false,

        };
    },
    mounted() {
        this.fetchBook();
        this.fetchRatings();
        this.fetchComments();
        this.fetchFolders();
        this.fetchUserRating();

        if (this.$page.props.auth.user) {
            this.fetchUserRating();
        }
    },
    methods: {
        fetchBook() {
            axios.get(`/books/${this.id}`).then(res => this.book = res.data);
        },
        fetchRatings() {
            axios.get(`/books/${this.id}/ratings`).then(res => {
                const ratings = res.data;
                if (ratings.length) {
                    const total = ratings.reduce((sum, r) => sum + Number(r.rating), 0);
                    this.averageRating = total / ratings.length;
                } else {
                    this.averageRating = null;
                }
            });
        },
        fetchUserRating() {
            axios.get(`/books/${this.id}/my-rating`)
                .then(res => {
                    if (res.data && res.data.rating) {
                        this.selectedRating = res.data.rating;
                        this.rating = res.data.rating;
                    }
                })
                .catch(error => {
                    console.error("Kļūda ielādējot my-rating:", error);
                });
        },
        saveRating() {
            if (!this.selectedRating) return alert("Lūdzu izvēlies vērtējumu!");
            axios.post(`/books/${this.book.id}/ratings`, { rating: this.selectedRating })
                .then(() => {
                    this.rating = this.selectedRating;
                    this.ratingSaved = true;
                    this.fetchRatings();
                    setTimeout(() => this.ratingSaved = false, 3000);
                });
        },
        fetchComments() {
            axios.get(`/books/${this.id}/comments`).then(res => this.comments = res.data);
        },
        fetchFolders() {
            axios.get('/folders').then(res => this.folders = res.data);
        },
        saveBookToFolder() {
            if (!this.selectedFolderId) return alert("Lūdzu izvēlies mapi!");
            axios.post(`/folders/${this.selectedFolderId}/books`, { book_id: this.book.id })
                .then(() => {
                    this.isSavedToFolder = true;
                    this.showAddedToFolderModal = true;
                });
        },

        submitFeedback() {
            if (!this.comment) return alert("Lūdzu ieraksti komentāru!");
            axios.post(`/books/${this.book.id}/comments`, { comment: this.comment }).then(() => {
                this.fetchComments();
                this.comment = '';
                this.visibleCommentsCount = Math.max(this.visibleCommentsCount, this.comments.length);
            });
        },

        confirmDelete(commentId) {
            this.commentToDeleteId = commentId;
            this.deleteModalVisible = true;
        },
        deleteCommentConfirmed() {
            axios.delete(`/comments/${this.commentToDeleteId}`)
                .then(() => {
                    // Noņem komentāru no vietējā saraksta
                    this.comments = this.comments.filter(c => c.id !== this.commentToDeleteId)
                    this.deleteModalVisible = false
                    this.commentToDeleteId = null
                })
                .catch(error => {
                    console.error("Neizdevās izdzēst komentāru:", error)
                })
        }
        ,
        cancelDelete() {
            this.deleteModalVisible = false;
            this.commentToDeleteId = null;
        },
        toggleComments() {
            this.showAllComments = !this.showAllComments;
        },
    },
    watch: {
        id() {
            this.fetchBook();
            this.fetchRatings();
            this.fetchComments();
            this.fetchFolders();
            this.fetchUserRating();
        }
    },
};
</script>


<style>
select:disabled {
    background-color: #f3f4f6;
    cursor: not-allowed;
}
svg {
    transition: transform 0.2s ease, color 0.3s ease;
}
</style>
