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
});

const unmodifiedFullName = computed(
    () => props.specialist.name + " " + props.specialist.surname
);

const fullName = useCapitalizeFirstLetterOfEveryWord(unmodifiedFullName.value);
const url = computed(()=>"/specialista/"+props.specialist.id)
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
                <div class="sm:absolute z-10 flex justify-end top-4 right-8 block">
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
                    <div class="flex flex-wrap gap-2 my-2">
                        <div v-for="city in specialist.cities">
                            <div class="space-x-2">
                                <i class="pi pi-car"></i
                                ><span>{{ city.name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 my-2">
                        <div v-for="home in specialist.addresses">
                            <div class="space-x-2">
                                <i class="pi pi-home"></i
                                ><span>{{ home.city }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <i class="text-slate-400 text-sm">Kliknij, aby umówić się na wizytę.</i>
                </div>
            </template>
        </Card>
    </a>
</template>
