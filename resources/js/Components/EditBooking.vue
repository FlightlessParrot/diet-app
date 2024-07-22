<script setup>

import { usePage } from '@inertiajs/vue3';
import {computed} from 'vue'
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';;
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
        case 'confirmed':
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
        <div v-if="booking.user" class="md:w-3/4 ml-4">
            <DataTable :value="[booking.user]" >
    <Column field="name" header="Imię"></Column>
    <Column field="surname" header="Nazwisko"></Column>
    <Column field="email" header="Adres e-mail"></Column>
        </DataTable>
        </div>
        <p><span class="pi pi-user"></span> {{reserved}}</p>
        
        <slot />
        
    </div>
</template>
