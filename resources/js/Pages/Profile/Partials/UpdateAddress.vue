<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimeDropdown from "@/Components/PrimeDropdown.vue";
import TextInput from "@/Components/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";


const props = defineProps({
    address: {
        type: Object,
    },
    hasAddress: {
        type: Boolean,
        required: true,
    },
    provinces: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    province_id: props.address?.province_id ? props.address.province_id : "",
    city: props.address?.city ? props.address.city : "",
    code: props.address?.code ? props.address.code : "",
    line_1: props.address?.line_1 ? props.address.line_1 : "",
    line_2: props.address?.line_2 ? props.address?.line_2 : "",
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Adres</h2>

            <p class="mt-1 text-sm text-gray-600">
                {{
                    hasAddress
                        ? "Edytuj swoje dane adresowe."
                        : "Utwórz swoje dane adresowe."
                }}
            </p>
        </header>

        <form
            @submit.prevent="
                hasAddress
                    ? form.put(route('address.update', address.id), {
                          preserveScroll: true,
                      })
                    : form.post(route('address.store'), {
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

            <PrimaryButton :disabled="form.processing">{{
                hasAddress ? "Zapisz" : "Utwórz"
            }}</PrimaryButton>

            <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                    Zapisano zmiany.
                </p>
            </Transition>
        </form>
        <form class="mt-6 space-y-6">
            <DangerButton
                @click.prevent="
                    router.delete(route('address.remove', address.id), {
                        preserveScroll: true,
                        preserveState: false,
                    })
                "
                v-if="hasAddress"
                >Usuń adres</DangerButton
            >
        </form>
    </section>
</template>
