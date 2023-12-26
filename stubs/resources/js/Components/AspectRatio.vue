<template>
    <div class="relative" :style="padding">
        <div class="absolute inset-0">
            <slot />
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    ratio: {
        type: Number,
        default: 16 / 9,
    },
})

const padding = computed(() => {
    return `padding-bottom: ${100 / props.ratio}%`
})
</script>