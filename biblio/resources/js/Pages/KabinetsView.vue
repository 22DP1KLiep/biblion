<template>
    <Navbar />

    <!-- Ja lietotājs ir ielogojies -->
    <div v-if="user" class="flex flex-col md:flex-row min-h-screen bg-[#f0f4f8]">
        <!-- Sidebar -->
        <aside
            class="w-full md:w-72 bg-white border-r border-gray-200 shadow-md p-6 flex flex-col rounded-none md:rounded-tr-xl md:rounded-br-xl mb-6 md:mb-0">
            <!-- Lietotājs + iziet -->
            <div class="flex items-center justify-between mb-6">
                <p class="text-[15px] font-medium text-[#213555] truncate">👤 {{ user.username }}</p>
                <button
                    @click="logout"
                    class="text-[11px] bg-red-500 hover:bg-red-600 text-white px-2 py-[3px] rounded transition"
                    title="Iziet"
                >
                    Iziet
                </button>
            </div>

            <!-- Mapes + jauna mape -->
            <div class="flex-1 overflow-y-auto pr-1">
                <h2 class="text-sm font-semibold text-[#3E5879] mb-3 uppercase tracking-wide">Tavas mapes</h2>
                <ul class="space-y-2 mb-4">
                    <li
                        v-for="folder in folders"
                        :key="folder.id"
                        class="flex items-center justify-between bg-[#f5f7fa] hover:bg-[#e6ecf3] transition rounded px-3 py-2"
                    >
                        <span class="text-[#213555] text-sm cursor-pointer" @click="selectFolder(folder.id)">
                            📁 {{ folder.name }}
                        </span>
                        <button
                            @click="openDeleteFolderModal(folder.id)"
                            class="text-red-500 hover:text-red-700 text-sm"
                            title="Dzēst mapi"
                        >
                            🗑️
                        </button>
                    </li>
                </ul>

                <!-- Jaunas mapes izveide -->
                <div>
                    <h2 class="text-sm font-semibold text-[#3E5879] mb-2 uppercase tracking-wide">Jauna mape</h2>
                    <input
                        type="text"
                        v-model="newFolderName"
                        placeholder="Mapes nosaukums"
                        class="w-full border border-gray-300 px-2 py-1 rounded mb-2 text-sm focus:ring-2 focus:ring-[#213555] focus:outline-none"
                    />
                    <button
                        @click="createFolder"
                        class="w-full bg-[#213555] hover:bg-[#3E5879] text-white py-1 rounded text-sm transition"
                    >
                        Pievienot
                    </button>
                </div>
            </div>
        </aside>

        <!-- Saturs -->
        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
            <h1 class="text-xl sm:text-2xl font-bold text-[#213555] mb-6">
                📂 {{ selectedFolderName || 'Nav atlasīta mape' }}
            </h1>

            <div v-if="books.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <BookCard
                    v-for="book in books"
                    :key="book.id"
                    :book="book"
                    :folder-id="selectedFolderId"
                    @removed="removeBookFromList"
                />
            </div>

            <div v-else class="text-gray-500 italic mt-10 text-center">
                Šajā mapē vēl nav nevienas grāmatas.
            </div>
        </main>
    </div>

    <!-- Ja lietotājs nav ielogojies -->
    <div v-else class="flex items-center justify-center min-h-screen bg-gray-100 px-4 text-sm">
        <div class="bg-white shadow-xl rounded-lg p-8 text-center max-w-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">
                Šī sadaļa pieejama tikai reģistrētiem lietotājiem
            </h2>
            <p class="mb-6 text-gray-600">Lūdzu pieslēdzieties, lai skatītu savu grāmatu kabinetu.</p>
            <button
                @click="redirectToLogin"
                class="bg-[#213555] hover:bg-[#3E5879] text-white px-6 py-2 rounded-lg transition"
            >
                Iet uz autorizāciju
            </button>
        </div>
    </div>

    <!-- MODĀLIS mapes dzēšanai -->
    <div v-if="showDeleteFolderModal" class="fixed inset-0 bg-black/50 flex justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-80 text-center">
            <h3 class="text-lg font-semibold mb-4">Apstiprināt dzēšanu</h3>
            <p class="text-gray-700 mb-4">Vai tiešām vēlies dzēst šo mapi? Tās saturs tiks noņemts.</p>
            <div class="flex justify-center gap-4">
                <button @click="cancelDeleteFolder" class="px-4 py-2 bg-gray-200 rounded">Atcelt</button>
                <button @click="deleteFolderConfirmed" class="px-4 py-2 bg-red-500 text-white rounded">Dzēst</button>
            </div>
        </div>
    </div>

    <Footer />
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import axios from 'axios'

import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'
import BookCard from '@/Components/BookCard.vue'

const page = usePage()
const user = computed(() => page.props.auth?.user)

const folders = ref([])
const books = ref([])
const selectedFolderName = ref('')
const selectedFolderId = ref(null)
const newFolderName = ref('')

const showRemoveBookModal = ref(false)
const bookToRemove = ref(null)

const showDeleteFolderModal = ref(false)
const folderToDelete = ref(null)

const removeBookFromList = (bookId) => {
    books.value = books.value.filter(b => b.id !== bookId)
}

const logout = () => {
    router.post('/logout')
}

const redirectToLogin = () => {
    window.location.href = '/auth'
}

const fetchFolders = async () => {
    try {
        const response = await axios.get('/folders')
        folders.value = response.data
    } catch (error) {
        console.error('Kļūda ielādējot mapes:', error)
    }
}

watch(user, (newVal) => {
    if (newVal) {
        fetchFolders()
    }
}, { immediate: true })

const selectFolder = async (folderId) => {
    try {
        const response = await axios.get(`/folders/${folderId}/books`)
        books.value = response.data.books
        selectedFolderName.value = response.data.folder.name
        selectedFolderId.value = folderId
    } catch (error) {
        console.error('Kļūda ielādējot mapi:', error)
    }
}

const createFolder = async () => {
    if (!newFolderName.value.trim()) return
    try {
        await axios.post('/folders', { name: newFolderName.value })
        newFolderName.value = ''
        fetchFolders()
    } catch (error) {
        console.error('Kļūda veidojot mapi:', error)
    }
}

const openDeleteFolderModal = (folderId) => {
    folderToDelete.value = folderId
    showDeleteFolderModal.value = true
}

const cancelDeleteFolder = () => {
    showDeleteFolderModal.value = false
    folderToDelete.value = null
}

const deleteFolderConfirmed = async () => {
    try {
        await axios.delete(`/folders/${folderToDelete.value}`)
        folders.value = folders.value.filter(f => f.id !== folderToDelete.value)

        if (selectedFolderId.value === folderToDelete.value) {
            books.value = []
            selectedFolderName.value = ''
            selectedFolderId.value = null
        }

        showDeleteFolderModal.value = false
        folderToDelete.value = null
    } catch (error) {
        console.error('Kļūda dzēšot mapi:', error)
    }
}
</script>

<style scoped>
body {
    font-family: 'Inter', sans-serif;
}
</style>
