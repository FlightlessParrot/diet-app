<script setup>
import { usePage } from '@inertiajs/vue3';
import Message from 'primevue/message';
import { computed } from 'vue';

const page = usePage()
const message = computed(()=>page.props.flash.message)

const errors = computed(()=>Object.values(page.props.errors))

</script>
<template>
  <div v-if="message?.text || errors.length > 0" class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                   
                <Message v-if='message?.text':severity="message?.status">{{ message?.text }}</Message>
                <Message v-for="error in errors" severity="error">{{error}}</Message> 
               
            </div>
        </div>
</template>
