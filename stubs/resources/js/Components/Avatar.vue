<template>
    <div class="rounded-full overflow-hidden" :class="classes">
        <img :src="image" :alt="alt" class="h-full w-full"/>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    image: {
        type: String,
        required: true
    },
    alt: {
        type: String,
        required: true
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => {
            return ['sm', 'md', 'lg'].includes(value)
        }
    }
})

const classes = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'w-8 h-8'
        case 'md':
            return 'w-12 h-12'
        case 'lg':
            return 'w-16 h-16'
    }
})

</script>