<script setup>

import {  useForm, router } from "@inertiajs/vue3";
import { computed, watch, ref } from "vue";
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
import Divider from "primevue/divider";
import Comment from "@/Components/Rating/Comment.vue";
import Pager from "@/Components/Pager/Pager.vue";
import CommentForm from "@/Components/Rating/CommentForm.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Address from "@/Components/Address.vue";

import Chip from 'primevue/chip';
import { useSocialMediaIcons } from "@/Composables/useSocialMediaIcons";
const props = defineProps({
    specialist: {
        type: Object,
        required: true,
    },
    reviews: {
        type: Object,
    },
    myReview: {
        type: Object,
    },
    courses: {
        type: Array,
    },
    languages: {
        type: Array,
    },
    socialMedias: {
        type: Array
    },
    guest: {
        type: Boolean,
        default: false
    },
    specializations: {
        type: Array,
        required: true
    }

});
const form = useForm({
    text: "",
    grade: 5,
});

const showUpdateForm = ref(false);

watch(
    [props],
    () => {
        if (!props.guest && props.myReview) {
            console.log(form);
            form.text = props.myReview.text;
            form.grade = props.myReview.grade * 1;
        }
    },
    { immediate: true }
);

const imageUrl = computed(() => props.specialist?.imageUrl);


const title = computed(
    () =>
        props.specialist.title +
        " " +
        props.specialist.name +
        " " +
        props.specialist.surname
);

const actionUrl = computed(()=>props.guest ? route('maybe.login',[props.specialist.id]) :route('user.book.specialist', [props.specialist.id]) )
</script>
<template>
    
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
                        <b class="mb-2 block">{{ }}</b>
                        <Rating
                            readonly
                            :model-value="specialist.statistic.review_grade"
                            :cancel="false"
                        />
                        <div class="my-4 text-lg text-blue-700 underline flex flex-col">
                        <a  :href="'tel:'+specialist.phone.number">tel. {{ specialist.phone.number }}</a>
                        <a  :href="'mailto:'+ specialist.user.email " >email: {{ specialist.user.email }}</a>
                        </div>
                        <div v-html="specialist.fullDescription"></div>
                        
                    </template>
                </Title>
            </div>
            
            <section class="my-6 space-y-8">
                <CallToAction
                    :href="actionUrl"
                    >Umów się ze specjalistą</CallToAction
                >
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
                              <Address :address="address"/>
                            </TabPanel>
                        </TabView>
                    </AccordionTab>
                    
                    <AccordionTab
                        v-if="languages.length"
                        header="Języki, w których mówię"
                    >
                        <DataTable
                            :value="languages"
                            class="my-12"
                            selectionMode="single"
                            dataKey="id"
                        >
                            <Column field="name" header="Język"></Column>
                            
                        </DataTable>
                    </AccordionTab>
                    <AccordionTab
                        v-if="
                            specializations.length > 0 
                        "
                        header="Moje specjalizacje"
                    >
                        <div v-for="specialization in specializations">
                            <div class="space-x-2">
                                <i class="pi pi-book"></i
                                ><span>{{ specialization.name }}</span>
                            </div>
                        </div>
                    </AccordionTab>
                    <AccordionTab
                        v-if="courses.length"
                        header="Moje wykształcenie"
                    >
                        <DataTable
                            :value="courses"
                            class="my-12"
                            selectionMode="single"
                            dataKey="id"
                        >
                            <Column field="name" header="Wykształcenie"></Column>
                            <!-- <Column field="start_date" header="Początek">
                            </Column> -->
                            <Column field="end_date" header="Ukończono"> </Column>
                        </DataTable>
                    </AccordionTab>
                    <AccordionTab
                        header="Cennik"
                        v-if="specialist.servicePrices.length > 0"
                    >
                        <DataTable
                            :value="specialist.servicePrices"
                            table-style=""
                        >
                            <Column field="name" header="Usługa"></Column>
                            <Column
                                body-class="text-darkGreen flex  justify-end"
                                field="price"
                                header="Cena [PLN]"
                            >
                                <template #body="slotProps">
                                    {{ slotProps.data.price + " " + "zł" }}
                                </template>
                            </Column>
                        </DataTable>
                    </AccordionTab>
                    <AccordionTab
                        header="Grupy docelowe"
                        v-if="specialist.targets.length > 0"
                    >
                    <div class="flex flex-wrap gap-2">
                        <Chip v-for="target in specialist.targets" :label="target.name" />
                    </div>
                    </AccordionTab>
                    <!-- <AccordionTab
                        v-if="specialist.fullDescription"
                        header="O mnie"
                    >
                        <div v-html="specialist.fullDescription"></div>
                    </AccordionTab> -->
                </Accordion>
                <div class="flex flex-wrap gap-2 mt-8 ms-4 p-2 border-t border-gray-200">
                <a rel="nofollow" v-for="socialMedia in socialMedias" :href="socialMedia.url" class=" flex gap-2 items-center">
                    <i :class="'pi pi-'+useSocialMediaIcons(socialMedia)+' text-darkGreen text-2xl'"></i>
                    <span class = 'text-blue-500 underline'>{{ socialMedia.type }}</span></a>
            </div>
            </section>
        </Tile>
        <Tile v-if="!guest">
            <section v-if="myReview === null">
                <h2 class="font-bold text-lg block mb-6">Dodaj opinię</h2>
                <form
                    @submit.prevent="
                        form.post(route('review.store', [specialist.id]))
                    "
                >
                    <CommentForm
                        v-model:text="form.text"
                        v-model:grade="form.grade"
                    />
                    <PrimaryButton>Publikuj</PrimaryButton>
                </form>
            </section>
            <section v-else-if="!showUpdateForm" class="space-y-2">
                <h2 class="font-bold text-lg block mb-6">Twoja opinia</h2>

                <Comment :review="myReview" />
                <PrimaryButton @click.prevent="showUpdateForm = true"
                    >Edytuj</PrimaryButton
                >
            </section>
            <section v-else class="space-y-2">
                <h2 class="font-bold text-lg block mb-6">Edytuj opinię</h2>
                <form
                    @submit.prevent="
                        form.put(route('review.update', [myReview.id]), {
                            preserveState: false,
                        })
                    "
                >
                    <CommentForm
                        v-model:text="form.text"
                        v-model:grade="form.grade"
                    />
                    <PrimaryButton>Edytuj</PrimaryButton>
                </form>
                <DangerButton
                    @click.prevent="
                        router.delete(route('review.destroy', myReview.id))
                    "
                    >Usuń</DangerButton
                >
            </section>
        </Tile>
        <Tile>
            <section>
                <h2 class="font-bold text-lg block mb-6">Opinie</h2>

                <div v-for="review in reviews.data">
                    <Comment :review="review" :key="review.id" />
                    <Divider />
                </div>
                <Pager
                    v-if="reviews.links.length > 3"
                    :last-page-url="reviews.last_page_url"
                    :links="reviews.links"
                    :first-page-url="reviews.first_page_url"
                />
            </section>
        </Tile>

</template>
