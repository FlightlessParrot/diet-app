<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head,} from "@inertiajs/vue3";

import SpecialistViewTemplate from "@/Parts/SpecialistViewTemplate.vue";
import { computed } from "vue";

const props = defineProps({
    specialist: {
        type: Object,
        required: true,
    },
    reviews: {
        type: Object,
    },
    myReview: {
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
    }
});
const title = computed(
    () =>props.specialist.specialization +
        " " +
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
    <AuthenticatedLayout>
     <SpecialistViewTemplate 
     :specialist="specialist" :social-medias="socialMedias" 
     :languages="languages" :courses="courses" :my-review="myReview"
     :reviews="reviews"/>
    </AuthenticatedLayout>
</template>
