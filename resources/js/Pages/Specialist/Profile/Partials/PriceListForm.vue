<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";

const page = usePage();
const form = useForm({
    price: "",
    name: "",
});
</script>
<template>
    <section>
        <Title>
            <template v-slot:h2Title> Zarządzaj swoim cennikiem </template>
            <template v-slot:desc> </template>
        </Title>
        <form class="my-4 space-y-4" @submit.prevent="">
            <div class="space-y-2">
                <InputLabel for="price_name" value="Usługa" />

                <TextInput
                    id="price_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError
                    class="mt-2"
                    v-if="form.categories.length === 0"
                    :message="form.errors.price"
                ></InputError>
            </div>

            <PrimaryButton>Edytuj</PrimaryButton>
        </form>
    </section>
</template>
