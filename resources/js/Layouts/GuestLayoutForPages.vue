<script setup>
import ApplicationWhiteLogo from "@/Components/ApplicationWhiteLogo.vue";
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
    <div class=" bg-brightGreen p-2 md:p-4">
      <div class="max-w-6xl mx-auto flex items-center justify-between md:justify-start  "><ApplicationWhiteLogo class="w-10 h-10" /> 
        <QuestMenu class="md:hidden"/>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 md:flex">
                                <NavLink v-for="item in items" :href="item.href" :active="item.active">
                                    {{ item.label }}
                                </NavLink>
                               
                            </div></div>  
    </div>
    
    <div class="bg-gray-100 md:p-6 lg:p-12">
        <Messager />
        <div class="text-black-800 ">
            <slot></slot>
        </div>
        
    </div>
    <Foot />
</template>
