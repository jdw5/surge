<script setup lang="ts">
withDefaults(
    defineProps<{
        as?: "a" | "button"
    }>(),
    {
        as: "button",
    }
)
</script>

<template>
    <component :is="as" class="inline-flex items-center justify-center p-1 rounded text-sm font-medium transition duration-150 ease-in-out disabled:opacity-50
        active:scale-105    
    ">
        <slot />
    </component>
</template>
