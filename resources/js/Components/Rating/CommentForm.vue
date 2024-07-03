<script setup>
import Textarea from "primevue/textarea";
import FloatLabel from "primevue/floatlabel";
import Rating from "primevue/rating";
import { computed, ref } from "vue";

const textModel = defineModel("text");
const gradeModel = defineModel("grade");
const cols = computed(() => {
    if (window.innerWidth < 720) {
        return 25;
    }
    if (window.innerWidth < 1400) {
        return 60;
    } else {
        return 80;
    }
});
</script>
<template>
    <div class="space-y-2">
        <Rating v-model="gradeModel" :cancel="false" />

        <Textarea v-model="textModel" rows="10" :cols="cols" autoResize placeholder="Co myślisz?"/>
    </div>
</template>
