<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import QuestMenu from "@/Components/Menu/QuestMenu.vue";
import Foot from "@/Components/Foot.vue";
</script>
<template>
    <div class="flex justify-between p-2 md:p-4 bg-brightGreen">
        <ApplicationLogo class="w-8 h-12"></ApplicationLogo> 
        <QuestMenu />
    </div>
    <div class="bg-gray-100 md:p-6 lg:p-12">
        <div class="bg-white text-black-800 p-2 md:p-6 shadow rounded-md">
            <slot></slot>
        </div>
        <Foot />
    </div>
</template>
