<script setup>
import BaseMenu from "@/Components/Menu/BaseMenu.vue"
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
const items = ref([
    {
        label: 'Menu',
        items: [
            {
                label: 'O nas',
                icon: 'pi pi-home',
                command: () => router.get('/')
            },
            {
                label: 'Specjaliści',
                icon: 'pi pi-heart-fill',
                command: () => router.get(route('guest.specialist.index'))
            },
            {
                label: 'Dla pacjenta',
                icon: 'pi pi-tablet',
                href: route('about.client'),
                active: route().current('about.client')
            },
            {
                label: 'Dla dietetyka',
                icon: 'pi pi-tablet',
                href: route('about.dietician'),
                active: route().current('about.dietician')
            },
            {
                label: 'Zaloguj',
                icon: 'pi pi-user',
                command: () => router.get('/login')
            },
            {
                label: 'Zarejestruj',
                icon: 'pi pi-user-plus',
                command: () => router.get('/register')
            },
        ]
    }
]);


</script>
<template>
    <BaseMenu :items='items' />
</template>