<script setup>
import Card from "primevue/card";
import { useCapitalizeFirstLetterOfEveryWord } from "@/Composables/useCapitalizeFirstLetterOfEveryWord.js";
import { computed } from "vue";
import Rating from "primevue/rating";
import Avatar from "primevue/avatar";
import { useTranslateServicesLabel } from "@/Composables/useTranslateServicesLabel";
import HeartButton from "@/Components/HeartButton.vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    specialist: {
        type: Object,
        required: true,
    },
    guest: {
        type: Boolean,
        default: false
    }
});

const unmodifiedFullName = computed(
    () => props.specialist.name + " " + props.specialist.surname
);

const fullName = useCapitalizeFirstLetterOfEveryWord(unmodifiedFullName.value);
const url = computed(()=>props.guest? route('guest.specialist.visit',props.specialist.id) :route('specialist.visit',props.specialist.id) )

const followOrNot = ()=>{
    if(!props.specialist.favourite)
    {
        router.post(route('follow.specialist',[props.specialist.id]))
    }else{
        router.delete(route('unfollow.specialist',[props.specialist.id]))
    }
}
</script>
<template>
    <a class="hover:scale-95 transition cursor-pointer" :href="url">
        
        <Card class="h-full relative top-0">
            <template #title>
                <div v-if="!guest" class="sm:absolute z-10 flex justify-end top-4 right-8 ">
                <HeartButton :filled="specialist.favourite" @click.stop.prevent="followOrNot" ></HeartButton>
                </div>
                <div class="my-2 flex align-center gap-2">
                    
                    <Avatar 
                        :image="specialist.image?.url"
                        size="xlarge"
                    />
                    <div>
                        <h3>{{ fullName }}</h3>
                        <Rating readonly :model-value="specialist.statistic.review_grade" :cancel="false" />
                    </div>
                </div>
            </template>
            <template #content>
                <div>
                    <div class="flex flex-wrap gap-2 my-2">
                        <div v-for="service in specialist.services">
                            <div class="space-x-2">
                                <i class="pi pi-check-square"></i
                                ><span>{{ useTranslateServicesLabel(service.name) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center flex-wrap gap-2 my-2">
                        <i class="pi pi-car"></i
                            >
                        <div v-for="city in specialist.cities">
                            <div class="space-x-2">
                                <span>{{ city.name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center flex-wrap gap-2 my-2">
                         <i class="pi pi-home"></i
                                >
                        <div v-for="home in specialist.addresses">
                            <div class="space-x-2">
                               <span>{{ home.city }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center flex-wrap gap-2 my-2">
                       <i class="pi pi-thumbs-up" /> <div v-for="target in specialist.targets">
                            
                            <div class="space-x-2">
                               <span>{{ target.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-darkGreen flex justify-end sm:absolute bot-6 right-6" v-if="specialist.favourite_price">
                    <div>
                    <i class="pi pi-tags" />
                    {{ new Intl.NumberFormat('pl',{
                        style: 'currency',
                        currency: 'PLN'
                    }).format(specialist.favourite_price.price) }}
                    </div>
                </div>
                <div>
                    <i class="text-slate-400 text-sm">Kliknij, aby umówić się na wizytę.</i>
                </div>
            </template>
        </Card>
    </a>
</template>
