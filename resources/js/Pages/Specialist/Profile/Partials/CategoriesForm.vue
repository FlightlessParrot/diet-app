<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Title from "@/Components/Title.vue";

import {  useForm, usePage } from "@inertiajs/vue3";
import Checkbox from "primevue/checkbox";
import InputError from "@/Components/InputError.vue";
import { computed } from "vue";
const props = defineProps(["checkedCategories",'allCategories']);
const page = usePage();
const spec = computed(() => page.props.auth.specialist.id);
const form = useForm({
    categories: props.checkedCategories,
});
</script>
<template>
    <section >
        <Title>
                <template v-slot:h2Title> Wybierz kategorie </template>
                <template v-slot:desc>
                    Wybierz kategorie, które odpowiadają Twojemu profilowi
                    działalności. Dzięki temu pozwolisz się znaleźć większej
                    liczbie klientów.
                </template>
        </Title>
            <form
            class="my-4 space-y-4"
                @submit.prevent="
                    form.categories.length > 0 &&
                        form.put(route('specialist.categories.update', spec))">
                
                        <div class="space-y-2">
                            <div
                                class="flex align-items-center"
                                v-for="category in allCategories"
                            >
                                <Checkbox
                                    v-model="form.categories"
                                    :inputId="category.id.toString()"
                                    name="category"
                                    :value="category.id"
                                />
                                <label
                                    :for="category.id.toString()"
                                    class="ml-2"
                                >
                                    {{ category.name }}
                                </label>
                            </div>
                            <InputError
                                class="mt-2"
                                v-if="form.categories.length === 0"
                                message="Musisz wybrać przynajmniej jedną kategorię."
                            ></InputError>
                        </div>
                   
                <PrimaryButton>Edytuj</PrimaryButton>
            </form>
    </section>
</template>
