<script setup>


import {computed} from 'vue';
import { Link } from '@inertiajs/vue3'
import Address from './Address.vue';
const props = defineProps({
    booking: {
        type: Object,
        required: true,
    },
   
});
const specialistName = computed(()=>props.booking.specialist.title + ' ' + props.booking.specialist.name + ' '+props.booking.specialist.surname)
const isActive = computed(()=>new Date(props.booking.start_date)>new Date());

const wrapperClass = computed(()=>
isActive.value ?
"mx-auto max-w-7xl border my-6 p-4 border-green-200 space-y-4 rounded shadow" :
 "mx-auto max-w-7xl opacity-60 border-b my-6 p-4 border-gray-400 rounded space-y-4"
)
</script>
<template>
    <div :class="wrapperClass" >
        <h3 class="font-bold text-lg ">
            {{
               new Date(booking.start_date).toLocaleString("pl").slice(0,-3) 
            }}
        </h3>
        <div v-if="booking.address!==null">
            <h4 class="text-lg font-bold">Spotkanie pod adresem</h4>
            <Address :address="booking.address" />
        </div>
        <div v-else>
            <h4 class="text-lg font-bold">Spotkanie online lub z dojazdem</h4>
            <p v-if="booking.user">Skontaktuj się ze specjalistą, aby ustalić dogodną formę spotkania.</p>
        </div>
        <Link :href = "route('specialist.visit',booking.specialist.id)" class="text-blue-600 underline space-x-4"><span class="pi pi-user mr-2"></span> {{ specialistName }}</Link>
        <slot />
         
    </div>
</template>
