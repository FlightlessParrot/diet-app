<script setup>
import Tile from '@/Components/Tile.vue';
import {  Head} from '@inertiajs/vue3';
import SpecialistLayout from '@/Layouts/SpecialistLayout.vue';
import { useOfferDurationDescription } from '@/Composables/useOfferDurationDescription';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestLayoutForPages from '@/Layouts/GuestLayoutForPages.vue';

const props = defineProps({
    offer: {
        type: Object,
        required: true
    }
})

</script>
<template>
<GuestLayoutForPages>
    <Head> <title> {{ offer.name }}</title></Head>
    <template #header>
         <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ offer.name }}
        </h1>
    </template>
   
    <Tile>
       
        <b class="text-darkPink text-xl block text-end"> {{ useOfferDurationDescription(offer) }}</b>
        
        <b class="text-emerald-600 text-lg block text-end">Teraz tylko {{ Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.price) }}</b>
       
       
       <section v-html="offer.description">
       </section>
    
    </Tile>
   
        
</GuestLayoutForPages>
</template>