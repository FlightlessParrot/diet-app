<script setup>
import { computed } from 'vue';

const props = defineProps(['filled'])
const heartClass = computed(()=>props.filled ? 'pi pi-heart-fill': 'pi pi-heart' )
</script>
<template>
    <button>
       <i :class="heartClass" style="color: #B36B6B; font-size: 1.2rem;"></i>
    
    </button>
</template>