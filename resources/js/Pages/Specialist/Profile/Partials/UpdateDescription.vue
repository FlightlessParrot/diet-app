<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from 'primevue/textarea';
import { router, useForm, usePage } from '@inertiajs/vue3';
import Title from "@/Components/Title.vue";
import Editor from 'primevue/editor';
import {  watchEffect } from 'vue';

const props = defineProps({
    description: {
        type: Object,
        required:true
    }
})

const specialist = usePage().props.auth.specialist;
const form = useForm({
    full:''
});

watchEffect(()=>form.full=props.description.full)

</script>
<template>
    <section>
        <Title>
                <template v-slot:h2Title> O mnie</template>
                <template v-slot:desc>
                    Opisz siebie. Jakimi językami obcymi mówisz? Czy pod Twoją firmą jest miejsce parkingowe? Do jakich klientów kieruejsz swoją ofertę?
                </template>
        </Title>

        <form
            @submit.prevent="form.put(route('description.update',[specialist.id, description.id]),{ preserveScroll: true, preserveState: true})"
            class="mt-6 space-y-6"
        >
            <div>

                <!-- <Editor v-model='form.full' editorStyle="height: 320px" /> -->
                <Textarea v-model = 'form.full' class="w-full h-[320px]" />
                <InputError class="mt-2" :message="form.errors.full" />
            </div>
            

            <PrimaryButton :disabled="form.processing">Edytuj</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Zapisano zmiany.</p>
                </Transition>
            
        </form>
        <form class="mt-6 space-y-6" >
        <DangerButton @click.prevent="router.delete(route('description.destroy',description.id),{preserveScroll:true, preserveState: false})">Usuń opis</DangerButton>
        </form>
        
    </section>
</template>