<template>
    <div>
        <Navbar />
        <main>
            <!-- SLIDER SECTION  -->
            <section class="relative bg-cover bg-center h-[80vh] shadow-xl overflow-hidden" style="background-image: url('/img/blue_wallpaper.jpg');">
            <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center items-center text-center px-4">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight drop-shadow-lg">
                        Atrodi savu nākamo <br> iecienīto grāmatu
                    </h2>
                    <p class="text-lg text-gray-200 max-w-xl mb-6">
                        Lasīšana nav tikai hobijs — tā ir ceļošana laikā, idejās un sajūtās.
                    </p>
                <button
                    @click="goToBooks"
                    class="bg-gradient-to-r from-[#213555] to-[#3E5879] text-white font-semibold py-3 px-6 rounded-md shadow-lg hover:scale-105 transition-all duration-300"
                >
                    Skatīt visas grāmatas
                </button>


            </div>
            </section>

       <showBook />
        </main>
<!--        <Testimonial />-->
        <Footer />
    </div>
</template>

<script>
import Navbar from "../Components/navbar.vue";
import Footer from "../Components/footer.vue";
import ShowBook from "@/Components/showBook.vue";
import Partners from "@/Components/Partners.vue";
import Testimonial from "@/Components/Testimonial.vue";

export default {
    components: {
        Testimonial,
        Partners,
        ShowBook,
        Navbar,
        Footer,
    },
    data() {
        return {

            currentSlide: 0,
            slides: [
                { src: "/img/hand-drawn-book-club-facebook-cover-b.png" },
                { src: "/img/hand-drawn-book-club-twitch-banner-template.png"},
                { src: "/img/1.jpg"},
            ],
            books: []
        };
    },
    methods: {
        changeSlide(n) {
            this.currentSlide = (this.currentSlide + n + this.slides.length) % this.slides.length;
        },
        goToBooks() {
            this.$inertia.visit('/gramatas');
        }

    },
    mounted() {
        axios.get('/books') // vai /get/all/books ja vēlies visas
            .then(response => {
                this.books = response.data;
            })
            .catch(error => {
                console.error("Kļūda ielādējot grāmatas:", error);
            });

        setInterval(() => {
            this.changeSlide(1);
        }, 3000);
    }

};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

* {
    font-family: 'Poppins', sans-serif;
}

.slideshow-container {
    max-width: 1200px;
    height: 500px;
    position: relative;
    margin: 60px auto;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.mySlides {
    display: none;
    position: relative;
}

.mySlides.active {
    display: block;
}

.mySlides img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.8);
}

.numbertext {
    position: absolute;
    top: 15px;
    left: 20px;
    color: #fff;
    font-size: 18px;
    font-weight: 500;
}

.text {
    position: absolute;
    bottom: 20px;
    left: 30px;
    color: #fff;
    font-size: 28px;
    font-weight: bold;
    background-color: rgba(0,0,0,0.4);
    padding: 12px 20px;
    border-radius: 10px;
}

.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    padding: 12px;
    color: #fff;
    font-size: 24px;
    background: rgba(0, 0, 0, 0.4);
    border-radius: 50%;
    transition: background 0.3s;
}

.prev:hover, .next:hover {
    background: rgba(255, 255, 255, 0.8);
    color: black;
}

.next {
    right: 20px;
}

.prev {
    left: 20px;
}

.dots-container {
    text-align: center;
    margin-top: 20px;
}

.dot {
    cursor: pointer;
    height: 12px;
    width: 12px;
    margin: 0 5px;
    background-color: #ccc;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.dot.active, .dot:hover {
    background-color: #333;
}

.intro-text {
    font-size: 26px;
    font-weight: 600;
    text-align: center;
    margin: 60px auto 40px;
    max-width: 800px;
    line-height: 1.5;
    color: #444;
}

.book-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto 80px;
    padding: 0 20px;
}

.book-card {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    text-align: left;
    transition: transform 0.3s, box-shadow 0.3s;
}

.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 24px rgba(0, 0, 0, 0.15);
}

.book-title {
    font-weight: 600;
    font-size: 18px;
    margin-top: 10px;
    color: #222;
}

.top10 {
    font-weight: 700;
    text-align: center;
    font-size: 36px;
    margin-top: 80px;
    color: #2c3e50;
}

</style>
