<template>
    <button @click="toggleDark">        
        <span class="ml-2">{{ isDark ? 'Dark' : 'Light' }}</span>
    </button>
</template>

<script setup lang="ts">
import { useDark, useToggle } from '@vueuse/core'

const isDark = useDark()
const toggleDark = () => {
    useToggle(isDark)
}
</script>