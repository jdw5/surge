<template>
    <input v-model="proxy"
        :id="id" 
        :aria-describedby="ariaDescribedBy" 
        type="checkbox" 
        class="h-4 w-4 rounded border-muted text-primary focus:ring-primary disabled:opacity-50" 
        :disabled="disabled"
    />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [Boolean, Array],
        required: true
    },
    id: {
        type: String,
        default: null,
    },
    ariaDescribedBy: {
        type: String,
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['update:modelValue']);

const proxy = computed({
    get() {
        return props.modelValue;
    },
    set(val) {
        emit('update:modelValue', val);
    },
});
</script>
