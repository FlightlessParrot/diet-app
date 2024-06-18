<script setup>
import { useForm, Head, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

const selectedDate = ref(null)
</script>
<template>
     <Head> <title>Utwórz profil specjalisty</title></Head>
     <AuthenticatedLayout>
        <VCalendar />
        <VDatePicker v-model='selectedDate' />
     </AuthenticatedLayout>
</template>