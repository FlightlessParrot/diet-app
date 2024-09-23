<script setup>
import { useForm } from "@inertiajs/vue3";

import Title from "@/Components/Title.vue";
import Tile from "@/Components/Tile.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";
import Checkbox from "primevue/checkbox";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SpecialistCard from '@/Components/SpecialistCard.vue';
import Pager from '@/Components/Pager/Pager.vue';
import ElementsWrapper from '@/Components/ElementsWrapper.vue';
import { useTranslateServicesLabel } from "@/Composables/useTranslateServicesLabel";;
import { computed } from "vue";
const form = useForm({
    searchTerm: "",
    categories: [],
    services: [],
});

const props = defineProps({
    categories: {
        type: Array,
    },
    services: {
        type: Array,
    },
    paginatedSpecialists: {
        type: Object
    },
    guest: {
        type: Boolean,
        default: false
    }
});

const chosenRoute = computed(()=> props.guest ? route('guest.specialist.index'):route('specialist.index'));
</script>
<template>
  
        <section>
            <Tile>
                <Title>
                    <template v-slot:h2Title>Znajdź specjalistów </template>
                    <template v-slot:desc>
                        Wyszukaj najlepszych ekspertów i umów się na wizytę.
                    </template>
                </Title>
            </Tile>
            <Tile>
                <form @submit.prevent="form.get(chosenRoute,{preserveState:true})" class="py-2 space-y-6">
                    <FloatLabel>
                        <InputText
                            id="username"
                            v-model="form.searchTerm"
                            class="w-full"
                        />
                        <label for="username">Wyszukaj Specjalistę</label>
                    </FloatLabel>
                    <div>
                        <InputLabel class="mb-2">Kategorie</InputLabel>
                        <div class="flex flex-wrap  gap-4">
                            <div v-for="category in categories" class="items-center flex">
                                <Checkbox
                                    v-model="form.categories"
                                    :inputId="'kategoria-' + category.id"
                                    :value="category.id"
                                />
                                <label
                                    :for="'kategoria-' + category.id"
                                    class="ml-2"
                                >
                                    {{ category.name }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <InputLabel class="mb-2">Typ usług</InputLabel>
                        <div class="flex flex-wrap items-center gap-4">
                            <div v-for="service in services">
                                <Checkbox
                                    v-model="form.services"
                                    :inputId="'usluga-' + service.id"
                                    :value="service.id"
                                />
                                <label
                                    :for="'usluga-' + service.id"
                                    class="ml-2"
                                >
                                    {{ useTranslateServicesLabel(service.name) }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <PrimaryButton>Wyszukaj</PrimaryButton>
                </form>
            </Tile>
           
            <ElementsWrapper>
                <SpecialistCard :guest="guest" class="h-full" v-for="specialist in paginatedSpecialists.data" :specialist="specialist" />
            </ElementsWrapper>
        
            <Pager v-if="paginatedSpecialists.links.length>3" :last-page-url="paginatedSpecialists.last_page_url" 
            :links="paginatedSpecialists.links" 
            :first-page-url="paginatedSpecialists.first_page_url" />
        </section>

</template>
