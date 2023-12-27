<template>
    <nav class="isolate inline-flex justify-between rounded-md w-full space-x-4" aria-label="pagination">
        <Previous :href="links.prev_page_url"/>
        <div class="flex">
            <Page v-for="link in middleLinks" :key="link.label" :page="link"/>
        </div>
        <Next :href="links.next_page_url"/>
    </nav>
</template>
  
<script setup lang="ts">
import { computed } from 'vue';
import Page from './Page.vue';
import Next from './Next.vue';
import Previous from './Previous.vue';

const props = defineProps<{
    links: any
}>()

const middleLinks = computed(() => {
    return props.links.links.slice(1, -1);
})
</script>