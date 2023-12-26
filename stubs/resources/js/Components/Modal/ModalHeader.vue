<template>
    <DialogTitle as="h3" class="text-base font-semibold leading-6 text-primary border-b border-primary p-4">
        <slot />
    </DialogTitle>
</template>

<script setup>
import { DialogTitle } from '@headlessui/vue';
</script>