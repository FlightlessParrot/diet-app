<script setup>


import {computed} from 'vue'
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';;
import Address from './Address.vue';
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
        <div v-if="booking.address!==null">
            <h4 class="text-lg font-bold">Spotkanie pod adresem</h4>
            <Address :address="booking.address" />
        </div>
        <div v-else>
            <h4 class="text-lg font-bold">Spotkanie online lub z dojazdem</h4>
            <p v-if="booking.user">Skontaktuj się z klientem, aby ustalić dogodną formę spotkania.</p>
        </div>
        <div v-if="booking.user" class="md:w-3/4 ">
            <DataTable :value="[booking.user]" >
    <Column field="name" header="Imię"></Column>
    <Column field="surname" header="Nazwisko"></Column>
    <Column field="email" header="Adres e-mail"></Column>
    <Column field="phone.number" header="Telefon"></Column>
        </DataTable>
        </div>
        <div v-if="booking.anonym" class="md:w-3/4 ">
            <DataTable :value="[booking.anonym]" >
    <Column field="full_name" header="Mów mi"></Column>
    <Column field="email" header="Adres e-mail"></Column>
    <Column field="phone.number" header="Telefon"></Column>
        </DataTable>
        </div>
        <p><span class="pi pi-user"></span> {{reserved}}</p>
        
        <slot />
        
    </div>
</template>
