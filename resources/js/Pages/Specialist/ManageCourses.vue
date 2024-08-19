<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm, router, usePage, Link} from "@inertiajs/vue3";
import { ref } from "vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import "v-calendar/style.css";
import StoreModal from '@/Parts/StoreCourseModal.vue';
import Tile from "@/Components/Tile.vue";
import Divider from "primevue/divider";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Documents from "@/Parts/Documents.vue";
const props = defineProps({
    courses: {
        type: Object,
    },
    documents: {
        type: Array
    }
});

const specialist=usePage().props.auth.specialist
const form = useForm({
    name: "",
    selectedDate: {start: null, end: null}
});

const showStoreModal = ref(false);
const showPutModal = ref(false)
const selectedCourse = ref(null);

</script>

<template>
    <AuthenticatedLayout>
    <section class="space-y-6">
        <Tile>
        <Title>
            <template v-slot:h2Title> Twoje kursy </template>
            <template v-slot:desc
                >Twoje wykształcenie i ukończone kursy.
            </template>
        </Title>
        </Tile>
        <Tile >
        <form
            :metaKeySelection="false"
            @submit.prevent="
                router.delete(route('course.destroy', [selectedCourse.id]), {
                    preserveScroll: true,
                    preserveState: false,
                })
            "
            class = 'my-4'
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
                <Column field="start_date" header="Początek"> </Column>
                <Column field="end_date" header="Koniec"> </Column>
            </DataTable>
            <div class="flex gap-2">
            <SecondaryButton @click.prevent="showPutModal=true" v-show="selectedCourse !== null"
                >
                Edytuj
                </SecondaryButton>
            <DangerButton v-show="selectedCourse !== null">Usuń</DangerButton></div>
        </form>
        <PrimaryButton @click="showStoreModal=true">Utwórz</PrimaryButton>
        <Divider />
    
        <div class="my-16">
            <h2 class="font-bold">Prześli dokumenty potwierdzające Twoje kwalifikacje.</h2>
            <i class="text-gray-500">Na przykład dyplom ukońćzenia studiów.</i>
            <Documents :documents="documents"/>
        </div>
        <div >
        
            <Divider />
      
        <Link :href = "route('specialist.address.create')" class="bg-green-500 mx-auto inline-block p-2 px-4 font-bold  text-white mt-4 w-48 text-center rounded">
            Dalej
        </Link>
    </div>
        <StoreModal v-model="showStoreModal"/>
        <StoreModal v-if="selectedCourse!==null" update v-model="showPutModal" :key="selectedCourse?.id" :course="selectedCourse"/>
        </Tile>
    </section>

</AuthenticatedLayout>
</template>
