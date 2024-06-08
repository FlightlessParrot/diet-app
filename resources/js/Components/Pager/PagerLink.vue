<script setup>
import { computed } from 'vue';

const props = defineProps({
    href: {
        type: String,
    },
    active: {
        type: Boolean
    },
    label: {
        type: String,
        required: true
    }


})

const activeClass=computed(()=> props.active ?
                    "p-2 px-4 rounded-md bg-darkGreen border  text-white":
                    "p-2 px-4 rounded-md bg-white border border-darkGreen text-darkGreen");
</script>

<template>
    <a  :href="props.href" :class="activeClass" v-html="label">
        
    </a>
</template>