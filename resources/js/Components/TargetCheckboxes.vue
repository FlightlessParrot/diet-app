<script setup>

import Checkbox from 'primevue/checkbox';
import InputError from "@/Components/InputError.vue";
import { computed } from "vue";
const model=defineModel()
const props = defineProps({
    error: {
        type: String
    },
    targets: {
        type: Array
    }
})

</script>
<template>
    <div>
                <h3 class="block font-medium text-sm text-gray-700 mb-2">Grupa docelowa</h3>
                <div class="flex flex-wrap gap-4">
                <div class="flex gap-2" v-for="target in targets">
                    <Checkbox
                        v-model="model"
                        :inputId="target.name"
                        :value="target.id"
                        name = 'target'
                    />
                    <label :for="target.name" >{{ target.name }}</label>
                </div>
                </div>
              
                <InputError class= "mt-2" :message="error" />
            </div>
</template>