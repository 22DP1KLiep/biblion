<template>
    <Navbar />
    <div class="container mx-auto p-6">
        <div v-if="book" class="max-w-5xl mx-auto bg-white p-6 rounded shadow flex gap-6">
            <div class="w-1/3">
                <img :src="book.image ? `/${book.image}` : 'https://via.placeholder.com/300'" alt="Book cover" class="w-full h-auto object-cover rounded" />
            </div>

            <div class="w-2/3 flex flex-col">
                <h1 class="text-3xl font-bold mb-2">{{ book.title }}</h1>
                <p class="text-xl text-gray-700 mb-4">by {{ book.author }}</p>
                <p class="text-gray-600 mb-4">{{ book.description }}</p>

                <div v-if="$page.props.auth.user">
                    <!-- Rating input -->
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" v-model="rating"><label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4" v-model="rating"><label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3" v-model="rating"><label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2" v-model="rating"><label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1" v-model="rating"><label for="star1">★</label>
                    </div>
                    <p>Rating: {{ rating }} / 5</p>

                    <!-- Comment input -->
                    <div class="mt-4">
                        <label class="block text-gray-700 font-semibold mb-1">Your Comment:</label>
                        <textarea v-model="comment" class="w-full border rounded p-2" rows="4" placeholder="Write your thoughts..."></textarea>
                        <button class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" @click="submitFeedback">Submit</button>
                    </div>
                </div>
                <div v-else class="mt-4 bg-yellow-100 border border-yellow-400 p-4 rounded">
                    Lai komentētu vai vērtētu šo grāmatu, lūdzu <a href="/login" class="text-blue-500 underline">ienāc sistēmā</a>.
                </div>

                <!-- Average Rating -->
                <div v-if="averageRating !== null" class="mb-6 flex items-center gap-2 mt-4">
                    <span class="text-xl font-semibold">Average Rating:</span>
                    <span class="text-yellow-500 text-2xl">
                        <template v-for="n in 5">
                            <span v-if="n <= Math.round(averageRating)">★</span>
                            <span v-else class="text-gray-300">★</span>
                        </template>
                    </span>
                    <span class="text-gray-700">({{ averageRating.toFixed(1) }} / 5)</span>
                </div>

                <!-- Comments -->
                <div class="mt-10">
                    <h2 class="text-2xl font-semibold mb-4">Reader Reviews</h2>
                    <div v-if="comments.length > 0" class="space-y-4">
                        <div v-for="c in comments" :key="c.id" class="border-t pt-4">
                            <p class="text-gray-800"><strong>{{ c.user?.username || 'Anonīms' }}</strong> vērtējums: {{ c.rating }} ★</p>
                            <p class="text-gray-600 whitespace-pre-wrap">{{ c.comment }}</p>
                            <button
                                v-if="$page.props.auth.user && c.user_id === $page.props.auth.user.id"
                                @click="deleteComment(c.id)"
                                class="mt-2 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Dzēst
                            </button>
                        </div>
                    </div>
                    <div v-else class="text-gray-500">No reviews yet. Be the first to leave one!</div>
                </div>
            </div>
        </div>

        <div v-else class="text-center text-gray-500">Loading book info...</div>
    </div>
    <Testimonial />
    <Footer />
</template>

<script>
import axios from 'axios';
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import Testimonial from "@/Components/Testimonial.vue";

export default {
    components: { Testimonial, Footer, Navbar },
    props: ['id'],
    data() {
        return {
            book: null,
            rating: '',
            comment: '',
            comments: [],
            averageRating: null,
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

        this.fetchRatings();
        this.fetchComments();
    },
    methods: {
        fetchRatings() {
            axios.get(`/books/${this.id}/ratings`)
                .then(response => {
                    const ratings = response.data;
                    if (ratings.length > 0) {
                        const total = ratings.reduce((sum, r) => sum + Number(r.rating), 0);
                        this.averageRating = total / ratings.length;
                    } else {
                        this.averageRating = null;
                    }
                })
                .catch(error => {
                    console.error("Failed to load ratings:", error);
                });
        },
        fetchComments() {
            axios.get(`/books/${this.id}/comments`)
                .then(response => {
                    this.comments = response.data;
                })
                .catch(error => {
                    console.error("Failed to load comments:", error);
                });
        },
        submitFeedback() {
            if (!this.rating || !this.comment) {
                alert("Please provide both rating and comment.");
                return;
            }

            const bookId = this.book.id;

            axios.post(`/books/${bookId}/ratings`, { rating: this.rating })
                .then(() => this.fetchRatings())
                .catch(error => {
                    console.error("Failed to submit rating:", error.response?.data || error);
                });

            axios.post(`/books/${bookId}/comments`, { comment: this.comment })
                .then(() => {
                    this.fetchComments();
                    this.comment = '';
                    this.rating = '';
                    alert("Thank you for your feedback!");
                })
                .catch(error => {
                    console.error("Failed to submit comment:", error.response?.data || error);
                });
        },
        deleteComment(commentId) {
            if (confirm('Vai tiešām vēlies dzēst šo komentāru?')) {
                axios.delete(`/comments/${commentId}`)
                    .then(() => this.fetchComments())
                    .catch(error => {
                        console.error("Failed to delete comment:", error.response?.data || error);
                    });
            }
        }
    },
    watch: {
        id() {
            this.fetchRatings();
            this.fetchComments();
        }
    }
};
</script>



<style>
.star-rating {
    direction: rtl;
    display: flex;
    justify-content: flex-start;
    gap: 5px;
    margin-left: auto;
}
.star-rating input {
    display: none;
}
.star-rating label {
    font-size: 32px;
    color: lightgray;
    cursor: pointer;
    transition: color 0.3s ease;
}
.star-rating input:checked ~ label {
    color: gold;
}
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: gold;
}
</style>
