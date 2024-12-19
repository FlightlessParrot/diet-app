<script setup>
import Tile from "@/Components/Tile.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link } from "@inertiajs/vue3";

import Title from "@/Components/Title.vue";
import PriceListForm from "./Profile/Partials/PriceListForm.vue";

const props = defineProps({
    prices: {
        type: Array,
        required: true
    }
})
</script>
<template>
    <Head> <title>Utwórz swój cennik</title></Head>
    <AuthenticatedLayout>
        <Tile>
            <Title>
                <template v-slot:h2Title>Utwórz swój cennik</template>
                <template v-slot:desc>
                    Dodaj ceny
                </template>
            </Title>
           <PriceListForm :prices="prices" />
           <Link :href = "route('description.create')" class="bg-green-500 mx-auto inline-block p-2 px-4 font-bold  text-white mt-4 w-48 text-center rounded">
            Dalej
        </Link>
        </Tile>
    </AuthenticatedLayout>
</template> 
