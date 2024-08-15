<script setup>
import { Head,  } from "@inertiajs/vue3";
import "v-calendar/style.css";
import SpecialistLayout from "@/Layouts/SpecialistLayout.vue";
import Title from "@/Components/Title.vue";
import CreateBookings from "./Partials/CreateBookings.vue";
import YourBookings from "./Partials/YourBookings.vue";
import PendingBookings from "./Partials/PendingBookings.vue";
const props = defineProps({
    bookings: {
        type: Array,
    },
    provinces: {
        type: Array,
        required: true,
    },
    addresses: {
        type: Array,
    },
});

</script>
<template>
    <Head> <title>Twoja dyspozycyjność</title></Head>
    <SpecialistLayout>
        <CreateBookings :provinces="provinces" :addresses="addresses" />
        <YourBookings :bookings="bookings" />
        <PendingBookings :bookings="bookings" />
        
    </SpecialistLayout>
</template>
