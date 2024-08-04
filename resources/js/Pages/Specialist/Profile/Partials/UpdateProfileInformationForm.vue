<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import TitleRadios from "@/Components/TitleRadios.vue"
import TargetCheckboxes from "@/Components/TargetCheckboxes.vue";

const specialist = usePage().props.auth.specialist;
const props = defineProps({
    targets: {
        type : Array,
        required: true
    },
    specialistTargetIds:{
        type: Array
    }
})
const form = useForm({
    name: specialist.name,
    title: specialist.title,
    surname: specialist.surname,
    targets: props.specialistTargetIds
});


</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informacje o profilu
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Aktualizuj dane Twojego profilu.
            </p>
        </header>
        <form
            @submit.prevent="
                form.put(route('specialist.profile.update', specialist.id))
            "
            class="mt-6 space-y-6"
        >
            <TitleRadios v-model="form.title" :error="form.errors.title"/>
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
            <TargetCheckboxes :error = 'form.targets.error' :targets="targets" v-model="form.targets" />
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing"
                    >Zapisz</PrimaryButton
                >

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Zapisano zmiany.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
