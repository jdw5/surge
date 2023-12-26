<template>
    <div :data-orientation="orientation"
        role="separator" 
        class="bg-accent my-2
            data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full 
            data-[orientation=vertical]:h-full data-[orientation=vertical]:w-px" />
</template>

<script setup>
defineProps({
    orientation: {
        type: String,
        default: 'horizontal',
        validator: (value) => {
            return ['horizontal', 'vertical'].includes(value);
        },
    },
})
</script>