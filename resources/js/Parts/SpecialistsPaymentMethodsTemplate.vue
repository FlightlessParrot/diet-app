<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Checkbox from "primevue/checkbox";
import { useForm } from "@inertiajs/vue3";
import Title from "@/Components/Title.vue";

const payments=[
    {name: 'karta',
    value:'karta',},
    {name:'gotówka',
    value:'gotówka'},
    {name:'blik',
    value:'blik'},
   {name: 'przelew',
   value: 'przelew'}
]
const props = defineProps({
    paymentMethods: {
        type: Array,
        required: true
    }
});
const form = useForm({
    
        paymentMethods: props.paymentMethods,
    
})
</script>
<template>
    <form @submit.prevent="form.put(route('specialist.payments'))" class="space-y-4"> 
        <Title>
                <template v-slot:h2Title> Wybierz metody płatności </template>
                <template v-slot:desc>
                    Pokaż użytkownikom jak mogą u Ciebie płacić.
                </template>
        </Title>
        <div class="flex gap-2 flex-row">
        <div class="flex gap-2" v-for="(payment, i) in payments">
                <Checkbox :input-id="i + '_payment'" v-model="form.paymentMethods" name="paymentMethods" :value="payment.value"/>
                <label :for="i + '_payment'">{{ payment.name }}</label>
            </div>
</div>
    <PrimaryButton>Edytuj</PrimaryButton>
    </form>
</template>