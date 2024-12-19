<script setup>
import {Link} from "@inertiajs/vue3";
import ApplicationLogo from "./ApplicationGreenLogo.vue";

const links = [
    [{
            label: "O portalu",
            url: "/",
        }
    ,
    {
            label: "Dla pacjenta",
            url: route('about.client'),
        },
        {
            label: "Dla dietetyka",
            url: route('about.dietician'),
        },
    ],
    [
    {
            label: "Regulamin",
            url: "/",
        },
        {
            label: "Polityka prywatności",
            url: "/",
        },
        {
            label: "Dane osobowe",
            url: "/"
        }
        
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
    ]
];
</script>

<template>
    <footer class=" bg-white flex-col md:flex-row gap-2 p-8 flex shadow items-center  md:p-4  justify-around">
            <div ><ApplicationLogo class="w-16 h-16"/></div>
            <div v-for="itemsArray in links" >
                <Link v-for="item in itemsArray" class="block mt-2 text-blue-700"  :href="item.url">{{
                    item.label
                }}</Link>
            </div>
    
    </footer>
</template>
