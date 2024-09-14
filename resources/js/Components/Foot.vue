<script setup>
import {Link} from "@inertiajs/vue3";
import ApplicationLogo from "./ApplicationLogo.vue";

const links = [
    [
        {
            label: "Polityka prywatności",
            url: "/",
        },
        {
            label: "Regulamin",
            url: "/",
        },
    ],
    [
        
        {
            label: "Zaloguj",
            url: "/login",
        },
        {
            label: "Zarejestruj",
            url: "/register",
        },
    ],[
    {
            label: "O nas",
            url: "/",
        },
    {
            label: "Dla pacjenta",
            url: route('about.client'),
        },
        {
            label: "Dla dietetyka",
            url: route('about.dietician'),
        },
       
    ]
];
</script>

<template>
    <footer class=" bg-white flex-col md:flex-row p-8 flex shadow  md:p-4  justify-around">
            <ApplicationLogo class="w-16"/>
            <div v-for="itemsArray in links" >
                <Link v-for="item in itemsArray" class="block mt-2 text-blue-700"  :href="item.url">{{
                    item.label
                }}</Link>
            </div>
    
    </footer>
</template>
