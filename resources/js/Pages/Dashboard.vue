<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import Tile from "@/Components/Tile.vue"
import PrimaryButton from '@/Components/PrimaryButton.vue';
const page = usePage()
</script>

<template>
    <Head title="Tablica" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tablica</h2>
        </template>

       <Tile>
                    <div class=" text-gray-900">Jesteś zalogowany</div>
        </Tile>
               
    </AuthenticatedLayout>
</template>
