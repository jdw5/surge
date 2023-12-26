<template>
    <textarea ref="textarea"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :rows="rows" 
        class="
            block w-full rounded-md border-0 py-1.5 text-gray-700 shadow-sm ring-1 ring-gray-300 sm:text-sm sm:leading-6
            placeholder:text-gray-400 
            focus:ring-2 focus:ring-inset focus:ring-indigo-600 
            invalid:text-red-900 invalid:ring-red-300 invalid:placeholder:text-red-300 invalid:focus:ring-2 invalid:focus:ring-red-500 
            disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 disabled:ring-gray-200
        "
    />
</template>

<script setup>
import { ref, onMounted } from 'vue';
defineProps({
    modelValue: {
        type: String,
    },
    rows: {
        type: Number,
        default: 4,
    },
})

defineEmits(['update:modelValue']);

const textarea = ref()

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

defineExpose({ focus: () => textarea.value.focus() });

</script>


  