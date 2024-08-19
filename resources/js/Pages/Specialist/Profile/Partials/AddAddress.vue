<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PrimeDropdown from '@/Components/PrimeDropdown.vue';
import ParkRadios from '@/Components/Radios/ParkRadios.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';

const props=defineProps({
    address: {
        type: Object,
    },
    provinces:{
        type: Array,
        required: true , 
    }
});
const specialist = usePage().props.auth.specialist;

const form = useForm({
    province_id:  '',
    city:  '',
    code:  '',
    line_1:  '',
    line_2: '',
    park: false
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Adres</h2>

            <p class="mt-1 text-sm text-gray-600">
                 Utwórz swoje dane adresowe.
            </p>
        </header>

        <form
            @submit.prevent=" form.post(route('specialist.address.store.new',specialist.id),{ preserveScroll: true,})" 
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="line_1" value="Adres - pierwsza linia" />

                <TextInput
                    id="line_1"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.line_1"
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.line_1" />
            </div>
            <div>
                <InputLabel for="line_2" value="Adres - druga linia" />

                <TextInput
                    id="line_2"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.line_2"
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.line_2" />
            </div>
            <div>
                <InputLabel for="provinces_id" value="Województwo" />

                <PrimeDropdown inputId="provinces_id" v-model="form.province_id" required placeholder="Wybierz województwo" :options="provinces"/>
                <InputError class="mt-2" :message="form.errors.province" />
            </div>
            <div class="grid grid-cols-2 gap-4">
            <div>
                <InputLabel for="city" value="Miasto" />

                <TextInput
                    id="city"
                    type="text"
                    class="mt-1 inline-block w-full"
                    v-model="form.city"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.city" />
            </div>
            <div>
                <InputLabel for="code" value="Kod pocztowy" />

                <TextInput
                    id="code"
                    type="text"
                    class="mt-1 inline-block w-full"
                    v-model="form.code"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.code" />
            </div>
            
        </div>
        <ParkRadios v-model="form.park" :error="form.errors.park" />
            <PrimaryButton :disabled="form.processing">Utwórz</PrimaryButton>

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
