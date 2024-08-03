<script setup>

import { Link} from "@inertiajs/vue3";
import { ref } from "vue";

import "v-calendar/style.css";
import StoreModal from '@/Parts/StoreCourseModal.vue';
import Tile from "@/Components/Tile.vue";
import Divider from "primevue/divider";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Languages from "@/Parts/Language/Languages.vue"
const props = defineProps({
    languages: {
        type: Object,
    },
});



const showStoreModal = ref(false);
const showPutModal = ref(false)
const selectedCourse = ref(null);

</script>

<template>
    <AuthenticatedLayout>
    <section class="space-y-6">
        <Tile>
        <Languages :languages = 'languages' />
        <Divider />
            
        <Link :href = "route('service.form')" class="bg-green-500 mx-auto inline-block p-2 px-4 font-bold  text-white mt-4 w-48 text-center rounded">
            Dalej
        </Link>

        </Tile>
    </section>

</AuthenticatedLayout>
</template>
