<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import Card from "primevue/card";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { computed, ref } from "vue";
import PrimeDropdown from "@/Components/PrimeDropdown.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Divider from "primevue/divider";
import Chip from "primevue/chip";
import Checkbox from "primevue/checkbox";

const props = defineProps({
    provinces: { type: Array, required: true },
});
const page = usePage();
const form = useForm({
    serviceCities: [],
    online: [],
    stationary: [],
});
const serviceCities = computed(() => form.serviceCities);
const serviceCity = ref({ name: "", province_id: null });
const serviceCityError = ref(false);
const checkboxes = ref(null);

const addServiceCityToFormData = () => {
    if (
        serviceCity.value.name !== "" &&
        serviceCity.value.province_id !== null
    ) {
        serviceCities.value.push({ ...serviceCity.value });
        serviceCity.value = { name: "", province_id: null };
        serviceCityError.value = false;
    } else {
        serviceCityError.value = true;
    }
};
const mobile = computed(() => serviceCities.value.length > 0);
const valid = computed(
    () => form.online[0] === true || form.stationary[0] === true || mobile.value
);
</script>
<template>
    <Head> <title>Utwórz profil specjalisty</title></Head>
    <AuthenticatedLayout>
        <Tile>
            <Title @click="console.log(form.serviceCities)">
                <template v-slot:h2Title>
                    Wybierz jak świadczysz usługi.
                </template>
                <template v-slot:desc>
                    Podaj, czy świadczysz usługi zdalnie, u siebie czy u
                    klienta?
                </template>
            </Title>
        </Tile>
        <Tile>
            <form
                @submit.prevent="
                    form.post(
                        route('store.services', page.props.auth.specialist.id),
                        {}
                    )
                "
                class="mt-6 space-y-16"
            >

                <Card>
                    <template #content>
                        <Title>
                            <template v-slot:h2Title
                                >Podaj miejscowości, do których dojedziesz.
                            </template>
                            <template v-slot:desc>
                                Jeśli oferujesz usługi z dojazdem do klienta,
                                podaj miejscowości, do których dojeżdżasz. W
                                innym wypadku przejdź do
                                <button
                                    class="text-blue-500 underline"
                                    @click.prevent="
                                        checkboxes.scrollIntoView('alignToTop')
                                    "
                                >
                                    kolejnego kroku.
                                </button>
                            </template>
                        </Title>

                        <div class="mt-8 max-w-screen-sm">
                            <InputLabel for="name" value="Nazwa miejscowości" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="serviceCity.name"
                                autofocus
                            />

                            <InputError
                                v-if="serviceCityError"
                                class="mt-2"
                                message="Nazwa jest wymagana."
                            />
                        </div>
                        <div class="mt-8 max-w-screen-sm">
                            <InputLabel
                                for="province"
                                value="Województwo"
                                class="mb-2"
                            />

                            <PrimeDropdown
                                inputId="province"
                                v-model="serviceCity.province_id"
                                required
                                placeholder="Wybierz województwo"
                                :options="provinces"
                            />
                            <InputError
                                v-if="serviceCityError"
                                class="mt-2"
                                message="Musisz podać województwo."
                            />
                        </div>
                        <SecondaryButton
                            @click.prevent="addServiceCityToFormData"
                            class="my-8"
                        >
                            Dodaj miejscowość
                        </SecondaryButton>
                        <Divider />
                        <div>
                            <h3 class="block mb-6">Wybrane miejscowości</h3>
                            <div class="flex flex-wrap gap-2">
                                <Chip
                                    :key="item.name"
                                    v-for="(item, index) in serviceCities"
                                    :label="item.name"
                                    removable
                                    @remove="
                                        form.serviceCities =
                                            serviceCities.filter(
                                                (e, i) => i !== index
                                            )
                                    "
                                />
                            </div>
                        </div>
                    </template>
                </Card>
                <div ref="checkboxes">
                    <Title>
                        <template v-slot:h2Title>
                            Podaj formy w jakich świadczysz usługi.
                        </template>
                        <template v-slot:desc>
                            Usługi z dojazdem zostaną zaznaczone automatycznie w
                            zależności od tego, czy podałeś miejscowości, do
                            których dojeżdzasz.
                        </template>
                    </Title>

                    <div class="flex flex-wrap gap-3 mt-6">
                        <div class="flex items-center">
                            <Checkbox
                                v-model="form.online"
                                inputId="online"
                                name="online"
                                :value="true"
                                :checked="form.online"
                            />
                            <label for="online" class="ml-2"> Online </label>
                        </div>
                        <div class="flex items-center">
                            <Checkbox
                                v-model="form.stationary"
                                inputId="stationary"
                                name="stationary"
                                :value="true"
                            />
                            <label for="stationary" class="ml-2">
                                Stacjonarnie
                            </label>
                        </div>
                        <div class="flex items-center">
                            <Checkbox
                                :modelValue="[mobile]"
                                inputId="mobile"
                                name="mobile"
                                :value="true"
                                readonly
                            />
                            <label for="mobile" class="ml-2">
                                Z dojazdem
                            </label>
                        </div>
                    </div>
                    <InputError
                        v-if="!valid"
                        class="mt-2"
                        message="Musisz podać przynajmniej jedną formę prowadzenia działalności."
                    />
                </div>
                <PrimaryButton @click="(e) => !valid && e.preventDefault()">
                    Dalej
                </PrimaryButton>
            </form>
        </Tile>
    </AuthenticatedLayout>
</template>
