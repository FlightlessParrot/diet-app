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
const gradeStmosphere=computed(()=>props.review.grade *1)
const time = computed(()=>{
    const time = new Date(props.review.created_at);
    return time.getDate()+'-'+time.getMonth()+'-'+time.getFullYear()+' '+time.getHours()+':'+time.getMinutes();
})

</script>
<template>
    <section class="space-y-4">
        <div>
            <b>Ocena ogólna</b>
        <Rating :model-value="review.grade *1" readonly :cancel="false" />
        </div>
        <div>
            <b>Atmosfera</b>
        <Rating :model-value="review.grade_atmosphere * 1" readonly :cancel="false" />
        </div>
        <div>
            <b>Przekazywanie informacji</b>
        <Rating :model-value="review.grade_explanation * 1" readonly :cancel="false" />
        </div>
        <div>
            <b>Punktualność</b>
        <Rating :model-value="review.grade_punctuality * 1" readonly :cancel="false" />
        </div>
        <p>
            {{ review.text }}
        </p>
        <i class = 'text-gray-400 text-sm'>Utworzono {{ time }}</i>
    </section>
</template>