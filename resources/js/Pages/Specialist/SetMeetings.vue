<script setup>
import { useForm, Head, usePage, router } from "@inertiajs/vue3";
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";
import { computed, ref, watchEffect } from "vue";
import SpecialistLayout from "@/Layouts/SpecialistLayout.vue";
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useBookingsIntoVCalendarAttributes } from "@/Composables/useBookingsIntoVCalendarAttributes";
import Divider from "primevue/divider";
import EditBooking from "@/Components/EditBooking.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    bookings: {
        type: Array,
    },
});
const specialist = usePage().props.auth.specialist;
const tomorrow = new Date().setDate(new Date().getUTCDate() + 1);

const form = useForm({
    selectedDate: {
        start: tomorrow,
        end: tomorrow,
    },
});

const rules = ref({
    minutes: { interval: 15 },
});
const timeZero = new Date();
timeZero.setMilliseconds(1);
timeZero.setSeconds(0);
timeZero.setMinutes(0);
timeZero.setHours(0);
const attrs = ref([
    {
        key: "today",
        highlight: true,
        dates: timeZero,
    },
]);
const pendingAttrs = ref([
    {
        key: "today",
        highlight: true,
        dates: timeZero,
    },
]);

const filterBookings = (viewDate, element) => {
    console.log(viewDate);
    const nextDay = new Date(viewDate);
    const chooseDate = new Date(viewDate);
    const startDay = new Date(element.start_date);
    nextDay.setDate(chooseDate.getDate() + 1);
    return (
        startDay.getTime() >= chooseDate.getTime() &&
        startDay.getTime() < nextDay.getTime()
    );
};

const viewDate = ref(timeZero);
const pendingDate = ref(timeZero);
const chosenBookings = computed(() =>
    props.bookings.filter((e) => filterBookings(viewDate.value, e))
);
const allPendingBookings = computed(() =>
    props.bookings.filter((e) => e.status === "pending")
);
const pendingBookings = computed(() =>
    allPendingBookings.value.filter((e) => filterBookings(pendingDate.value, e))
);
watchEffect(
    () => (attrs.value = useBookingsIntoVCalendarAttributes(props.bookings))
);
watchEffect(
    () =>
        (pendingAttrs.value = useBookingsIntoVCalendarAttributes(
            allPendingBookings.value
        ))
);
</script>
<template>
    <Head> <title>Twoja dyspozycyjność</title></Head>
    <SpecialistLayout>
        <Tile>
            <form
                @submit.prevent="
                    form.post(route('bookings.store', [specialist.id]), {
                        preserveScroll: false,
                        preserveState: falsed,
                    })
                "
                class="mt-6 space-y-6"
            >
                <section>
                    <Title>
                        <template v-slot:h2Title>Podaj dyspozycyjność</template>
                        <template v-slot:desc>
                            Ustaw wizyty, na które mogą się zapisywać Twoi
                            klienci.
                        </template>
                    </Title>
                    <div class="my-8">
                        <p class="italic text-gray-400 text-sm mt-2 mb-4">
                            Wybierz zakres dni i godziny, w których Twoi klienci
                            mogą się umawiać na wizyty.
                        </p>
                        <DatePicker
                            color="green"
                            locale="pl"
                            v-model.range="form.selectedDate"
                            :rules="rules"
                            mode="dateTime"
                            hide-time-header
                            is24hr
                        />
                    </div>
                    <PrimaryButton :disabled="form.processing"
                        >Zapisz</PrimaryButton
                    >
                </section>
            </form>
        </Tile>
        <Tile>
            <section>
                <Title>
                    <template v-slot:h2Title>Twoja dyspozycyjność</template>
                    <template v-slot:desc>
                        Twoje spotkania z klientami.
                    </template>
                </Title>
                <div class="my-8">
                    <p class="italic text-gray-400 text-sm mt-2 mb-4">
                        Wybierz dzień, aby zobaczyć spotkania.
                    </p>
                    <DatePicker
                        :attributes="attrs"
                        v-model="viewDate"
                        locale="pl"
                        mode="date"
                        hide-time-header
                    />

                    <Divider />
                    <div>
                        <EditBooking
                            v-for="booking in chosenBookings"
                            :booking="booking"
                        >
                            <DangerButton
                                @click="
                                    router.delete(
                                        route('bookings.destroy', [
                                            specialist.id,
                                            booking.id,
                                        ])
                                    )
                                "
                                v-if="booking.status === 'created'"
                                >Usuń</DangerButton
                            >
                        </EditBooking>
                    </div>
                </div>
            </section>
        </Tile>

        <Tile>
            <section>
                <Title>
                    <template v-slot:h2Title>Potwierdź rezerwacje</template>
                    <template v-slot:desc>
                        Potwierdź spotkanie z klientem.
                    </template>
                </Title>
                <div class="my-8">
                    <p class="italic text-gray-400 text-sm mt-2 mb-4">
                        Wybierz dzień, aby zobaczyć spotkania.
                    </p>
                    <DatePicker
                        :attributes="pendingAttrs"
                        v-model="pendingDate"
                        locale="pl"
                        mode="date"
                        hide-time-header
                    />

                    <Divider />
                    <div>
                        <EditBooking
                            v-for="booking in pendingBookings"
                            :booking="booking"
                        >
                            <PrimaryButton
                                @click="
                                    router.patch(
                                        route('bookings.status', [booking.id]),
                                        array({ status: 'confirmed' })
                                    )
                                "
                                >Potwierdź</PrimaryButton
                            >
                        </EditBooking>
                    </div>
                </div>
            </section>
        </Tile>
    </SpecialistLayout>
</template>
