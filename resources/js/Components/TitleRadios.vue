<script setup>
import RadioButton from "primevue/radiobutton";
import InputError from "@/Components/InputError.vue";
import { computed } from "vue";
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
const isModelNull = computed(()=>model.value===null)
</script>
<template>
    <div>
                <h3 class="block font-medium text-sm text-gray-700 mb-2">Tytuł</h3>
                <div class="flex flex-wrap gap-4">
                    
                    <div class="flex gap-2" >
                    <RadioButton
                        :modelValue="isModelNull"
                        inputId="nullInput"
                        :value="true"
                        @click.prevent ='model=null'
                    />
                    <label for="nullInput">Brak</label>
                </div>
                <div class="flex gap-2" v-for="title in titles">
                    <RadioButton
                        v-model="model"
                        :inputId="title.name"
                        :value="title.value"
                    />
                    <label :for="title.name" >{{ title.value }}</label>
                </div>
                </div>
                <!-- <button v-if='model!==null' @click.prevent="model=null" class="rounded border text-sm  border-gray-200 mt-2 p-2">Wyczyść</button> -->
                <InputError class= "mt-2" :message="error" />
            </div>
</template>