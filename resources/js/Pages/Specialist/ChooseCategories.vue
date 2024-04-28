<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3"
import Checkbox from 'primevue/checkbox';
import Card from 'primevue/card';
import InputError from "@/Components/InputError.vue";
import { computed } from "vue";
const props = defineProps(['categories'])
const page = usePage()
const spec = computed(()=>page.props.auth.specialist.id);
const form = useForm({
    categories: []
})
</script>
<template>
    <Head> <title>Utwórz profil specjalisty</title></Head>
    <AuthenticatedLayout>
            <Tile><Title
                >
                <template v-slot:h2Title> Wybierz kategorie </template>
                <template v-slot:desc>
                    Wybierz kategorie, które odpowiadają Twojemu profilowi działalności. Dzięki temu pozwolisz się znaleźć większej liczbie klientów.
                </template>
            </Title>
                <form @submit.prevent="form.categories.length > 0 && form.post(route('specialist.categories.store',spec))" class="m-6">
                   
                    <Card>
                        <template #content>
                            <div class="space-y-2">
                    <div class="flex align-items-center" v-for="category in categories">
                <Checkbox v-model="form.categories" :inputId="category.id.toString()" name="category" :value="category.id" />
                <label :for="category.id.toString()" class="ml-2"> {{ category.name }} </label>
                </div>
                <InputError class="mt-2" v-if="form.categories.length === 0" message="Musisz wybrać przynajmniej jedną kategorię."></InputError>
            </div>
            </template>
            
            </Card>
            <PrimaryButton>Utwórz konto specjalisty</PrimaryButton>
                </form>
                
            </Tile>
            
    </AuthenticatedLayout>
</template>