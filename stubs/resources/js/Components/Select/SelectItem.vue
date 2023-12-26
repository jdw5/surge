<template>
    <ListboxOption 
        v-slot="{ active, selected }"
        as="template" 
        :value="value" 
    >
        <li 
            :class="active ? 'bg-primary text-on-primary' : 'text-on-surface'"
            class="relative cursor-default select-none py-2 pl-3 pr-8"
        >
            <span 
                :class="selected ? 'font-semibold' : 'font-normal'"
                class="block truncate"
            >
                <slot :selected="selected" :active="active"/>
            </span>

            <span 
                v-show="selected" 
                :class="active ? 'text-white' : 'text-primary'" 
                class="absolute inset-y-0 right-0 flex items-center pr-4"
            >
                <svg fill="none" class="w-5 h-5" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
            </span>
        </li>
    </ListboxOption>
</template>

<script setup lang="ts">
import { ListboxOption } from '@headlessui/vue';

defineProps<{
    value: any,
}>()


</script>