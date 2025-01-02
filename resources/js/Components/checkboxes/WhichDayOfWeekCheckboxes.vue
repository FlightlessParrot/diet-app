<script setup>
import InputError from "../InputError.vue";
import Checkbox from "primevue/checkbox";
const model=defineModel();
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
  <h3 class="block font-medium text-sm text-gray-700 mb-2">Czy utworzyć wydarzenia tylko w określony dzień tygodnia?</h3>
        <div class="flex flex-wrap gap-4">

            <div class="flex gap-2" v-for="(day, i) in days">
                <Checkbox :input-id="i + '_dayOfWeek'" v-model="model" name="days" :value="day.value"/>
                <label :for="i + '_dayOfWeek'">{{ day.name }}</label>
            </div>


            <InputError class="mt-2" :message="error" />
        </div>
</template>