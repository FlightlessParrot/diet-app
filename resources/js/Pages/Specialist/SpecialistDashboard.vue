<script setup>
import SpecialistLayout from '@/Layouts/SpecialistLayout.vue';
import { Head,  } from '@inertiajs/vue3';
import DashboardTemplate from "@/Parts/DashboardTemplate.vue"

const props = defineProps({
    notifications: {
        type: Object
    }
})
</script>

<template>
    <Head title="Tablica" />

    <SpecialistLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tablica specjalisty</h2>
        </template>
        <DashboardTemplate :notifications="notifications" :specialist="true" />
            </SpecialistLayout>
</template>
