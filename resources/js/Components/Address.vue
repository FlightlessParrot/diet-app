<script setup>
import { computed } from 'vue';

const props = defineProps(["address"]);
const parkLine= computed(()=>props.address.park ? 'Pod tym adresem można zaparkować samochód.' : "Pod tym adresem nie można zaparkować samochodu.")
</script>
<template>
    <div class="w-fit p-2 max-w-lg rounded">
        <p>{{ address.line_1 }}</p>
        <p v-if="address.line_2 !== null">{{ address.line_2 }}</p>
        <p>{{ address.province.name }}</p>
        <span>{{ address.code }}</span> <span>{{ address.city }}</span>
        <i class="block text-sm mt-2 gray-400">{{ parkLine }}</i>
    </div>
</template>
