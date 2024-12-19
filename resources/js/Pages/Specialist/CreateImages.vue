<script setup>
import Tile from "@/Components/Tile.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link } from "@inertiajs/vue3";

import Title from "@/Components/Title.vue";
import UpdateIcon from "./Profile/Partials/UpdateIcon.vue";
import UpdateImage from "./Profile/Partials/UpdateImage.vue";

const props = defineProps({
    avatarUrl: {
        type: String
    },
    iconUrl: {
        type:String
    },
})
</script>
<template>
    <Head> <title>Twój wizerunek</title></Head>
    <AuthenticatedLayout>
        <Tile>
            
            <Title class="my-8">
                <template v-slot:h2Title>Utwórz swój wizerunek</template>
                <template v-slot:desc>
                    Dodaj swoje zdjęcia
                </template>
            </Title>
            <section  class="space-y-8">
            <UpdateIcon class="max-w-xl" :image-url="iconUrl"/>
               
             
            <UpdateImage class="max-w-xl" :image-url="avatarUrl"/>
           <Link :href = "route('specialist.created.message')" class="bg-green-500 mx-auto inline-block p-2 px-4 font-bold  text-white mt-4 w-48 text-center rounded">
            Utwórz konto
            </Link>
        </section>
        </Tile>
    </AuthenticatedLayout>
</template> 
