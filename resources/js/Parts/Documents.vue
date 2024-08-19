<script setup>
import FileUpload from 'primevue/fileupload';
import { computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import DangerButton from '@/Components/DangerButton.vue';
const props = defineProps(['documents']);
const url = computed(()=>route('document.store'))
const form = useForm({
    files: null
})
const uploader = (event) => {
    
    
 form.files = event.files
 form.post(url.value)
 
}
</script>
<template>
<DataTable :value="documents" field="name">
    <Column field="name" header="Nazwa dokumentu"></Column>
    <Column header="Pobierz">
        <template #body="slotProps">
             <a :href="route('document.download',slotProps.data.id)"> Pobierz dokument</a>
        </template>
    </Column>
    <Column header="Usuń">
        <template #body="slotProps">
             <DangerButton @click.prevent="router.delete(route('document.destroy',slotProps.data.id))"> Usuń dokument</DangerButton>
        </template>
    </Column>
</DataTable>
<FileUpload name="documents[]" customUpload :url="url" @upload="router.reload({ only: ['documents'] })" @uploader="uploader($event)"  :multiple="true" accept="image/*,application/pdf" :maxFileSize="35000000">
    <template #empty>
        <p>Przenieś tutaj dokumenty </p>
    </template>
</FileUpload>
</template>