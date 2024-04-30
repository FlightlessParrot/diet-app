<script setup>

import { router, usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
import { useCapitalizeFirstLetterOfEveryWord } from "@/Composables/useCapitalizeFirstLetterOfEveryWord";

const props = defineProps({
    provinces: { type: Array, required: true },
    serviceCities: { type: Array },
    serviceKinds: { type: Array },
});
const page = usePage();
const online =
    props.serviceKinds.filter((e) => e.name === "online").length > 0
        ? [true]
        : [];
const stationary =
    props.serviceKinds.filter((e) => e.name === "stationary").length > 0
        ? [true]
        : [];
const form = useForm({
    serviceCities: props.serviceCities,
    online: online,
    stationary: stationary,
});
const serviceCities = computed(() => form.serviceCities);
const capServiceCities = computed(() =>
    form.serviceCities.map((e) => {
        e.name = useCapitalizeFirstLetterOfEveryWord(e.name);
        return e;
    })
);
const serviceCity = ref({ name: "", province_id: null });
const serviceCityError = ref(false);
const checkboxes = ref(null);
const removedCities = ref([]);

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

const removeServiceCityFromFormData = (item, index) => {
    if (item.id) {
        removedCities.value.push(item.id);
    }
    form.serviceCities = serviceCities.value.filter((e, i) => i !== index);
};
const mobile = computed(() => serviceCities.value.length > 0);
const valid = computed(
    () => form.online[0] === true || form.stationary[0] === true || mobile.value
);

const submit = () => {
    console.log(removedCities.value)
    removedCities.value.forEach((id) =>
        router.delete(route("specialist.serviceCity.delete", id))
    );
    removedCities.value = [];
    form.put(route("update.services", page.props.auth.specialist.id), {
        preserveScroll: false,
        preserveState: false,
    });
};
</script>
<template>
    <form @submit.prevent="submit" class="mt-6 space-y-16">
        <Card>
            <template #content>
                <Title>
                    <template v-slot:h2Title
                        >Podaj miejscowości, do których dojedziesz.
                    </template>
                    <template v-slot:desc>
                        Jeśli oferujesz usługi z dojazdem do klienta, podaj
                        miejscowości, do których dojeżdżasz. W innym wypadku
                        przejdź do
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
                    <InputLabel
                        for="city_name"
                        value="Nazwa miejscowości"
                    />

                    <TextInput
                        id="city_name"
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
                            v-for="(item, index) in capServiceCities"
                            :label="item.name"
                            removable
                            @remove="
                                removeServiceCityFromFormData(
                                    item,
                                    index
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
                    zależności od tego, czy podałeś miejscowości, do których
                    dojeżdzasz.
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
                    <label for="stationary" class="ml-2"> Stacjonarnie </label>
                </div>
                <div class="flex items-center">
                    <Checkbox
                        :modelValue="[mobile]"
                        inputId="mobile"
                        name="mobile"
                        :value="true"
                        readonly
                    />
                    <label for="mobile" class="ml-2"> Z dojazdem </label>
                </div>
                <InputError
                    v-if="!valid"
                    class="mt-2"
                    message="Musisz podać przynajmniej jedną formę prowadzenia działalności."
                />
            </div>
        </div>
        <PrimaryButton @click="(e) => !valid && e.preventDefault()">
            Zapisz
        </PrimaryButton>
    </form>
</template>
