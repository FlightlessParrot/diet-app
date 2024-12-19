<script setup>
import Tile from "@/Components/Tile.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link } from "@inertiajs/vue3";

import Title from "@/Components/Title.vue";
import StoreDescription from "./Profile/Partials/StoreDescription.vue";
import UpdateDescription from "./Profile/Partials/UpdateDescription.vue";

const props = defineProps({
    description: {
        type: Object
    },
})
</script>
<template>
    <Head> <title>Utwórz swój opis</title></Head>
    <AuthenticatedLayout>
        <Tile>
            <Title>
                <template v-slot:h2Title>Utwórz swój opis</template>
                <template v-slot:desc>
                    Opis zawiera pozostałe informacje dla Twojego klienta
                </template>
            </Title>
            <UpdateDescription v-if="description" :description='description' class="max-w-xl"/>
            <StoreDescription v-else  class="max-w-xl"/>
           <Link :href = "route('socialMedia.create')" class="bg-green-500 mx-auto inline-block p-2 px-4 font-bold  text-white mt-4 w-48 text-center rounded">
            Dalej
        </Link>
        </Tile>
    </AuthenticatedLayout>
</template> 
