<template>
    <p v-if="error" class="text-sm text-error font-regular">
        {{ error }}
    </p>
</template>

<script setup lang="ts">
defineProps<{ error?: string }>()


</script>