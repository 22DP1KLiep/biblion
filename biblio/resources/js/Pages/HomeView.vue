<template>
    <div>
        <Navbar />
        <main>
            <!-- SLIDER SECTION  -->
            <div class="slideshow-container">
                <div v-for="(slide, index) in slides" :key="index" class="mySlides" :class="{ active: index === currentSlide }">
                    <div class="numbertext">{{ index + 1 }} / {{ slides.length }}</div>
                    <img :src="slide.src" alt="Slide Image" />
                    <div class="text">{{ slide.caption }}</div>
                </div>
                <a class="prev" @click="changeSlide(-1)">&#10094;</a>
                <a class="next" @click="changeSlide(1)">&#10095;</a>
            </div>
            <div class="dots-container">
                <span v-for="(slide, index) in slides" :key="index" class="dot" @click="currentSlide = index" :class="{ active: index === currentSlide }"></span>
            </div>

            <div class="intro-text">
                "Lasīt grāmatas ir kā ceļot laikā un telpā – un šeit Tu vari atrast savu nākamo galamērķi!"
            </div>

            <Partners />
            <showBook />
        </main>
        <Testimonial />
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
.slideshow-container {
    max-width: 1200px;
    height: 500px;
    position: relative;
    margin: 40px auto;
    border: 2px solid #ccc;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.mySlides {
    display: none;
}
.mySlides.active {
    display: block;
}
.mySlides img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background-color: #F5EFE7;
}
.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    padding: 16px;
    color: white;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 3px;
    user-select: none;
}
.next {
    right: 0;
}
.prev:hover, .next:hover {
    background-color: rgba(255, 255, 255, 0.8);
}
.dots-container {
    text-align: center;
    margin-top: 10px;
}
.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}
.active, .dot:hover {
    background-color: #ffffff;
}
.intro-text {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin: 50px auto;
    max-width: 700px;
}
.book-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    max-width: 6000px;
    margin: 75px;
}
.book-card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
    transition: transform 0.3s;
}
.book-card:hover {
    transform: scale(1.05);
}
.book-title {
    font-weight: bold;
    margin-top: 10px;
}
.top10{
    Font-weight: bold;
    text-align: center;
    font-size: 35px;
}
</style>
