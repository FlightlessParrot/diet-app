<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import QuestMenu from "@/Components/Menu/QuestMenu.vue";
import Foot from "@/Components/Foot.vue";
import NavLink from "@/Components/NavLink.vue";
import { router } from "@inertiajs/vue3";
import Messager from "@/Components/Messager.vue";
const items = [
            {
                label: 'O nas',
                icon: 'pi pi-home',
                href: route('home'),
                active: route().current('home')
            },
            {
                label: 'Specjaliści',
                icon: 'pi pi-heart-fill',
                href: route('guest.specialist.index'),
                active: route().current('guest.specialist.index')
            },
            {
                label: 'Zaloguj',
                icon: 'pi pi-user',
                href: '/login'
            },
            {
                label: 'Zarejestruj',
                icon: 'pi pi-user-plus',
                href: '/register'
            },
        ]
</script>
<template>
    <div class="flex items-center justify-between sm:justify-start  p-2 md:p-4 bg-brightGreen">
        <ApplicationLogo class="w-8 h-12"></ApplicationLogo> 
        <QuestMenu class="sm:hidden"/>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink v-for="item in items" :href="item.href" :active="item.active">
                                    {{ item.label }}
                                </NavLink>
                               
                            </div>
    </div>
    
    <div class="bg-gray-100 md:p-6 lg:p-12">
        <Messager />
        <div class="text-black-800 ">
            <slot></slot>
        </div>
        
    </div>
    <Foot />
</template>
