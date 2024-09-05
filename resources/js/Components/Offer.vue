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
    <Card class="max-w-xs">
        <template #title>
            {{ offer.name }}
        </template>
        <template #content>
            <b class="text-darkPink">{{ duration }} </b>
            <b class="block text-emerald-600 mb-4">{{Intl.NumberFormat('pl',{style:'currency', currency:'PLN'}).format(offer.price) }}</b>
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
