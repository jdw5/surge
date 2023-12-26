<template>
    <div class="relative">
        <slot />
    </div>
</template>

<script setup>
import { ref } from 'vue'
const show = ref(false);

</script>