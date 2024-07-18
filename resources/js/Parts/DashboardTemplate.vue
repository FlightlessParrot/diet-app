<script setup>

import Tile from "@/Components/Tile.vue"
import Notification from "@/Components/Notification.vue";
import Pager from '@/Components/Pager/Pager.vue';

const props = defineProps({
    notifications: {
        type: Object
    },
    specialist: {
        type: Boolean,
        default:false
    }
})
</script>

<template>
   
       <section>
        <Tile  v-for="notification in notifications.data" :class="notification.read_at!==null ? 'opacity-70':''">
            <Notification :specialist="specialist" :notification="notification"/>
        </Tile>
       <Tile v-if="!notifications.data.length">
                    <div class=" text-gray-900">Nie masz żadnych nowych powiadomień</div>
        </Tile>
        <Pager v-if="notifications.links.length>3" :last-page-url="notifications.last_page_url" 
            :links="notifications.links" 
            :first-page-url="notifications.first_page_url" />
        </section>
</template>
