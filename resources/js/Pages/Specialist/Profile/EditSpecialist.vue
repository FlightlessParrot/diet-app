<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import UpdateAddress from "./Partials/UpdateAddress.vue";
import AddAddress from "./Partials/AddAddress.vue";
import { Head, usePage } from "@inertiajs/vue3";
import CategoriesForm from "./Partials/CategoriesForm.vue";
import DeleteSpecialistForm from "./Partials/DeleteSpecialistForm.vue";
import { computed } from "vue";
import UpdateServicesForm from "./Partials/UpdateServicesForm.vue";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";

const page = usePage();
const role = computed(() => page.props.auth.role);
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
    }
});

</script>

<template>
    <Head title="Profil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm class="max-w-xl" />
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
                    <UpdateServicesForm :service-cities="serviceCities" :service-kinds="serviceKinds" :provinces="provinces"
                        class="max-w-xl"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <CategoriesForm class="max-w-xl" :all-categories="categories" :checked-categories="checkedCategories"/>
                </div>
                <div
                    v-if="role.name === 'specialist'"
                    class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                >
                    <DeleteSpecialistForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
