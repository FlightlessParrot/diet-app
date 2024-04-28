<script setup>
import Dropdown from "primevue/dropdown";

import {defineModel } from "vue";


const props = defineProps(['options', 'placeholder', 'required'])
const model = defineModel()
</script>
<template>
    <Dropdown
        v-model="model"
        :options="options"
        optionValue="id"
        :required="required"
        filter
        optionLabel="name"
        :placeholder="placeholder"
        
        class="w-full  md:w-14rem"
    >
       
    </Dropdown>
</template>
