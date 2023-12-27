<template>
    <ComboboxOption :value="value" as="template" v-slot="{ active, selected }">
        <li :class="active ? 'bg-indigo-600 text-white' : 'text-gray-900'"
            class="relative cursor-default select-none py-2 pl-3 pr-9"
        >
            <span class="block truncate" :class="selected && 'font-semibold'">
                <slot>
                    {{ value }}
                </slot>
            </span>

            <span v-if="selected" 
                class="absolute inset-y-0 right-0 flex items-center pr-4"
                :class="active ? 'text-white' : 'text-indigo-600'"
            >
                <svg class="h-5 w-5" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.5 12.75l6 6 9-13.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
        </li>
    </ComboboxOption>
</template>

<script setup lang="ts">
import { ComboboxOption } from '@headlessui/vue';

defineProps<{
    value: any
}>()

</script>