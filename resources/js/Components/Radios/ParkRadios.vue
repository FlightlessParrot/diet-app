<script setup>
import RadioButton from "primevue/radiobutton";
import InputError from "@/Components/InputError.vue";
const model = defineModel();
const props = defineProps(["error"]);
</script>
<template>
    <div>
        <div class="flex gap-2">
            <RadioButton
                v-model="model"
                inputId="truepark"
                :value="true"
                name="park"
            />
            <label for="truepark"
                >Pod tym adresem można zaparkować samochód.</label
            >
        </div>
        <div class="flex gap-2">
            <RadioButton
                v-model="model"
                inputId="falsepark"
                :value="false"
                name="park"
            />
            <label for="target.name"
                >Pod tym adresem nie można zaparkować samochodu.</label
            >
        </div>
        <InputError class="mt-2" :message="error" />
    </div>
</template>
