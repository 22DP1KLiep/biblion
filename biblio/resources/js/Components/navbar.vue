<script setup>

import {ref} from "vue";

const isMenuActive = ref(false);

const toggleNav = () => {
    isMenuActive.value = !isMenuActive.value;
};

// Logout function

</script>


<template>
    <nav>
        <div class="logo">
            <h1><a href="/">Biblio</a></h1>
        </div>
        <ul>

            <li><a href="/gramatas">Grāmatas</a></li>
            <li><a href="/kabinets">Mans kabinets</a></li>
            <li><a href="/login">Login</a></li>
        </ul>
        <!-- Hamburger Menu -->
        <div class="hamburger" @click="toggleNav">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </nav>
    <!-- Menubar for Mobile -->
    <div class="menubar" :class="{ active: isMenuActive }">
        <ul>

            <li><a href="/about">Grāmatas</a></li>
            <li><a href="/kabinets">Mans kabinets</a></li>
            <li><a href="/login">Login</a></li>
            <!--            <li><a :href="routes.login">Login</a></li>-->
        </ul>
    </div>
</template>



<style scoped>
.menubar ul {
    list-style-type: none; /* Remove bullet points */
    padding: 0;
    margin: 0;
    display: flex; /* Use flexbox for layout */
    flex-direction: column; /* Stack items vertically */
    align-items: center; /* Center items horizontally */
    justify-content: center; /* Center items vertically */
}

.menubar li {
    margin: 10px 0; /* Add some spacing between menu items */
}

.menubar i.icon {
    font-size: 24px; /* Adjust icon size */
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

.hamburger-active {
    transition: all 0.3s ease-in-out;
    transition-delay: 0.6s;
    transform: rotate(45deg);
}

.hamburger-active .line:nth-child(2) {
    width: 0px;
}

.hamburger-active .line:nth-child(1),
.hamburger-active .line:nth-child(3) {
    transition-delay: 0.3s;
}

.hamburger-active .line:nth-child(1) {
    transform: translateY(12px);
}

.hamburger-active .line:nth-child(3) {
    transform: translateY(-5px) rotate(90deg);
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

.icon {
    font-size: 1.2rem;
}

.menubar ul li a:hover {
    background-color: #ac60bf;
}

/* Media Query for Mobile */
@media screen and (max-width: 790px) {
    .hamburger {
        display: block;
    }
    nav ul {
        display: none;
    }
}
</style>
