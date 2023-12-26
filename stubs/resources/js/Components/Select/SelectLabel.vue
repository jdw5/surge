<template>
    <ListboxLabel :as="FormLabel">
        <slot />
    </ListboxLabel>
</template>

<script setup lang="ts">
import FormLabel from '../Form/FormLabel.vue';
import { ListboxLabel } from '@headlessui/vue';
</script>