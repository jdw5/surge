<template>
    <component :is="as" :class="classes">
        <slot />
    </component>
</template>

<script setup>
import { computed } from 'vue';


const props = defineProps({
    as: {
        type: [String],
        default: 'h1',
        validator: (value) => {
            return ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'].includes(value);
        }
    }
})

const classes = computed(() => {
    switch (props.as) {
        case 'h1':
            return 'text-3xl font-bold text-on-surface';
        case 'h2':
            return 'text-2xl font-bold text-on-surface';
        case 'h3':
            return 'text-xl font-bold text-on-surface';
        case 'h4':
            return 'text-lg font-bold text-on-surface';
        case 'h5':
            return 'text-base font-bold text-on-surface';
        case 'h6':
            return 'text-sm font-bold text-on-surface';
        default: 
            return 'text-sm font-regular text-on-surface';
    }
})
</script>