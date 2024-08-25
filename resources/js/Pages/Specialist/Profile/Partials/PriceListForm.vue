<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputNumber from 'primevue/inputnumber';
import { useForm, usePage, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Title from "@/Components/Title.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import DangerButton from "@/Components/DangerButton.vue";
import {  ref, watch,  } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props=defineProps({
    'prices':{
        type: Array,
        required: true
    }
})
const page = usePage();
const form = useForm({
    price: null,
    name: "",
});

const editForm = useForm({
    price: null,
    name: "",
});
const selectedPrice = ref(null)
const rowClass = (data)=>{
    return [{ 'bg-primary': data.id === page.props.auth.specialist.favouritePrice.id }];
}
watch(selectedPrice,()=>{editForm.price=Number(selectedPrice.value.price); editForm.name=selectedPrice.value.name;})

const editString=slotProps=>Number(slotProps.data.price).toFixed(2).toString()+' zł' 
</script>
<template>
    <section class="space-y-12">
        <Title>
            <template v-slot:h2Title> Zarządzaj swoim cennikiem </template>
            <template v-slot:desc>Dodawaj i usuwaj ceny. </template>
        </Title>
        <form :metaKeySelection="false" @submit.prevent="router.delete(route('specialist.price.delete',[page.props.auth.specialist.id,selectedPrice.id]),{preserveScroll: false, preserveState: false})">
        <DataTable v-model:selection="selectedPrice"  :value="prices" class="my-12" selectionMode="single" :metaKeySelection="false" dataKey="id">
            <Column field="name" header="Usługa"></Column>
            <Column field="price" header="Cena"> 
                <template #body="slotProps">
            {{ editString(slotProps)}}
            </template></Column>
        </DataTable>
        <SecondaryButton @click.prevent="router.post(route('favourite.price.associate',[selectedPrice]))" v-show="selectedPrice!==null">Ustaw jako typową cenę konsultacji</SecondaryButton>
        <i class="text-gray-500 text-sm block mb-4">Możesz wybrać jedną cenę jako typową cenę konsultacji. 
            Ta cena pokaże się użytkownikom w wynikach wyszukiwania.</i>
        <DangerButton v-show="selectedPrice!==null">Usuń</DangerButton>
        </form>
        
        <form v-if="selectedPrice!==null" class="my-4 space-y-4" @submit.prevent="editForm.put(route('specialist.price.update',[page.props.auth.specialist.id,selectedPrice.id]),{preserveScroll: false, preserveState: false})"  >
            <h3>Edycja ceny usługi: {{ selectedPrice.name}}</h3>
            <div class="space-y-2">
                <InputLabel for="edit_price_name" value="Usługa" />

                <TextInput
                    id="edit_price_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="editForm.name"
                    required
                />

                <InputError
                    class="mt-2"
                    :message="editForm.errors.name"
                ></InputError>
            </div>

            <div class="space-y-2">
                <InputLabel for="edit_price_price" value="Cena" />

                <InputNumber v-model="editForm.price" inputId="edit_price_price" mode="currency" currency="PLN" currencyDisplay="symbol" locale="pl-pl" class="w-full" />

                <InputError
                    class="mt-2"
                    :message="editForm.errors.price"
                ></InputError>
            </div>
            <PrimaryButton>Edytuj</PrimaryButton>
        </form>


        <form class="my-4 space-y-4" @submit.prevent="form.post(route('specialist.price.store',page.props.auth.specialist.id),{preserveScroll: true, preserveState: false})"  >
            <h3>Dodaj nową cenę usługi </h3>
            <div class="space-y-2">
                <InputLabel for="price_name" value="Usługa" />

                <TextInput
                    id="price_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.name"
                ></InputError>
            </div>
            <div class="space-y-2">
                <InputLabel for="price_price" value="Cena" />

                <InputNumber v-model="form.price" inputId="price_price" mode="currency" currency="PLN" currencyDisplay="symbol" locale="pl-pl" class="w-full" />

                <InputError
                    class="mt-2"
                    :message="form.errors.price"
                ></InputError>
            </div>
            <PrimaryButton>Dodaj</PrimaryButton>
        </form>
    </section>
</template>
