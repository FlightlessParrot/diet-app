<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateAddress from "./Partials/UpdateAddress.vue"
import { Head, usePage } from '@inertiajs/vue3';
import CategoriesForm from './Partials/CategoriesForm.cue'
import DeleteSpecialistForm from './Partials/DeleteSpecialistForm.vue';
import { computed } from 'vue';
import UpdateServicesForm from './Partials/UpdateServicesForm.vue';

const page=usePage();
const role = computed(()=>page.props.auth.role)
defineProps({
    addresses: {
        type: Array
    },
    hasAddress:{
        type: Boolean,
        required: true
    },
    provinces: {
        type: Array,
        required: true
    },
    serviceCities: {
        type: Array
    },
    serviceKinds: {
        type: Array
    }
});
</script>

<template>
    <Head title="Profil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        class="max-w-xl"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateAddress
                    class="max-w-xl"
                    :has-address="hasAddress"
                    :address="addresses[0]"
                    :provinces="provinces"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateServicesForm :provinces="provinces" :service-cities="serviceCities" 
                    :service-kinds="serviceKinds" class="max-w-xl" />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <CategoriesForm class="max-w-xl" />
                </div>
                <div v-if="role.name==='specialist'" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteSpecialistForm class="max-w-xl" />
                </div>
                
               
            </div>
        </div>
    </AuthenticatedLayout>
</template>
