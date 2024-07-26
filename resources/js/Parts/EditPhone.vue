<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({phone :{
    type: Object,
    required: true
}})
const form = useForm({
    number: props.phone.number
});

const updateNumber = () => {
    form.put(route('phone.update',props.phone.id));
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Aktualizuj numer telefonu.</h2>
        </header>

        <form @submit.prevent="updateNumber" class="mt-6 space-y-6">
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

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Zapisz</PrimaryButton>

          
            </div>
        </form>
    </section>
</template>
