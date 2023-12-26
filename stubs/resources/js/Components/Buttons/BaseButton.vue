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
    <component :is="as" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium transition">
        <slot />
    </component>
</template>
