<template>
    <tr :class="{'even:bg-gray-50': evens}">
        <slot />
    </tr>
</template>

<script setup>
defineProps({
    evens: {
        type: Boolean,
        default: false,
    },
})
</script>
