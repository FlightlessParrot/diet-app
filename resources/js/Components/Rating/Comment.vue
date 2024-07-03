<script setup>
import Rating from 'primevue/rating';
import {computed, ref} from 'vue';

const props = defineProps({
    review: {
        type: Object,
        required: true
    }
})
const grade = computed(()=>props.review.grade *1)
const time = computed(()=>{
    const time = new Date(props.review.created_at);
    return time.getDate()+'-'+time.getMonth()+'-'+time.getFullYear()+' '+time.getHours()+':'+time.getMinutes();
})

</script>
<template>
    <section class="space-y-4">
        <Rating :model-value="grade" readonly :cancel="false" />
        <p>
            {{ review.text }}
        </p>
        <i class = 'text-gray-400 text-sm'>Utworzono {{ time }}</i>
    </section>
</template>