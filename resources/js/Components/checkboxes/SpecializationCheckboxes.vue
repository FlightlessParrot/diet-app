<script setup>

import InputError from "../InputError.vue";
import Checkbox from "primevue/checkbox";

const model = defineModel()
const props = defineProps(['error'])
const specializations = [
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

    <div>
        <h3 class="block font-medium text-sm text-gray-700 mb-2">Specjalizacja</h3>
        <div class="flex flex-wrap gap-4">

            <div class="flex gap-2" v-for="(specialization, i) in specializations">
                <Checkbox :input-id="i + '_specialization'" v-model="model" name="specializations" :value="specialization.value"/>
                <label :for="i + '_specialization'">{{ specialization.name }}</label>
            </div>


            <InputError class="mt-2" :message="error" />
        </div>
    </div>

</template>