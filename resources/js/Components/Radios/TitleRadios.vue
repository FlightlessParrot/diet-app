<script setup>
import NullableRadios from "@/Components/Radios/NullableRadios.vue"

const model=defineModel()
const props = defineProps(['error'])
const titles =[
    {
        name: 'lic.',
        value: 'lic'
    },
    {
        name: 'inż.',
        value: 'inz'
    },
    {
        name: 'mgr',
        value: 'mgr'
    },
    {
        name: 'mgr inż.',
        value: 'mgr_inż'
    },
    {
        name: 'dr',
        value: 'dr'
    },
    {
        name: 'dr hab.',
        value: 'dr_hab'
    },
    {
        name: 'prof. dr hab.',
        value: 'prof'
    },
]

</script>
<template>

        <NullableRadios :error="error" v-model="model" :data-array="titles" title="Tytuł"/>
    
</template>