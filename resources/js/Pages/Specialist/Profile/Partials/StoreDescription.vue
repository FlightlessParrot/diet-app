<script setup>

import InputError from '@/Components/InputError.vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm, usePage } from '@inertiajs/vue3';
import Title from "@/Components/Title.vue";
import Editor from 'primevue/editor';

const specialist = usePage().props.auth.specialist;

const form = useForm({
    full: ''
});
</script>
<template>
    <section>
        <Title>
                <template v-slot:h2Title> O mnie</template>
                <template v-slot:desc>
                    Opisz siebie. Jakimi językami obcymi mówisz? Czy pod Twoją firmą jest miejsce parkingowe? Do jakich klientóœ kieruejsz swoją ofertę?
                </template>
        </Title>

        <form
            @submit.prevent="form.post(route('description.store',[specialist.id]),{ preserveScroll: true,})"
            class="mt-6 space-y-6"
        >
            <div>

                <Editor v-model="form.full" editorStyle="height: 320px" />

                <InputError class="mt-2" :message="form.errors.full" />
            </div>
            

            <PrimaryButton :disabled="form.processing">Zapisz</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Zapisano zmiany.</p>
                </Transition>
            
        </form>
        
    </section>
</template>