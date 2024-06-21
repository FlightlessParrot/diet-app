<script setup>
import { useForm, Head, usePage } from "@inertiajs/vue3";
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';
import { ref } from 'vue'
import SpecialistLayout from "@/Layouts/SpecialistLayout.vue";
import Tile from "@/Components/Tile.vue";
import Title from "@/Components/Title.vue";
import RadioButton from 'primevue/radiobutton';
import PrimaryButton from "@/Components/PrimaryButton.vue";
const tomorrow=new Date().setDate(new Date().getUTCDate()+1);

const form=useForm({
   selectedDate: {
       start: tomorrow,
       end: tomorrow,
   },


})
const rules = ref({

  minutes: { interval: 15 },
});

</script>
<template>
     <Head> <title>Twoja dyspozycyjność</title></Head>
     <SpecialistLayout>
      <Tile>
         <form
            @submit.prevent="form.put(route('description.update',[specialist.id, description.id]),{ preserveScroll: true, preserveState: true})"
            class="mt-6 space-y-6"
        >
         <section>
            <Title>
                <template v-slot:h2Title>Podaj dyspozycyjność</template>
                <template v-slot:desc>
                    Ustaw wizyty, na które mogą się zapisywać Twoi pacjenci.
                </template>
            </Title>
         <div class="my-8">
         <p class="italic text-gray-400 text-sm mt-2 mb-4">Wybierz zakres dni i godziny, w których Twoi klienci mogą się umawiać na wizyty.</p>
         <DatePicker locale='pl' v-model.range='form.selectedDate' :rules="rules"  mode="dateTime" hide-time-header is24hr/> 
      </div>
      
     
      
         <p>{{form.selectedDate}}</p>
      </section>  
      <PrimaryButton :disabled="form.processing">Zapisz</PrimaryButton>

   </form>
      </Tile>
        <Calendar />
        <DatePicker locale='pl' v-model.range='form.selectedDate' mode="dateTime" is24hr/>
     </SpecialistLayout>
</template>