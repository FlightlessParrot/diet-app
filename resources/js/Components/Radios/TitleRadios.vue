<script setup>
import NullableRadios from "@/Components/Radios/NullableRadios.vue"

const model=defineModel()
const props = defineProps(['error'])
const titles =[
    {
        value: 'lic.',
        name: 'lic'
    },
    {
        value: 'inż.',
        name: 'inz'
    },
    {
        value: 'mgr',
        name: 'mgr'
    },
    {
        value: 'mgr inż.',
        name: 'mgr_inż'
    },
    {
        value: 'dr',
        name: 'dr'
    },
    {
        value: 'dr hab.',
        name: 'dr_hab'
    },
    {
        value: 'prof. dr hab.',
        name: 'prof'
    },
]

</script>
<template>

        <NullableRadios :error="error" v-model="model" :data-array="titles" title="Tytuł"/>
    
</template>