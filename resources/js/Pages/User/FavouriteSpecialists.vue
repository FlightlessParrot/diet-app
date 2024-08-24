<script setup>
import SpecialistCard from '@/Components/SpecialistCard.vue';
import Title from '@/Components/Title.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tile from '@/Components/Tile.vue';
import ElementsWrapper from '@/Components/ElementsWrapper.vue';
import Pager from '@/Components/Pager/Pager.vue';
import { Head } from '@inertiajs/vue3';
const props = defineProps({
    specialists: {
        type: Object,
        required: true
    }
});
</script>
<template>

    <AuthenticatedLayout>
        <Head>
        <title>Polubieni specjaliści</title>
    </Head>
    <section>
        <Tile>
        <Title>
            <template #h2Title>
                Polubieni specialiści
            </template>
            <template #desc>
                Specialiści, których polubiłeś
            </template>
        </Title>
    </Tile>
        <ElementsWrapper>
            <SpecialistCard v-for="specialist in specialists.data" :specialist="specialist" />
        </ElementsWrapper>
        <Pager v-if="specialists.links.length>3" :last-page-url="specialists.last_page_url" 
            :links="specialists.links" 
            :first-page-url="specialists.first_page_url" />
    </section>
    </AuthenticatedLayout>
</template>