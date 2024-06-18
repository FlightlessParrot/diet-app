<script setup>
import { useForm, Head, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';
import { ref } from 'vue'
const selectedDate = ref(null)
</script>
<template>
     <Head> <title>Utwórz profil specjalisty</title></Head>
     <AuthenticatedLayout>
        <Calendar />
        <DatePicker locale='pl' v-model.range='selectedDate' mode="dateTime" is24hr/>
     </AuthenticatedLayout>
</template>