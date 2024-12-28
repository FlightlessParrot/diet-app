<script setup>
import Dropdown from 'primevue/dropdown';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import { useSocialMediaIcons } from '@/Composables/useSocialMediaIcons';
import DangerButton from "./DangerButton.vue";
import { computed } from 'vue';
const props = defineProps({
    types: {
        type: Array,
        required: true
    },
    socialMedia: {
        type: Object,
        required: true
    }
});
const form = useForm({
    url: props.socialMedia.url,
    type: props.socialMedia.type,
});
const icon = computed(
    ()=>useSocialMediaIcons(form)
)

</script>
<template>
   
        <form @submit="form.put(route('socialMedia.update',socialMedia.id))">
            <div class="space-y-4 m-4 sm:m-8 border-y border-gray-300 py-4">
                <a rel="nofollow" :href="form.url" class=" flex gap-2 items-center"><i :class="'pi pi-'+icon+' text-darkGreen text-2xl'"></i><span class = 'text-blue-500 underline'>{{ form.type }}</span></a>
                <div>
                    <InputLabel for="url" value="Link do profilu" />

                    <TextInput
                        id="url"
                        type="url"
                        class="mt-1 block w-full"
                        v-model="form.url"
                    />

                    <InputError class="mt-2" :message="form.errors.url" />
                </div>
                <div>
                    <InputLabel for="type" value="Jaki to serwis?" />

                    <Dropdown
                    inputId="type"
                       v-model="form.type" :options="types"  placeholder="serwis"
                    />

                    <InputError class="mt-2" :message="form.errors.type" />
                </div>
                <div class="flex gap-6 flex-wrap">
                <PrimaryButton>Update</PrimaryButton>
                <DangerButton @click.prevent="router.delete(route('socialMedia.destroy', socialMedia.id))">Usuń</DangerButton>
                </div>
            </div>
        </form>
   
</template>
