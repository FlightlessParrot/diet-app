<script setup>
import { onMounted, ref } from 'vue';
import InputText from 'primevue/inputtext';
const model = defineModel({
    type: String,
    required: true,
});


</script>

<template>
    <InputText
        v-model="model"
     
    />
</template>
