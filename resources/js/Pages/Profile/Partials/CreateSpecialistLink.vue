<script setup>
import { Link } from '@inertiajs/vue3';
import Title from '@/Components/Title.vue';
</script>
<template>
    <div>
    <section>
   
            <Title>
                <template v-slot:h2Title>
                    Utwórz profil specialisty
                </template>
                <template v-slot:desc>
                    Kliknij w poniższy przycisk, aby utworzyć profil specialisty.
                </template>
            </Title>
            
    </section>
    <Link class="text-blue-600 mt-6 pt-2 inline-block" :href="route('specialist.create')">Utwórz profil specjalisty</Link>
    </div>
</template>