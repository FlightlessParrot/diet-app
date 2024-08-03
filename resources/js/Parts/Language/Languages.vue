<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { router, usePage, Link} from "@inertiajs/vue3";
import { ref } from "vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import "v-calendar/style.css";
import StoreModal from '@/Parts/Language/StoreLanguageModal.vue';
import Tile from "@/Components/Tile.vue";
import Divider from "primevue/divider";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
const props = defineProps({
    languages: {
        type: Array,
    },
});

const specialist=usePage().props.auth.specialist


const showStoreModal = ref(false);
const showPutModal = ref(false)
const selectedLanguage = ref(null);

</script>

<template>
    
    <section >
       
        <Title>
            <template v-slot:h2Title> Twoje języki</template>
            <template v-slot:desc
                >Języki, którymi władasz.
            </template>
        </Title>

        <form
            :metaKeySelection="false"
            @submit.prevent="
                router.delete(route('language.destroy', [selectedLanguage.id]), {
                    preserveScroll: true,
                    preserveState: false,
                })
            "
            class = 'my-4'
        >
            <DataTable
                v-model:selection="selectedLanguage"
                :value="languages"
                class="my-12"
                selectionMode="single"
                :metaKeySelection="false"
                dataKey="id"
            >
                <Column field="name" header="Język"></Column>
            </DataTable>
            <div class="flex gap-2">
            <SecondaryButton @click.prevent="showPutModal=true" v-show="selectedLanguage !== null"
                >
                Edytuj
                </SecondaryButton>
            <DangerButton v-show="selectedLanguage !== null">Usuń</DangerButton></div>
        </form>
        <PrimaryButton @click="showStoreModal=true">Utwórz</PrimaryButton>
        <StoreModal v-model="showStoreModal"/>
        <StoreModal v-if="selectedLanguage!==null" update v-model="showPutModal" :key="selectedLanguage?.id" :language="selectedLanguage"/>
     
    </section>

</template>
