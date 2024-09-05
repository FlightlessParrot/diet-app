<script setup>
import Tile from '@/Components/Tile.vue';
import {  Head } from '@inertiajs/vue3';
import SpecialistLayout from '@/Layouts/SpecialistLayout.vue';
import { useOfferDurationDescription } from '@/Composables/useOfferDurationDescription';
import Button from 'primevue/button';
import { ref } from 'vue';
const props = defineProps({
    offer: {
        type: Object,
        required: true
    }
})
const disabled=ref(false)
</script>
<template>
<SpecialistLayout>
    <Head> <title> {{ offer.name }}</title></Head>
    <template #header>
         <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ offer.name }}
        </h1>
    </template>
   
    <Tile>
       
        <b class="text-darkPink text-xl block text-end"> {{ useOfferDurationDescription(offer) }}</b>
        <b class="text-emerald-600 text-lg block text-end">tylko {{ Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.price) }}</b>
       <section v-html="offer.description">
       </section>
       <div class="flex justify-start ms-4 mt-8">
        <a :href="route('payment.buy',[offer.id])">
        <Button @click='disabled=true' :disabled="disabled" :loading="disabled"> 
            Kupuję i Płacę
        </Button>
       </a>
        
    </div>
    
    </Tile>
   
        
</SpecialistLayout>
</template>