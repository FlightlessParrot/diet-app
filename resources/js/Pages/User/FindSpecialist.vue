<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FindSpecialistTemplate from "@/Parts/FindSpecialistTemplate.vue"


const props = defineProps({
    categories: {
        type: Array,
    },
    services: {
        type: Array,
    },
    paginatedSpecialists: {
        type: Object
    }
});
</script>
<template>
    <Head>
        <title>Znajdź specialistę</title>
    </Head>
    <AuthenticatedLayout>
            <FindSpecialistTemplate :guest='false' :categories="categories" :services="services" :paginatedSpecialists='paginatedSpecialists' />
    </AuthenticatedLayout>
</template>
