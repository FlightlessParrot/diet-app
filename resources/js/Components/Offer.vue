<script setup>
import Card from "primevue/card";
import Button from "primevue/button";
import { computed } from "vue";
import  { useOfferDurationDescription } from '@/Composables/useOfferDurationDescription'
const props = defineProps({
    offer: {
        type: Object,
        required: true
    }
 })
const emit = defineEmits(['chose'])
const duration = computed(()=>useOfferDurationDescription(props.offer));
</script>
<template>
    <Card :class="'max-w-xs min-w-72 h-max'+ (offer.discount ? ' shadow-xl' : '' )">
        <template #title>
            {{ offer.name }}
        </template>
        <template #content>
            <b class="text-darkPink">{{ duration }} </b>
            <p v-if="offer.discount" class="block text-sm text-gray-600 mt-4  line-through"><i class="pi pi-tags me-2"></i>{{Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.old_price) }}</p>
            <b class="block text-emerald-600 text-xl my-8 text-center"><i class="pi pi-tags me-2"></i>{{Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.price) }}</b>
            
            
            <div v-html="offer.description"></div>
        </template>
        <template #footer>
            <div class="flex justify-center">
                <Button @click.prevent="$emit('chose')"
                    >Wybieram
                </Button>
            </div>
        </template>
    </Card>
</template>
