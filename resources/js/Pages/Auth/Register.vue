<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({
    name: '',
    surname: '',
    email: '',
    password: '',
    password_confirmation: '',
    number: '',
    newsletter: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Zarejestruj" />

        <form @submit.prevent="submit">
            
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
            <div class="mt-2">
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
            <div class="mt-2">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Hasło" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Potwierdź hasło" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
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
            <div class="mt-4">
                <div class="flex items-center gap-2">
                <Checkbox input-id="newsletter" v-model:checked="form.newsletter" :value="true" />
                <InputLabel for="newsletter" value="Zapisz mnie do newsletter'a" />
                </div>
                

                <InputError class="mt-2" :message="form.errors.newsletter" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Masz już konto?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Zarejestruj
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
