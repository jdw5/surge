<template>
    <td class="whitespace-nowrap px-3 py-4 first:pl-4 last:pr-4 text-sm text-gray-500 sm:table-cell"
        :class="hidden"
    >
        <slot />
    </td>
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