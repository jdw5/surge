<template>
    <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-xl">
        <slot />
    </DialogPanel>
</template>

<script setup>
import { DialogPanel } from '@headlessui/vue';
</script>