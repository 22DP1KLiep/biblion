<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'


const props = defineProps({
    users: Array
})

const page = usePage()
const currentUserId = page.props.auth.user.id

const search = ref('')

const filteredUsers = computed(() => {
    if (!search.value) return props.users
    return props.users.filter(u =>
        u.name.toLowerCase().includes(search.value.toLowerCase()) ||
        u.email.toLowerCase().includes(search.value.toLowerCase())
    )
})

const changeRole = (user, role) => {
    router.patch(`/admin/users/${user.id}/role`, { role })
}

const deleteUser = (user) => {
    if (confirm(`Dzēst lietotāju "${user.name}"?`)) {
        router.delete(`/admin/users/${user.id}`)
    }
}

const restrictUser = (userId, days) => {
    if (!confirm(`Restrict this user for ${days} days?`)) return

    router.patch(`/admin/users/${userId}/restrict`, { days }, {
        preserveScroll: true,
        onSuccess: () => {
            router.reload({ only: ['users'] })
        }
    })
}

</script>

<template>
    <AdminLayout>
    <div class="min-h-screen bg-[#f0f4f8]">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-[#213555]">
                        Users Management
                    </h1>
                    <p class="text-sm text-gray-600">
                        Manage user accounts and permissions
                    </p>
                </div>

                <button
                    class="bg-[#213555] hover:bg-[#3E5879] text-white px-4 py-2 rounded-lg shadow"
                >
                    ➕ Add User
                </button>
            </div>

            <!-- Search -->
            <div class="mb-4">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search users..."
                    class="w-full sm:w-96 px-4 py-2 rounded-lg border border-gray-300
                           focus:ring-2 focus:ring-[#213555] focus:outline-none"
                />
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#f5f7fa] text-[#213555]">
                        <tr>
                            <th class="text-left px-4 py-3">Name</th>
                            <th class="text-left px-4 py-3">Email</th>
                            <th class="text-left px-4 py-3">Role</th>
                            <th class="text-left px-4 py-3">Status</th>
                            <th class="text-left px-4 py-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="user in filteredUsers"
                            :key="user.id"
                            class="border-t hover:bg-gray-50 transition"
                        >
                            <td class="px-4 py-3 font-medium">
                                {{ user.name }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ user.email }}
                            </td>

                            <!-- Role -->
                            <td class="px-4 py-3">
                                <select
                                    :value="user.role"
                                    @change="changeRole(user, $event.target.value)"
                                    :disabled="user.id === currentUserId"
                                    class="px-2 py-1 rounded-md text-xs font-medium border border-gray-300
                                           focus:ring-1 focus:ring-[#213555]"
                                    :class="user.role === 'admin'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-blue-100 text-blue-700'"
                                >
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                <span
                                    v-if="user.restricted_until && new Date(user.restricted_until) > new Date()"
                                    class="px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700"
                                >
                                    Restricted
                                </span>

                                <span
                                    v-else
                                    class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700"
                                >
                                    Active
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 flex gap-3 text-lg">
                                <button title="View">👁️</button>
                                <button title="Edit">✏️</button>
                                <button
                                    v-if="user.id !== currentUserId"
                                    @click="deleteUser(user)"
                                    title="Delete"
                                    class="text-red-500 hover:text-red-700"
                                >
                                    🗑️
                                </button>
                                <button
                                    class="text-xs text-orange-600 hover:underline"
                                    @click="restrictUser(user.id, 1)"
                                >
                                    Restrict 1d
                                </button>

                                <button
                                    class="text-xs text-orange-600 hover:underline ml-2"
                                    @click="restrictUser(user.id, 7)"
                                >
                                    Restrict 7d
                                </button>

                            </td>
                        </tr>
                    </tbody>
                </table>

                <div
                    v-if="!filteredUsers.length"
                    class="p-6 text-center text-gray-500"
                >
                    No users found.
                </div>
            </div>
        </div>
    </div>
    </AdminLayout>
</template>
