<script setup>
import { Head } from "@inertiajs/vue3";
import Title from "@/Components/Title.vue";
import FindSpecialistTemplate from "@/Parts/FindSpecialistTemplate.vue"
import GuestLayoutForPages from "@/Layouts/GuestLayoutForPages.vue";


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
    <GuestLayoutForPages>
            <FindSpecialistTemplate :guest="true" :categories="categories" :services="services" :paginatedSpecialists='paginatedSpecialists' />
    </GuestLayoutForPages>
</template>
