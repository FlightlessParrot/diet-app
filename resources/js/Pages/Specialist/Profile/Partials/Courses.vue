<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm, router, usePage} from "@inertiajs/vue3";
import { ref } from "vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import "v-calendar/style.css";
import StoreModal from '@/Parts/StoreCourseModal.vue'

const props = defineProps({
    courses: {
        type: Object,
    },
});

const showStoreModal = ref(false);
const showPutModal = ref(false)
const selectedCourse = ref(null);


</script>

<template>
    <section class="space-y-6">
        <Title>
            <template v-slot:h2Title> Twoje kursy </template>
            <template v-slot:desc
                >Twoje wykształcenie i ukończone kursy.
            </template>
        </Title>

        <form
            :metaKeySelection="false"
            @submit.prevent="
                router.delete(route('course.destroy', [selectedCourse.id]), {
                    preserveScroll: true,
                    preserveState: false,
                })
            "
        >
            <DataTable
                v-model:selection="selectedCourse"
                :value="courses"
                class="my-12"
                selectionMode="single"
                :metaKeySelection="false"
                dataKey="id"
            >
                <Column field="name" header="Kurs"></Column>
                <!-- <Column field="start_date" header="Początek"> </Column> -->
                <Column field="end_date" header="Ukończenie"> </Column>
            </DataTable>
            <div class="flex gap-2">
            <SecondaryButton @click.prevent="showPutModal=true" v-show="selectedCourse !== null"
                >
                Edytuj
            </SecondaryButton>
            <DangerButton v-show="selectedCourse !== null">Usuń</DangerButton></div>
        </form>
        <PrimaryButton @click="showStoreModal=true">Utwórz</PrimaryButton>
        
        <StoreModal v-model="showStoreModal"/>
        <StoreModal v-if="selectedCourse!==null" update v-model="showPutModal" :key="selectedCourse?.id" :course="selectedCourse"/>
       
    </section>
</template>
