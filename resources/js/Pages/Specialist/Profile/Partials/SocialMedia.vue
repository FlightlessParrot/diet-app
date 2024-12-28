<script setup>
import Dropdown from 'primevue/dropdown';
import EditSocialMediaLink from "@/Components/EditSocialMediaLink.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Title from "@/Components/Title.vue";
import { useForm } from "@inertiajs/vue3";


const props = defineProps({
    types: {
        type: Array,
        required: true
    },
    socialMedias: {
        type: Array,
        required: true
    }
});
const form = useForm({
    url: "",
    type: null,
});
</script>
<template>
    <section>
        <Title>
            <template #h2Title> Social media </template>
            <template #desc> Zarządzaj linkami do social mediów. </template>
        </Title>
        <form @submit.prevent="form.post(route('socialMedia.store'))">
            
            <div class="space-y-4 my-4">
                <i class="pi pi-instagram"/>

                <div>
                    <InputLabel for="url" value="Link do profilu" />

                    <TextInput
                        id="url"
                        type="url"
                        class="mt-1 max-w-xl block w-full"
                        v-model="form.url"
                    />

                    <InputError class="mt-2" :message="form.errors.url" />
                </div>
                <div>
                    <InputLabel for="type" value="Jaki to serwis?" />

                    <Dropdown
                    inputId="type"
                       v-model="form.type" :options="types" placeholder="serwis"
                    />

                    <InputError class="mt-2" :message="form.errors.type" />
                </div>
                <PrimaryButton>Dodaj</PrimaryButton>
            </div>
        </form>
        <div class="flex flex-col">
            <EditSocialMediaLink v-for="socialMedia in socialMedias" :types="types" :socialMedia="socialMedia" />
        </div>
    </section>
</template>
