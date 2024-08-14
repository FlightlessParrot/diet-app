<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import TitleRadios from "@/Components/Radios/TitleRadios.vue";
import TargetCheckboxes from "@/Components/TargetCheckboxes.vue";
import SpecializationRadios from '@/Components/Radios/SpecializationRadios.vue';
const user = usePage().props.auth.user;
const props = defineProps([ 'targets'])
const form = useForm({
    title: null,
    specialization: null,
    name: user.name,
    surname: user.surname,
    number: user.phone.number,
    targets: []
});
</script>
<template>
    <Head> <title>Utwórz profil specjalisty</title></Head>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil specjalisty
            </h2>
        </template>
        <Tile>
            <Title>
                <template v-slot:h2Title> Utwórz profil specjalisty </template>
                <template v-slot:desc>
                    Wypełnij formularz, aby wwysłać prośbę o utworzenie profilu
                    specjalisty. Po jego zaakceptowaniu możesz zacząć świadczyć
                    usługi za pośrednictwem naszego serwisu.
                </template>
            </Title>
            <form @submit.prevent="form.post(route('specialist.store'))" class="mt-6 space-y-6">
                <SpecializationRadios v-model="form.specialization" :error="form.errors.specialization"/>
                <TitleRadios :error="form.errors.title" v-model="form.title" />
                <div>
                    <InputLabel for="name" value="Imię" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="surname" value="Nazwisko" />

                    <TextInput
                        id="surname"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.surname"
                        required
                        autofocus
                        autocomplete="surname"
                    />

                    <InputError class="mt-2" :message="form.errors.surname" />
                </div>
                <div class="mt-4">
                <InputLabel for="number" value="Numer telefonu" />

                <TextInput
                    id="number"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.number"
                    required
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.number" />
            </div>
            <TargetCheckboxes :specialistTargetIds="[]" :error =  'form.targets.error'  :targets="targets" v-model="form.targets" />
                <PrimaryButton> Dalej </PrimaryButton>
            </form>
        </Tile>
    </AuthenticatedLayout>
</template>
