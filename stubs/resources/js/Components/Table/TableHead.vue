<template>
    <th scope="col" class="relative py-3.5 px-3 first:pl-4 last:pr-4 text-left text-sm font-semibold text-gray-700"
        :class="hidden"
    >
        <slot />
    </th>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    hiddenAt: {
        type: String,
        default: null,
        validator: (value) => {
            return ['sm', 'md', 'lg', 'xl', '2xl'].includes(value);
        },
    }
})

const hidden = computed(() => {
    if (props.hiddenAt) return `hidden ${props.hiddenAt}:table-cell`
})
</script>