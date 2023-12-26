<template>
    <label
        class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300"
        :class="{'sr-only' : hidden}"
    >
        <slot />
    </label>
</template>

<script setup>
defineProps({
    hidden: {
        type: Boolean,
        default: false,
    },
})
</script>