<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";
import {ref } from "vue";
import WhichDayOfWeekRadios from '@/Components/Radios/WhichDayOfWeekRadios.vue'
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import Address from "@/Components/Address.vue"
import WhichDayOfWeekCheckboxes from "@/Components/checkboxes/WhichDayOfWeekCheckboxes.vue";
const props = defineProps({
    provinces: {
        type: Array,
        required: true,
    },
    addresses: {
        type: Array,
    },
})
const specialist = usePage().props.auth.specialist;
const tomorrow = new Date();
tomorrow.setDate(new Date().getUTCDate() + 1)
const nextDay = new Date();
nextDay.setDate(new Date().getUTCDate() + 2)
const form = useForm({
    selectedDate: {
        start: tomorrow.toISOString(),
        end: nextDay.toISOString(),
    },
    address: 0,
    days: []
    
});

const rules = ref({
    minutes: { interval: 15 },
});
</script>
<template>
        <Tile>
            <form
                @submit.prevent="
                    form.transform((data)=>({...data, address: (data.address>0 ? addresses[data.address-1].id : null)
                    })).post(route('bookings.store', [specialist.id]), {
                        preserveScroll: false,
                        preserveState: false,
                    })
                "
                class="mt-6 space-y-6"
            >
                <section>
                    <Title>
                       
                        <template v-slot:h2Title>Podaj dyspozycyjność</template>
                        <template v-slot:desc>
                            Ustaw wizyty, na które mogą się zapisywać Twoi
                            klienci. {{form}}
                        </template>
                    </Title>
                    <div class="my-8">
                       
                        <i class="block text-gray-400 text-sm mt-2 mb-4">
                            Wybierz zakres dni i godziny, w których Twoi klienci
                            mogą się umawiać na wizyty.
                        </i>
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
                    <i class=" text-gray-400 text-sm mt-2 mb-4">
                            Wybierz adres pod którym spotkasz się z klientem.
                        </i>
                    <TabView v-model:activeIndex="form.address">
                        <TabPanel header="Online lub z dojazdem">
                            <p>Spotkanie online lub z dojazdem do klienta. Indywidualnie umawiane po rezerwacji spotkania.</p>
                        </TabPanel>
                        <TabPanel
                            v-for="(address, index) in addresses"
                            :header="'Adres '+(index + 1)"
                        >
                
                          <Address :address="address" />
                        </TabPanel>
                       
                    </TabView>
                    <WhichDayOfWeekCheckboxes v-model="form.days" :error="form.errors.days" class="mt-4 mb-6"/>
                    <PrimaryButton :disabled="form.processing" 
                        >Zapisz</PrimaryButton
                    >
                </section>
            </form>
        </Tile>
</template>
