<script setup>
import FileUpload from 'primevue/fileupload';
import Avatar from 'primevue/avatar';
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps(['imageUrl',])
const page = usePage()
const specialistId =computed(()=> page.props.auth.specialist.id)
const url = computed(()=>route('icon.store',specialistId.value))
const form = useForm({
    icon: null
})
const uploader = (event) => {
 form.icon = event.files[0]
 form.post(url.value)
}
</script>
<template>
<section class="space-y-8">
        <header>
            <h2 class="text-lg flex items-center gap-2 font-medium text-gray-900"> Ikona (thumbnail)</h2>

            <p class="mt-2 text-sm text-gray-600">
                Edytuj swoją ikonę (thumbnail).
            </p>
        </header>
        <Avatar v-if="imageUrl"  :image="imageUrl" class="mr-2" size="xlarge"  />
        
    <FileUpload mode="basic" name="icon[]" customUpload :url="url" accept="image/*" :maxFileSize="100000" @upload="" @uploader="uploader"/>

</section>
</template>