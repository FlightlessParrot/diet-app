<script setup>
import Card from "primevue/card";
import { useCapitalizeFirstLetterOfEveryWord } from "@/Composables/useCapitalizeFirstLetterOfEveryWord.js";
import { computed } from "vue";
import Rating from "primevue/rating";
import Avatar from "primevue/avatar";
const props = defineProps({
    specialist: {
        type: Object,
        required: true,
    },
});

const unmodifiedFullName = computed(
    () => props.specialist.name + " " + props.specialist.surname
);
const serviceName = function (name) {
    switch (name) {
        case "mobile":
            return "Z dojazdem";
        case "stationary":
            return "stacjonarnie";
        default:
            return "online";
    }
};
const fullName = useCapitalizeFirstLetterOfEveryWord(unmodifiedFullName.value);
const url = computed(()=>"/specialista/"+props.specialist.id)
</script>
<template>
    <a class="hover:scale-95 transition cursor-pointer" :href="url">
        <Card class="h-full">
            <template #title>
                <div class="my-2 flex align-center gap-2">
                    <Avatar
                        :image="specialist.attachment[0].url"
                        size="xlarge"
                    />
                    <div>
                        <h3>{{ fullName }}</h3>
                        <Rating readonly :model-value="1" :cancel="false" />
                    </div>
                </div>
            </template>
            <template #content>
                <div>
                    <div class="flex flex-wrap gap-2 my-2">
                        <div v-for="service in specialist.services">
                            <div class="space-x-2">
                                <i class="pi pi-check-square"></i
                                ><span>{{ serviceName(service.name) }}</span>
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
