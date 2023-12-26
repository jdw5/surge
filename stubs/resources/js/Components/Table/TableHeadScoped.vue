<template>
    <th scope="colgroup" :colspan="colspan" class="relative isolate py-2 font-semibold">
        <slot />
    </th>
</template>

<script setup>
defineProps({
    colspan: {
        type: Number,
        default: 1,
    },
})
</script>