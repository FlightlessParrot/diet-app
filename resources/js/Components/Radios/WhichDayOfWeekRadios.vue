<script setup>
import NullableRadios from "@/Components/Radios/NullableRadios.vue"

const model=defineModel()
const props = defineProps(['error'])
const days =[
    {
        value: 1,
        name: 'Poniedziałek'
    },
    {
        value: 2,
        name: 'Wtorek'
    },
    {
        value: 3,
        name: 'Środa'
    },
    {
        value: 4,
        name: 'Czwartek'
    },{
        value: 5,
        name: 'Piątek'
    },{
        value: 6,
        name: 'Sobota'
    },{
        value: 7,
        name: 'Niedziela'
    },
]

</script>
<template>

        <NullableRadios :error="error" v-model="model" :data-array="days" title="Czy utworzyć wydarzenia tylko w określony dzień tygodnia?"/>
    
</template>