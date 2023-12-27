<template>
    <div 
        class="bg-surface shadow rounded-lg relative overflow-hidden"
        :class="{ 'p-8': pad }"
    >
        <slot />
    </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{
    pad?: boolean
}>(), {
    pad: false,
})
</script>