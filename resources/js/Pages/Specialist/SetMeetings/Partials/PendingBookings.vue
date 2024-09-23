<script setup>
import {router } from "@inertiajs/vue3";
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";
import { computed, ref, watchEffect } from "vue";
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useBookingsIntoVCalendarAttributes } from "@/Composables/useBookingsIntoVCalendarAttributes";
import Divider from "primevue/divider";
import EditBooking from "@/Components/EditBooking.vue";
import {useFilterBookings} from "@/Composables/useFilterBookings";

const props = defineProps({
    bookings: {
        type: Array,
    },
});

const timeZero = new Date();
timeZero.setMilliseconds(1);
timeZero.setSeconds(0);
timeZero.setMinutes(0);
timeZero.setHours(0);

const pendingAttrs = ref([
    {
        key: "today",
        highlight: true,
        dates: timeZero,
    },
]);


const pendingDate = ref(timeZero);

const allPendingBookings = computed(() =>
    props.bookings.filter((e) => e.status === "pending")
);
const pendingBookings = computed(() =>
    allPendingBookings.value.filter((e) => useFilterBookings(pendingDate.value, e))
);

watchEffect(
    () =>
        (pendingAttrs.value = useBookingsIntoVCalendarAttributes(
            allPendingBookings.value
        ))
);
</script>
<template>
    <Tile>
            <section>
                <Title>
                    <template v-slot:h2Title>Potwierdź rezerwacje</template>
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
                                        { status: 'confirmed' }
                                    )
                                "
                                >Potwierdź</PrimaryButton
                            >
                        </EditBooking>
                    </div>
                </div>
            </section>
        </Tile>
</template>