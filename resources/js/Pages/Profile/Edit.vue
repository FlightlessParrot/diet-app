<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateAddress from "./Partials/UpdateAddress.vue"
import { Head, usePage } from '@inertiajs/vue3';
import CreateSpecialistLink from './Partials/CreateSpecialistLink.vue';
import DeleteSpecialistForm from './Partials/DeleteSpecialistForm.vue';
import { computed } from 'vue';
import Tile from '@/Components/Tile.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
const page=usePage();
const role = computed(()=>page.props.auth.role)
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    address: {
        type: Object
    },
    hasAddress:{
        type: Boolean,
        required: true
    },
    provinces: {
        type: Array,
        required: true
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
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateAddress
                    class="max-w-xl"
                    :has-address="hasAddress"
                    :address="address"
                    :provinces="provinces"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
                <div v-if="role.name==='user'" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <CreateSpecialistLink class="max-w-xl" />
                </div>
                <div v-if="role.name==='specialist'" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteSpecialistForm class="max-w-xl" />
                </div>
                
                <!-- <Tile v-if="page.props.auth.user?.specialist" >
                <form class="space-y-4" @submit.prevent="router.delete(route('specialist.remove',page.props.auth.specialist.id))">
                    <p>Usuń specjalistę</p>
                    <PrimaryButton>Usuń</PrimaryButton>
                </form>
               </Tile> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
