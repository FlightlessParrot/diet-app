<script setup>
import { Head, router } from "@inertiajs/vue3";
import { DatePicker } from 'v-calendar';
import 'v-calendar/style.css';
import { computed, ref, watch, watchEffect } from 'vue';
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useBookingsIntoVCalendarAttributes } from "@/Composables/useBookingsIntoVCalendarAttributes";
import Divider from "primevue/divider";   
import EditBooking from '@/Components/EditBooking.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
const props = defineProps({bookings:{
   type: Array,
},
specialist: {
    type: Object,
    required: true
}});


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
watch([props,date],()=>{
    const myBookings =props.bookings.filter(
   e=>{
   const nextDay=new Date(Date.parse(date.value)+86400000 );
   const startDate = new Date(e.start_date)
      
   return startDate.getTime()>=new Date(date.value).getTime()
   &&
   startDate.getTime()<nextDay.getTime()  
   })
   pendingBookings.value=myBookings

},)
const modal = ref(false)
watchEffect(()=>attrs.value=useBookingsIntoVCalendarAttributes(props.bookings))
</script>
<template>
     <Head> <title>Zarezerwuj wizytę</title></Head>
     <AuthenticatedLayout>
    
   
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
         <DatePicker is-required  :attributes="attrs" v-model="date"  locale='pl' mode="date" hide-time-header /> 
          
         <Divider />
         <div  >
            <EditBooking v-for="booking in pendingBookings" :booking="booking" >
               <PrimaryButton @click="modal=booking.id">Rezerwuj</PrimaryButton>
               <Modal :show="modal===booking.id" max-width="xl" :closeable="true" @close="modal=null">
                  <div class="p-4">
                     <b class="block p-4 text-center">Czy na pewno chcesz zarezerwować wizytę?</b>
                     <div class="md:flex justify-between">
                     <SecondaryButton @click="modal=null">Nie</SecondaryButton>
                     <PrimaryButton @click="router.patch(route('bookings.reserve',[booking.id]))">Tak</PrimaryButton>
                  </div>
                  </div>
               </Modal>
            </EditBooking>
         </div>
      </div>
     
      </section> 
      </Tile>
        
     </AuthenticatedLayout>
</template>