<script setup>
import Button from "primevue/button";
import Menu from "primevue/menu";
// import { BarsArrowDownIcon } from "@heroicons/vue/24/solid";
import { ref } from "vue";

const menu = ref();
const props = defineProps(['items'])


const toggle = (event) => {
    menu.value.toggle(event);
};
</script>
<template>
    <div class="card flex justify-content-center">
        <Button type="button" icon = 'pi pi-bars' icon-class="text-xl"   @click="toggle" aria-haspopup="true" aria-controls="overlay_menu" >
            <!-- <template #icon>
                <BarsArrowDownIcon class="w-8" />
            </template> -->
        </Button>
        <Menu ref="menu" id="overlay_menu" :model="items" :popup="true" />
    </div>
</template>