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
            label: "O nas",
            url: "/",
        },
        {
            label: "Zaloguj",
            url: "/login",
        },
        {
            label: "Zarejestruj",
            url: "/register",
        },
    ],
];
</script>

<template>
    <footer class="border-t-1 border-t border-gray-100 bg-white flex shadow mt-4 p-4 rounded-md justify-around">
            <ApplicationLogo class="w-16"/>
            <div v-for="itemsArray in links" >
                <Link v-for="item in itemsArray" class="block mt-2 text-blue-700"  :href="item.url">{{
                    item.label
                }}</Link>
            </div>
    
    </footer>
</template>
