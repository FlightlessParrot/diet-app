<script setup>
import Tile from '@/Components/Tile.vue';
import {  Head, useForm } from '@inertiajs/vue3';
import SpecialistLayout from '@/Layouts/SpecialistLayout.vue';
import { useOfferDurationDescription } from '@/Composables/useOfferDurationDescription';
import Button from 'primevue/button';
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputText from 'primevue/inputtext';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
const props = defineProps({
    offer: {
        type: Object,
        required: true
    },
    discount: {
        type: Object,
    },
    missing: {
        type: Boolean,
        required: true
    },
    code: {
        type: String
    }
})
const disabled=ref(false)
const form = useForm({
    code: props.code
})
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
        <p v-if="offer.discount" class="block text-end text-gray-600 mt-2"><span class="no-underline">Ostatnia cena </span><span class="line-through">{{Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.old_price) }}</span></p>
        <b class="text-emerald-600 text-lg block text-end">Teraz tylko {{ Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.price) }}</b>
       
        <b v-if="discount" class="text-emerald-600 text-xl block text-end">po rabacie {{ Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.price*(100-discount.amount)/100) }}</b>
       <section v-html="offer.description">
       </section>
       <form @submit.prevent="" class="my-8 space-y-2">
        <InputLabel for="code">Kod rabatowy</InputLabel>
        <InputText :invalid="missing" @change="form.get(route('offer.show',[offer.id]),{preserveState: true})" id="code" v-model="form.code" />
        <InputError v-if="missing" message="Kod jest niepoprawny"></InputError>
        <p class="text-emerald-600" v-if="discount">Kod jest poprawny. Rabat został naliczony.</p>
        <i class="text-sm text-gray-600 block">Jeśli posiadasz kod rabatowy wprowadź go tutaj.</i>
        
       </form>
       <div class="flex justify-start ms-4 mt-8">
        <a :href="route('payment.buy',[offer.id,form.code])">
        <Button @click='disabled=true' :disabled="disabled" :loading="disabled"> 
            Kupuję i Płacę
        </Button>
       </a>
        
    </div>
    
    </Tile>
   
        
</SpecialistLayout>
</template>