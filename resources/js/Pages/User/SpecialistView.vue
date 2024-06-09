<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import Tile from '@/Components/Tile.vue';
import Title from '@/Components/Title.vue';
const props = defineProps({
    specialist: {
        type: Object,
        required: true
    }
})
const title = computed(()=>props.specialist.title+' ' + props.specialist.name + ' ' + props.specialist.surname )
</script>
<template>
    <Head>
        <title>Specialista - {{ title }}</title>
    </Head>
    <AuthenticatedLayout>
        <Tile>
            <Title>
               <template #h2Title>{{ title }}</template>
               <template #desc>Zobacz profil i umów się na wizytę.</template>
            </Title>
        </Tile>
</AuthenticatedLayout>
</template>