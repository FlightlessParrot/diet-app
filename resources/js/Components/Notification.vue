<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { computed } from 'vue';
const props = defineProps({
    notification: {
        type: Object,
        required: true
    },
    specialist: {
        type: Boolean
    }
})

const routeToMark = computed(()=> 
props.specialist ? 
route('specialist.notification.mark',[notification.notifiable_id]) : 
route('user.notification.mark',[notification.notifiable_id]) 
);
</script>
<template>
    <div class=" text-gray-900">
        <p>
            {{ notification.data.line_1 }}
        </p>
        <p v-if = 'notification.data.line_2'>
            {{ notification.data.line_2 }}
        </p>
        <SecondaryButton v-if="!notification.read_at" class="mt-4" @click.prevent="router.patch(routeToMark)">Przeczytane</SecondaryButton>
        <i class="text-sm mt-2" v-else>przeczytano</i>
    </div>
</template>