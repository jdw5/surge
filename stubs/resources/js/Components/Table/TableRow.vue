<template>
    <tr :class="{'odd:bg-muted/50': striped}">
        <slot />
    </tr>
</template>

<script setup>
defineProps({
    striped: {
        type: Boolean,
        default: false,
    },
})
</script>
