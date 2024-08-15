<script setup>
import { usePage, router } from "@inertiajs/vue3";
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";
import { computed, ref, watchEffect } from "vue";

import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";

import { useBookingsIntoVCalendarAttributes } from "@/Composables/useBookingsIntoVCalendarAttributes";
import Divider from "primevue/divider";
import EditBooking from "@/Components/EditBooking.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {useFilterBookings} from "@/Composables/useFilterBookings";


const props = defineProps({
    bookings: {
        type: Array,
    },
});
const specialist = usePage().props.auth.specialist;
const tomorrow = new Date().setDate(new Date().getUTCDate() + 1);


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

const viewDate = ref(timeZero);
const chosenBookings = computed(() =>
    props.bookings.filter((e) => useFilterBookings(viewDate.value, e))
);

watchEffect(
    () => (attrs.value = useBookingsIntoVCalendarAttributes(props.bookings))
);

</script>
<template>
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
</template>