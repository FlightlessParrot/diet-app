<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import Image from "primevue/image";
import Rating from "primevue/rating";
import CallToAction from "@/Components/CallToAction.vue";
import { useTranslateServicesLabel } from "@/Composables/useTranslateServicesLabel";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
const props = defineProps({
    specialist: {
        type: Object,
        required: true,
    },
});

const imageUrl = computed(() => props.specialist?.imageUrl);
const title = computed(
    () =>
        props.specialist.title +
        " " +
        props.specialist.name +
        " " +
        props.specialist.surname
);
</script>
<template>
    <Head>
        <title>Specialista - {{ title }}</title>
    </Head>
    <AuthenticatedLayout>
        <Tile>
            <div class="flex sm:flex-row flex-col gap-4 items-center my-12">
                <Image
                    imageClass="rounded-md"
                    v-if="imageUrl"
                    :src="imageUrl"
                    alt="Image"
                    width="250"
                    preview
                />

                <Title>
                    <template #h2Title>{{ title }}</template>
                    <template #desc>
                        <Rating readonly :model-value="1" :cancel="false" />
                        <p class="inline-block mt-4">
                            Zobacz profil i umów się na wizytę.
                        </p>
                    </template>
                </Title>
            </div>
            <section class="my-6 space-y-8">
                <CallToAction :href="route('user.book.specialist',[specialist.id])">Umów się ze specjalistą</CallToAction>
                <div class="flex flex-wrap gap-2 my-2">
                    <div v-for="service in specialist.services">
                        <div class="space-x-2">
                            <i class="pi pi-check-square"></i
                            ><span>{{
                                useTranslateServicesLabel(service.name)
                            }}</span>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <Accordion :activeIndex="0">
                    <AccordionTab
                        v-if="
                            specialist.cities.length > 0 &&
                            specialist.services.filter(
                                (e) => e.name === 'mobile'
                            ).length
                        "
                        header="Dojeżdżam do"
                    >
                        <div v-for="city in specialist.cities">
                            <div class="space-x-2">
                                <i class="pi pi-car"></i
                                ><span>{{ city.name }}</span>
                            </div>
                        </div>
                    </AccordionTab>
                    <AccordionTab
                        v-if="
                            specialist.stationaryAddresses.length > 0 &&
                            specialist.services.filter(
                                (e) => e.name === 'stationary'
                            ).length
                        "
                        header="Przyjmuję w"
                    >
                        <TabView>
                            <TabPanel
                                v-for="(
                                    address, index
                                ) in specialist.stationaryAddresses"
                                :header="index + 1"
                            >
                                <p>{{ address.line_1 }}</p>
                                <p>{{ address.line_2 }}</p>
                                <span>{{ address.code }}</span>
                                <span>{{ address.city }}</span>
                            </TabPanel>
                        </TabView>
                    </AccordionTab>
                    <AccordionTab header="Cennik" v-if="specialist.servicePrices.length > 0">
                        <DataTable
                            :value="specialist.servicePrices"
                            table-style=""
                        >
                            
                            <Column field="name" header="Usługa"></Column>
                            <Column body-class="text-darkGreen flex  justify-end" field="price" header="Cena [PLN]">
                                <template #body="slotProps">
                                {{ slotProps.data.price+' '+'zł' }}
                                </template>
                            </Column>
                           
                        </DataTable>
                    </AccordionTab>
                    <AccordionTab v-if="specialist.fullDescription" header="O mnie">
                       <div v-html="specialist.fullDescription"></div>
                    </AccordionTab>
                </Accordion>
            </section>
        </Tile>
    </AuthenticatedLayout>
</template>
