<script setup>
const props = defineProps(["address"]);
</script>
<template>
    <div class="w-fit p-2 max-w-lg rounded">
        <p>{{ address.line_1 }}</p>
        <p v-if="address.line_2 !== null">{{ address.line_2 }}</p>
        <p>{{ address.province.name }}</p>
        <span>{{ address.code }}</span> <span>{{ address.city }}</span>
    </div>
</template>
