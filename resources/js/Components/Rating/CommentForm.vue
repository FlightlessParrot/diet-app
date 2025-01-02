<script setup>
import Textarea from "primevue/textarea";
import Rating from "primevue/rating";
import { computed,  } from "vue";

const textModel = defineModel("text");
const gradeModel = defineModel("grade");
const gradeAtmosphereModel = defineModel("grade_atmosphere");
const gradeExplanationModel = defineModel("grade_explanation");
const gradePunctualityModel = defineModel("grade_punctuality");
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
    <div class="space-y-4">
        <div>
        <b >Ocena sumaryczna</b>
        <Rating v-model="gradeModel" :cancel="false" />
        </div>
        <div>
        <b>Atmosfera</b>
        <Rating v-model="gradeAtmosphereModel" :cancel="false" />
        </div>
        <div>
        <b>Przekazywanie informacji</b>
        <Rating v-model="gradeExplanationModel" :cancel="false" />
        </div>
        <div>
        <b>Punktualność</b>
        <Rating v-model="gradePunctualityModel" :cancel="false" />
        </div>
        <Textarea v-model="textModel" rows="10" :cols="cols" autoResize placeholder="Co myślisz?"/>
    </div>
</template>
