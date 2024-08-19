<script setup>

import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import UpdateAddress from "./Partials/UpdateAddress.vue";
import AddAddress from "./Partials/AddAddress.vue";
import { Head, usePage } from "@inertiajs/vue3";
import CategoriesForm from "./Partials/CategoriesForm.vue";
import DeleteSpecialistForm from "./Partials/DeleteSpecialistForm.vue";
import UpdateServicesForm from "./Partials/UpdateServicesForm.vue";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import PriceListForm from "./Partials/PriceListForm.vue";
import UpdateImage from "./Partials/UpdateImage.vue";
import UpdateIcon from "./Partials/UpdateIcon.vue";
import StoreDescription from "./Partials/StoreDescription.vue";
import UpdateDescription from "./Partials/UpdateDescription.vue";
import Courses from "./Partials/Courses.vue";
import EditPhone from "@/Parts/EditPhone.vue";
import Languages from "@/Parts/Language/Languages.vue";
import SpecialistLayout from "@/Layouts/SpecialistLayout.vue";
import Documents from "@/Parts/Documents.vue";
const page = usePage();
defineProps({
    addresses: {
        type: Array,
    },
    provinces: {
        type: Array,
        required: true,
    },
    serviceCities: {
        type: Array,
    },
    serviceKinds: {
        type: Array,
    },
    categories: {
        type: Array,
        required: true
    },
    checkedCategories: {
        type:Array
    },
    prices: {
        type: Array,
        required: true
    },
    avatarUrl: {
        type: String
    },
    iconUrl: {
        type:String
    },
    description: {
        type: Object
    },
    courses: {
        type: Array,
    },
    languages: {
        type: Array
    },
    targets: {
        type: Array,
        required: true
    },
    specialistTargetIds: {
        type: Array,
        required: true
    },
    documents: {
        type: Array,
        required: true
    }
});

</script>

<template>
    <Head title="Profil" />

    <SpecialistLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm :specialistTargetIds="specialistTargetIds" :targets="targets" class="max-w-xl" />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <EditPhone :phone='page.props.auth.specialist.phone' class="max-w-xl" />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateIcon class="max-w-xl" :image-url="iconUrl"/>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateImage class="max-w-xl" :image-url="avatarUrl"/>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <TabView>
                        <TabPanel
                            v-for="(address, index) in addresses"
                            :header="index + 1"
                        >
                            <UpdateAddress
                                class="max-w-xl"
                                :address="address"
                                :provinces="provinces"
                            />
                        </TabPanel>
                        <TabPanel header="+">
                            <AddAddress
                                class="max-w-xl"
                                :provinces="provinces"
                            />
                        </TabPanel>
                    </TabView>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <Languages :languages="languages" />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg space-y-12">
                    <Courses :courses = 'courses' />
                    <div>
                        <div class="my-8">
                        <h3 class="font-bold">Dokumenty potwierdzające Twoje kwalifikacje.</h3>
                        <i class="text-gray-500">Dyplomy ukończenia studiów i inne świadectwa.</i>
                        </div>
                    <Documents :documents="documents" />
                </div>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateServicesForm :service-cities="serviceCities" :service-kinds="serviceKinds" :provinces="provinces"
                        class="max-w-xl"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <PriceListForm class="max-w-xl" :prices="prices"  />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <CategoriesForm class="max-w-xl" :all-categories="categories" :checked-categories="checkedCategories"/>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateDescription v-if="description" :description='description' class="max-w-xl"/>
                    <StoreDescription v-else  class="max-w-xl"/>
                </div>
                <div
                    
                    class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                >
                    <DeleteSpecialistForm class="max-w-xl" />
                </div>
                
            </div>
        </div>
    </SpecialistLayout>
</template>
