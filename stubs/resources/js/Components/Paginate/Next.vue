<template>
    <Link 
        :href="href" 
        class="relative inline-flex items-center border sm:border-o border-gray-300 sm:rounded-md sm:rounded-l-md px-4 sm:px-2 py-2 text-gray-700 sm:text-gray-400 
            hover:bg-gray-50 focus:z-20 focus:outline-offset-0 text-sm font-medium"
    >
        <span class="sm:sr-only">
            Next
        </span>
        <svg class="h-5 w-5 hidden sm:block" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.25 4.5l7.5 7.5-7.5 7.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
const props = defineProps<{
    href: string
}>()
</script>