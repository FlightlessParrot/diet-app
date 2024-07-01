<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ElementsWrapper from '@/Components/ElementsWrapper.vue'
import EditBooking from '@/Components/EditBooking.vue';
import Pager from '@/Components/Pager/Pager.vue';
import Title from '@/Components/Title.vue';
import Tile from '@/Components/Tile.vue';
import BookingDetailes from '@/Components/BookingDetailes.vue';
const props = defineProps({
    bookings: Object
})
</script>
<template>
    <AuthenticatedLayout>
        <Tile>
        <section>
            <Title>
                <template v-slot:h2Title>Twoje wizyty</template>
                <template v-slot:desc>
                    Historia Twoich wizyt.
                </template>
            </Title>
            <ElementsWrapper>
                <BookingDetailes v-for="booking in bookings.data" :booking="booking" />
                
                
            </ElementsWrapper>
            <Pager v-if="bookings.links.length>3" :last-page-url="bookings.last_page_url" 
            :links="bookings.links" 
            :first-page-url="bookings.first_page_url" />
        </section>
    </Tile>
    </AuthenticatedLayout>
</template>