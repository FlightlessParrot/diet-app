<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";
import { DatePicker } from 'v-calendar';
import 'v-calendar/style.css';
import { computed, ref, watch, watchEffect } from 'vue';
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useBookingsIntoVCalendarAttributes } from "@/Composables/useBookingsIntoVCalendarAttributes";
import Divider from "primevue/divider";
import EditBooking from '@/Components/EditBooking.vue';
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import GuestLayoutForPages from "@/Layouts/GuestLayoutForPages.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FloatLabel from "primevue/floatlabel";
const props = defineProps({
    bookings: {
        type: Array,
    },
    specialist: {
        type: Object,
        required: true
    }
});


const attrs = ref([
    {
        key: 'today',
        highlight: true,
        dates: new Date(),
    },
]);
const timeZero = new Date();
timeZero.setMilliseconds(0);
timeZero.setSeconds(0)
timeZero.setMinutes(0)
timeZero.setHours(0)
const date = ref(timeZero)
const pendingBookings = ref([])
watch([props, date], () => {
    const myBookings = props.bookings.filter(
        e => {
            const nextDay = new Date(Date.parse(date.value) + 86400000);
            const startDate = new Date(e.start_date)

            return startDate.getTime() >= new Date(date.value).getTime()
                &&
                startDate.getTime() < nextDay.getTime()
        })
    pendingBookings.value = myBookings

},)
const modal = ref(false)
watchEffect(() => attrs.value = useBookingsIntoVCalendarAttributes(props.bookings))

const form = useForm({
    full_name: '',
    email: '',
    number: ''
})
</script>
<template>

    <Head>
        <title>Zarezerwuj wizytę</title>
    </Head>
    <GuestLayoutForPages>


        <Tile>
            <section>
                <Title>
                    <template v-slot:h2Title>Zarezerwuj wizytę</template>
                    <template v-slot:desc>
                        Znajdź i zarezerwuj wizytę.
                    </template>
                </Title>
                <div class="my-8">
                    <p class="italic text-gray-400 text-sm mt-2 mb-4">Wybierz dzień, aby zobaczyć spotkania.</p>
                    <DatePicker is-required :attributes="attrs" v-model="date" locale='pl' mode="date"
                        hide-time-header />

                    <Divider />
                    <div>
                        <EditBooking v-for="booking in pendingBookings" :booking="booking">
                            <PrimaryButton @click="modal = booking.id">Rezerwuj</PrimaryButton>
                            <Modal :show="modal === booking.id" max-width="xl" :closeable="true" @close="modal = null">
                                <form @submit.prevent="form.patch(route('guest.bookings.reserve',[booking.id]))" class="p-4 space-y-8">
                                    <b class="block p-4 text-center">Podaj dane kontaktowe, aby zarezerwować wizytę</b>
                                    <div>
                                        <FloatLabel>
                                            <TextInput required id="full_name" v-model="form.full_name"></TextInput>
                                            <label for="full_name">Jak mamy się do Ciebie zwracać?</label>
                                        </FloatLabel>
                                        <InputLabel :message="form.errors.full_name" />
                                    </div>
                                    <div>
                                        <FloatLabel>
                                            <TextInput required type="tel" id="number" v-model='form.number'></TextInput>
                                            <label for="number">Numer telefonu</label>
                                        </FloatLabel>
                                        <InputLabel :message="form.errors.number" />
                                    </div>
                                    <div>
                                        <FloatLabel>
                                            <TextInput required type="email" id="email" v-model="form.email"></TextInput>
                                            <label for="email">Email</label>
                                        </FloatLabel>
                                        <InputError :message="form.errors.email" ></InputError>
                                    </div>
                                    <div class="md:flex justify-between">
                                        <SecondaryButton @click="modal = null">Anuluj</SecondaryButton>
                                        <PrimaryButton >
                                            Zarezerwuj
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </Modal>
                        </EditBooking>
                    </div>
                </div>

            </section>
        </Tile>

    </GuestLayoutForPages>
</template>