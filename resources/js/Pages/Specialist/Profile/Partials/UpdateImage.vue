<script setup>
import FileUpload from 'primevue/fileupload';
import Image from 'primevue/image';
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps(['imageUrl',])
const page = usePage()
const specialistId =computed(()=> page.props.auth.specialist.id)
const url = computed(()=>route('avatar.store',specialistId.value))
const form = useForm({
    avatar: null
})
const uploader = (event) => {
 form.avatar = event.files[0]
 form.post(url.value)
}
</script>
<template>
<section class="space-y-8">
        <header>
            <h2 class="text-lg flex items-center gap-2 font-medium text-gray-900"> Zdjęcie profilowe</h2>

            <p class="mt-2 text-sm text-gray-600">
                Edytuj swoje zdjęcie profilowe.
            </p>
        </header>
        <Image v-if="imageUrl" :src="imageUrl" alt="Image" width="250" preview />
        
    <FileUpload mode="basic" name="avatar[]" customUpload :url="url" accept="image/*" :maxFileSize="100000" @upload="" @uploader="uploader"/>

</section>
</template>