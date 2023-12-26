<script lang="ts" setup>
defineProps<{ message?: string }>()
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-error font-regular">
            {{ message }}
        </p>
    </div>
</template>
