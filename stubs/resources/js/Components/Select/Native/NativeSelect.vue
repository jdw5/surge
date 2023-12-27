<template>

    <select 
        :value="modelValue"
        class="block w-full py-2 pl-3 pr-8 mt-1 text-base border-muted rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <slot />
    </select>
</template>

<script setup lang="ts">
defineProps<{
    modelValue: any,
}>()

defineEmits<{
    (e: 'update:modelValue', value: any): void
}>()

</script>