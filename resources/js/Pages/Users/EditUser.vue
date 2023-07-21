<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import EditUserForm from '@/Pages/Users/Partials/EditUserForm.vue';
defineProps({
    user: Object,
    roles: Object,
})
</script>

<template>
    <AppLayout title="Edit User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditUserForm :user="user" :roles="roles" />
            </div>
        </div>
    </AppLayout>
</template>
