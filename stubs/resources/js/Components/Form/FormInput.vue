<template>
    <input ref="input" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)"
        class="
            block w-full rounded-md border-0 py-1.5 text-gray-700 shadow-sm ring-1 ring-gray-300 text-sm sm:leading-6
            placeholder:text-gray-400 
            focus:ring-2 focus:ring-inset focus:ring-primary
            invalid:text-red-900 invalid:ring-red-300 invalid:placeholder:text-red-300 invalid:focus:ring-2 invalid:focus:ring-red-500 
            disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 disabled:ring-gray-200
        "
    />
</template>

<script setup>
import { onMounted, ref } from 'vue';


defineProps({
    modelValue: {
        type: String,
    },
})

defineEmits(['update:modelValue']);

const input = ref()

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>