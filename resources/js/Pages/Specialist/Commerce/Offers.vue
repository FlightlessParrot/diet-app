<script setup>
import SpecialistLayout from "@/Layouts/SpecialistLayout.vue";
import Offer from "@/Components/Offer.vue"
import { router, Head } from "@inertiajs/vue3";
const prop = defineProps({
    offers: {
        type: Array,
        required: true,
    },
});


</script>
<template>
    <SpecialistLayout>
        <template #header>
           <h1 class="font-semibold text-xl text-gray-800 leading-tight">Oferty</h1> 
        </template>
        <Head> <title>Oferty</title></Head>
        <div class="max-w-7xl grid justify-items-center lg:grid-cols-3 mx-auto gap-8 py-12">
            <Offer v-for="offer in offers" :offer="offer" @chose="router.get(route('offer.show',[offer.id]))" />
        </div>
    </SpecialistLayout>
</template>
