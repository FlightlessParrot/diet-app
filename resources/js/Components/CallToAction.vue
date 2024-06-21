<script setup>
    const props=defineProps({
        href:{
            type: String,
            required: true
        },
       
    })
</script>
<template>
    <a :href="href" class="bg-pink p-4 rounded text-white text-bold text-xl">
        <slot />
    </a>
</template>