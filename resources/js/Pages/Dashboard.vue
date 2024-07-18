<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DashboardTemplate from '@/Parts/DashboardTemplate.vue';
const props = defineProps({
    notifications: {
        type: Object
    }
})
</script>

<template>
    <Head title="Tablica" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tablica</h2>
        </template>
        <DashboardTemplate :notifications="notifications" :specialist="false" />
    </AuthenticatedLayout>
</template>
