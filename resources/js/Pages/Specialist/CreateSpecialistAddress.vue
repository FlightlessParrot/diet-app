<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Tile from "@/Components/Tile.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head, usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimeDropdown from "@/Components/PrimeDropdown.vue";
import Title from "@/Components/Title.vue";
import { computed } from "vue";

const form = useForm({
    province_id: null,
    city: "",
    code: "",
    line_1: "",
    line_2: "",
});
const page = usePage()
const spec = computed(()=>page.props.auth.specialist.id);
const props = defineProps({
    provinces: { type: Array, required: true },
});
</script>
<template>
    <Head> <title>Utwórz profil specjalisty</title></Head>
    <AuthenticatedLayout>
        <Tile>
            <Title>
                <template v-slot:h2Title>Podaj adres</template>
                <template v-slot:desc>
                    Podaj adres, pod którym znajdą Cię Twoi klienci.
                </template>
            </Title>
            <form
                @submit.prevent="
                    form.post(route('specialist.address.store', spec), {
                        preserveScroll: true,
                    })
                "
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
                    <InputLabel for="province" value="Województwo" />

                    <PrimeDropdown
                        v-model="form.province_id"
                        required
                        placeholder="Wybierz województwo"
                        :options="provinces"
                    />
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
                <PrimaryButton> Dalej </PrimaryButton>
            </form>
        </Tile>
    </AuthenticatedLayout>
</template> 
