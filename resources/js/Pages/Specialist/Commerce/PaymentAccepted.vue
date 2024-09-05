<script setup>
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import { Head } from "@inertiajs/vue3";
import SpecialistLayout from "@/Layouts/SpecialistLayout.vue";
</script>
<template>
    <SpecialistLayout>
        <Head> <title>Sukces</title></Head>
        <template #header>
            <h1 class="font-semibold text-xl text-emerald-600 leading-tight">
                Pomyślnie dokonano płatności
            </h1>
        </template>

        <Tile>
            <div class="flex gap-4 items-center justify-center">
                <div class="inline-block">
                    <i
                        class="pi pi-check-circle text-emerald-600 text-4xl mx-auto inline-block"
                    ></i>
                </div>
                <Title>
                    <template #h2Title>
                        Płatność zakończona sukcesem.
                    </template>
                    <template #desc>
                        Wkrótce Twoja licencja będzie widoczna.
                    </template>
                </Title>
            </div>
        </Tile>
    </SpecialistLayout>
</template>
