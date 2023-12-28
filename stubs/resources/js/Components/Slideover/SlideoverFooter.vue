<template>
    <div class="flex h-full flex-col divide-y divide-gray-200 bg-surface shadow-xl">
        <div class="flex min-h-0 flex-1 flex-col overflow-y-scroll py-6">
            <div v-if="$slots.header" class="px-4 sm:px-6">
                <slot name="header" />
            </div>
            <SlideoverBody class="mt-4">
                <slot />
            </SlideoverBody >
        </div>
        <div class="flex flex-shrink-0 justify-end px-4 py-4">
            <slot name="footer"/>
        </div>
    </div>
</template>

<script setup lang="ts">
import SlideoverBody from './SlideoverBody.vue';
</script>