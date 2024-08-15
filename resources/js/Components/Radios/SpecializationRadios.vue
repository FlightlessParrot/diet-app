<script setup>
import NullableRadios from "@/Components/Radios/NullableRadios.vue"

const model=defineModel()
const props = defineProps(['error'])
const specializations =[
    {
        value: 'Dietetyk kliniczny',
        name: 'Dietetyk kliniczny'
    },
    {
        value: 'Dietetyk sportowy',
        name: 'Dietetyk sportowy'
    },
    {
        value: 'Psychodietetyk',
        name: 'Psychodietetyk'
    },
]

</script>
<template>

        <NullableRadios :error="error" v-model="model" :data-array="specializations" title="Specjalizacja"/>
    
</template>