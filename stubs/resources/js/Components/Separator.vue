<template>
    <div 
        :data-orientation="orientation"
        role="separator" 
        class="bg-muted my-2
            data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full 
            data-[orientation=vertical]:h-full data-[orientation=vertical]:w-px" />
</template>

<script setup lang="ts">

withDefaults(defineProps<{
    orientation: 'horizontal' | 'vertical'
}>(), {
    orientation: 'horizontal',
})
</script>