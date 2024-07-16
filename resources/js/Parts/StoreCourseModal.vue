<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm,  usePage} from "@inertiajs/vue3";

import PrimaryButton from "@/Components/PrimaryButton.vue";

import { DatePicker } from "v-calendar";
import "v-calendar/style.css";

const props = defineProps({
    course: {
        type: Object,
    },
    update: {
        type: Boolean,
        default: false
    }
});
const showModal = defineModel({required: true})
const specialist=usePage().props.auth.specialist
const form = useForm({
    name: props.update ? props.course.name:"",
    selectedDate: {start: props.update ? props.course.start_date:null, end: props.update ? props.course.end_date:null}
});
const store = () => {
    form.post(route('course.store',specialist.id),{
        preserveScroll: true,
        onSuccess: closeModal

    })
}

const put = () => {
    form.put(route('course.update',props.course?.id),{
        preserveScroll: true,
        onSuccess: closeModal
    })
}



const closeModal = () => {
    showModal.value = false;
    form.reset();
};

</script>

<template>
        <div>
       
        <Modal :show="showModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{update ? 'Dodaj ' : 'Edytuj '}}kurs, szkolenie lub ukończoną szkołę.
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Pokaż swoim klientom jak zdobywałeś lub zdobywałaś
                    wykształcenie.
                </p>

                <div class="mt-6">
                    <InputLabel for="name" value="Nazwa kursu"  />

                    <TextInput
                        id="name"
                        v-model="form.name"
                        class="mt-1 block w-3/4"
                        placeholder="Nazwa kursu"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                <div class="mt-6">
                    <InputLabel value="Podaj czas trwania kursu"  />
                    <DatePicker
                            color="green"
                            locale="pl"
                            v-model.range="form.selectedDate"
                            mode="date"
                            hide-time-header
                        />
                        <InputError :message="form.errors['selectedDate.start']" class="mt-2" />
                        <InputError :message="form.errors['selectedDate.end']" class="mt-2" />
                    </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Anuluj
                    </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click.prevent="update? put() :store()"
                    >
                    {{!update ? 'Utwórz' : 'Edytuj'}}
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
