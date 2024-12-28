<script setup>
import { Head,} from "@inertiajs/vue3";

import SpecialistViewTemplate from "@/Parts/SpecialistViewTemplate.vue";
import { computed } from "vue";
import GuestLayoutForPages from "@/Layouts/GuestLayoutForPages.vue";

const props = defineProps({
    specialist: {
        type: Object,
        required: true,
    },
    reviews: {
        type: Object,
    },
    courses: {
        type: Array,
    },
    languages: {
        type: Array,
    },
    socialMedias: {
        type: Array
    },
    specializations: {
        type: Array,
        required: true
    }
});
const title = computed(
    () =>
        props.specialist.title +
        " " +
        props.specialist.name +
        " " +
        props.specialist.surname
);
</script>
<template>
    <Head>
        <title>Specialista - {{ title }}</title>
    </Head>
    <GuestLayoutForPages>
     <SpecialistViewTemplate :specializations="specializations" :specialist="specialist":social-medias="socialMedias" :languages="languages" :courses="courses" 
     :reviews="reviews" :guest="true"/>
    </GuestLayoutForPages>
</template>
