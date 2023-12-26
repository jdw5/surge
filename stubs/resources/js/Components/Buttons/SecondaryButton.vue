<template>
    <BaseButton :as="as" class="text-on-surface hover:bg-on-surface-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-opacity-75">
        <slot />
    </BaseButton>
</template>

<script setup>
import BaseButton from './BaseButton.vue';

defineProps({
    as: {
        type: [String, Object],
        default: 'button',
    }
})
</script>