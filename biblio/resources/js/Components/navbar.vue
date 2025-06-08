<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const isMenuActive = ref(false);
const searchQuery = ref("");

const toggleNav = () => {
    isMenuActive.value = !isMenuActive.value;
};

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        window.location.href = `/gramatas?q=${encodeURIComponent(searchQuery.value.trim())}`;
    }
};

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <nav>
        <div class="logo">
            <h1><a href="/">Biblio</a></h1>
        </div>

        <!-- Meklēšana uz lieliem ekrāniem -->
        <form @submit.prevent="handleSearch" class="search-form">
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Meklēt grāmatu..."
                class="search-input"
            />
        </form>

        <!-- Galvenā izvēlne -->
        <ul>
            <li><a href="/gramatas">Grāmatas</a></li>
            <li><a href="/kabinets">Mans kabinets</a></li>
            <li v-if="!user"><a href="/auth">Ienākt</a></li>
            <li v-else>
                <Link href="/logout" method="post" as="button" class="logout-button">Iziet</Link>
            </li>
        </ul>

        <div class="hamburger" @click="toggleNav">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </nav>

    <!-- Mobilā izvēlne -->
    <div class="menubar" :class="{ active: isMenuActive }">
        <!-- Meklēšana mobilajā versijā -->
        <form @submit.prevent="handleSearch" class="search-form-mobile">
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Meklēt..."
                class="search-input-mobile"
            />
        </form>

        <ul>
            <li><a href="/gramatas">Grāmatas</a></li>
            <li><a href="/kabinets">Mans kabinets</a></li>
            <li v-if="!user"><a href="/auth">Ienākt</a></li>

            <li v-else>
                <Link href="/logout" method="post" as="button" class="logout-button">Iziet</Link>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.logout-button {
    background: transparent;
    border: none;
    color: #ffffff;
    cursor: pointer;
    padding: 0 8px;
    font-size: 95%;
    font-weight: 400;
    border-radius: 5px;
    line-height: 1.5;
    vertical-align: middle;
    display: inline-block;
}
.logout-button:hover {
    color: #e6722a;
}

.search-form {
    margin-left: auto;
    display: flex;
    align-items: center;
}
.search-input {
    padding: 5px 10px;
    border-radius: 5px;
    border: none;
    font-size: 90%;
    outline: none;
}
.search-input:focus {
    border: 1px solid #e6722a;
}

/* Mobilā meklēšana */
.search-form-mobile {
    width: 80%;
    margin: 10px auto 20px auto;
    text-align: center;
}
.search-input-mobile {
    width: 100%;
    padding: 8px 12px;
    font-size: 90%;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
}

.menubar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.menubar li {
    margin: 10px 0;
}

.menubar i.icon {
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

nav {
    background-color: rgb(33, 53, 85);
    padding: 5px 2%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
    rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    z-index: 1;
    height: 55px;
}

nav .logo {
    display: flex;
    align-items: center;
}

nav .logo img {
    height: 25px;
    width: auto;
    margin-right: 10px;
}

nav .logo h1 {
    font-size: 1.5rem;
    background: white;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

nav ul {
    list-style: none;
    display: flex;
}

nav ul li {
    margin-left: 0.5rem;
}

nav ul li a {
    text-decoration: none;
    color: #ffffff;
    font-size: 95%;
    font-weight: 400;
    padding: 4px 8px;
    border-radius: 5px;
}
nav ul li a:hover {
    color: #e6722a;
}

.hamburger {
    display: none;
    cursor: pointer;
}
.hamburger .line {
    width: 25px;
    height: 2px;
    background-color: #ffffff;
    display: block;
    margin: 7px auto;
    transition: all 0.3s ease-in-out;
}

.menubar {
    position: absolute;
    top: 0;
    left: -60%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: 60%;
    height: 100vh;
    padding: 20% 0;
    background: rgba(255, 255, 255);
    transition: all 0.5s ease-in;
    z-index: 2;
}

.menubar.active {
    left: 0;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}

.menubar ul {
    padding: 0;
    list-style: none;
}

.menubar ul li {
    margin-bottom: 32px;
}

.menubar ul li a {
    text-decoration: none;
    color: #000;
    font-size: 95%;
    font-weight: 400;
    padding: 5px 10px;
    border-radius: 5px;
}
.menubar ul li a:hover {
    background-color: #ac60bf;
}

@media screen and (max-width: 790px) {
    .hamburger {
        display: block;
    }
    nav ul {
        display: none;
    }
    .search-form {
        display: none;
    }
}
</style>
