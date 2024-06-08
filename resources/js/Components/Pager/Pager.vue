<script setup>
import PagerLink from '@/Components/Pager/PagerLink.vue';
import Tile from '../Tile.vue';

const props = defineProps(['lastPageUrl','firstPageUrl','links'])
</script>
<template>
    <Tile>
        <div class=" flex flex-wrap gap-2 items-center justify-center">
        <PagerLink :href="firstPageUrl" label="<<" />
        <PagerLink v-for="(link, index) in links" :key="index" :href="link.url" :active='link.active' :label='link.label' />
        <PagerLink :href="lastPageUrl" label=">>" />
         </div>   
        
    </Tile>
</template>