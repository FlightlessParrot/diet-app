<script setup>
import { computed } from 'vue';
import Checkbox from 'primevue/checkbox';


const props = defineProps({
    value: {
        default: null,
    },
});
const model = defineModel('checked')

</script>

<template>
    <Checkbox
        :value="value"
        :binary="true"
        v-model="model"
        
    />
</template>
