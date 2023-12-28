<template>
    <DialogTitle as="h3" class="text-lg md:text-xl font-semibold leading-5 text-primary border-b border-primary p-4">
        <slot />
    </DialogTitle>
</template>

<script setup>
import { DialogTitle } from '@headlessui/vue';
</script>