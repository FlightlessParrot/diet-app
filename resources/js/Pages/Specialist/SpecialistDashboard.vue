<script setup>
import SpecialistLayout from '@/Layouts/SpecialistLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import Tile from "@/Components/Tile.vue"
import PrimaryButton from '@/Components/PrimaryButton.vue';
const page = usePage()
</script>

<template>
    <Head title="Tablica" />

    <SpecialistLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tablica specjalisty</h2>
        </template>

       <Tile>
                    <div class=" text-gray-900">Jesteś zalogowany jako specjalista</div>
        </Tile>
               <Tile v-if="page.props.auth.user?.specialist">
                <form class="space-y-4" @submit.prevent="router.delete(route('specialist.remove',page.props.auth.specialist.id))">
                    <p>Usuń specjalistę</p>
                    <PrimaryButton>Usuń</PrimaryButton>
                </form>
               </Tile>
            </SpecialistLayout>
</template>
