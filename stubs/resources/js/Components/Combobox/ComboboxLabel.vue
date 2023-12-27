<template>
    <ComboboxLabel :as="FormLabel">
        <slot />
    </ComboboxLabel>
</template>

<script setup lang="ts">
import FormLabel from '../Form/FormLabel.vue';
import { ComboboxLabel } from '@headlessui/vue';
</script>