<template>
    <MenuItem 
        v-slot="{ active }" 
        :as="is"
    >
        <div 
            :class="[active ? 'bg-primary/5 text-on-surface' : 'text-on-surface']" 
            class="block px-4 py-2 text-sm flex gap-x-2 items-center"
        >
            <slot />
        </div>
    </MenuItem>
</template>

<script setup lang="ts">
import { MenuItem } from '@headlessui/vue';

withDefaults(defineProps<{
    is?: string,
}>(), {
    is: 'div'
})

</script>