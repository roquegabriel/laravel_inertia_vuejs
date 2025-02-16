<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import PaginationLinks from '../../Components/PaginationLinks.vue'
import RoleSelect from '../../Components/RoleSelect.vue';
import SessionMessages from '../../Components/SessionMessages.vue'
import InputField from '../../Components/InputField.vue'
defineProps({
    users: Object,
    status: String
})

const params = route().params

const form = useForm({
    search: params.search
})

const search = () => {
    router.get(route('admin.index'), {
        search: form.search,
        user_role: params.user_role
    })
}

const toggleRole = (e) => {
    if (e.target.checked) {
        router.get(route('admin.index', {
            search: params.search,
            user_role: 'suspended'
        }))
    } else {
        router.get(route('admin.index', {
            search: params.search,
            user_role: null
        }))
    }
}
</script>
<template>

    <Head title="Admin" />
    <SessionMessages :status="status" />
    <!-- Heading -->
    <div class="sm:flex items-end justify-between mb-4 grid">
        <div class="flex items-end gap-2">
            <!-- Search -->
            <form @submit.prevent="search">
                <InputField v-model="form.search" label="" icon="magnifying-glass" placeholder="Search..." />
            </form>
            <Link v-if="params.search" :href="route('admin.index', { ...params, search: null, page: null })"
                class="px-2 py-[7px] rounded-md bg-indigo-500 text-white flex items-center gap-2">{{ params.search }}
            <font-awesome-icon icon="xmark" />
            </Link>
        </div>
        <div class="flex items-center gap-1 text-xs hover:bg-slate-300 dark:hover:bg-slate-800 px-2 py-1 rounded-md">
            <input :checked="params.user_role" @input="toggleRole" type="checkbox" id="toggleRole"
                class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer">
            <label for="toggleRole"
                class="block text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">Show suspended
                users</label>
        </div>
    </div>
    <!-- Table -->
    <div class="overflow-y-scroll sm:overflow-hidden">

        <table class="bg-white table-auto dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300 ">
            <thead>
                <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
                    <th class="w-3/6 p-3">Name</th>
                    <th class="w-1/6 p-3">Role</th>
                    <th class="w-1/6 p-3">Listings</th>
                    <th class="w-1/12 p-3 text-right">View</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 divide-dashed">
                <tr v-for="user in users.data" :key="user.id">
                    <td class="w-3/6 py-5 px-3">
                        <p class="font-bold mb-1">{{ user.name }}</p>
                        <p class="font-light text-xs">{{ user.email }}</p>
                    </td>
                    <td class="w-1/6 py-5 px-3">
                        <!-- Select -->
                        <RoleSelect :user="user" />
                    </td>
                    <td class="w-1/6 py-5 px-3">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-1">
                                <p>{{ user.listings.filter((i) => i.approved).length }}</p>
                                <font-awesome-icon icon="circle-check" class="text-green-500" />
                            </div>
                            <div class="flex items-center gap-1">
                                <p>{{ user.listings.filter(i => !i.approved).length }}</p>
                                <font-awesome-icon icon="circle-xmark" class="text-red-500" />
                            </div>
                        </div>
                    </td>
                    <td class="w-1/12 py-5 px-3 text-right">
                        <Link :href="route('user.show', user.id)" class="px-3 text-indigo-400">
                        <font-awesome-icon icon="up-right-from-square" />
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="my-6">
            <PaginationLinks :paginator="users" />
        </div>
    </div>
</template>
