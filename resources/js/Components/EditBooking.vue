<script setup>

import { usePage } from '@inertiajs/vue3';
import {computed} from 'vue';
const props = defineProps({
    booking: {
        type: Object,
        required: true,
    },
});

const reserved = computed(()=>{
    switch(props.booking.status)
    {
        case 'created':
            return 'Nikt jeszcze nie zarezerwował.';
        case 'pending':
            return 'Czeka na potwierdzenie.';
        case 'accepted':
            return 'Potwierdzone';
        case 'rejected':
            return 'Anulowane';
        default:
            return 'Nieznany status';
    }
})
</script>
<template>
    <div class="mx-auto max-w-7xl border-b my-6 p-4 border-green-200 space-y-4" >
        <h3 class="font-bold text-lg ">
            {{
               new Date(booking.start_date).toLocaleString("pl").slice(0,-3) +
                " - " +
                new Date(booking.end_date).toLocaleString("pl").slice(0,-3) 
            }}
        </h3>
        <p><span class="pi pi-user"></span> {{reserved}}</p>
        <slot />
        
    </div>
</template>
