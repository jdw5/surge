<template>
    <div class="flex items-start justify-between space-x-3">
        <div class="space-y-1">
            <DialogTitle class="text-base font-semibold leading-6 text-on-surface dark:text-on-surface-dark">
                <slot />
            </DialogTitle>
            <p v-if="$slots.description" class="text-sm text-muted">
                <slot name="description" />
            </p>
        </div>
        <slot name="actions" />
    </div>
</template>

<script setup lang="ts">
import { DialogTitle } from '@headlessui/vue'
</script>