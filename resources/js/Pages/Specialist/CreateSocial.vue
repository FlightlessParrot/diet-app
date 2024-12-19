<script setup>
import Tile from "@/Components/Tile.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link } from "@inertiajs/vue3";

import Title from "@/Components/Title.vue";
import SocialMedia from "./Profile/Partials/SocialMedia.vue";

const props = defineProps({
    socialMediaTypes: {
        type: Array,
        required: true
    },
    socialMedias: {
        type: Array,
        required: true
    }
})
</script>
<template>
    <Head> <title>Social media</title></Head>
    <AuthenticatedLayout>
        <Tile>
            <Title>
                <template v-slot:h2Title>Podaj swoje social media</template>
                <template v-slot:desc>
                    Dzięki podanym linkom Twoi klienci będą mogli Cię znaleźć.
                </template>
            </Title>
            <SocialMedia :types="socialMediaTypes" :social-medias="socialMedias"  />
           <Link :href = "route('images.create')" class="bg-green-500 mx-auto inline-block p-2 px-4 font-bold  text-white mt-4 w-48 text-center rounded">
            Dalej
        </Link>
        </Tile>
    </AuthenticatedLayout>
</template> 
