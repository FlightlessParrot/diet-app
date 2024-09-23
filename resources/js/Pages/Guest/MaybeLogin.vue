<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    specialist: {
        type: Object,
        required: true
    }
})

</script>
<template>
    <GuestLayout>
        <Head>
        <title>Dołącz do nas</title>
    </Head>
        <h1>Załóż konto, aby odblokować pełen potencjał naszej aplikacji</h1>
        <div class="md:flex gap-8 justify-between mt-6">
            <Link :href="route('guest.book.specialist',[specialist.id])">
                <SecondaryButton>Kontynuuj bez logowania</SecondaryButton>
            </Link>
            <Link :href="route('login')"> <PrimaryButton>Zaloguj się lub załóż konto</PrimaryButton></Link>
        </div>
    </GuestLayout>
</template>