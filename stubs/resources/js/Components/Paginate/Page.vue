<template>
    <Link 
        :href="page.url" 
        class="first:rounded-l border-y border-l border-accent last:border-r last:rounded-r relative hidden sm:inline-flex items-center px-4 py-2 text-sm font-semibold text-on-surface hover:bg-background focus:z-20 focus:outline-offset-0"
        :class="{'z-10 text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': page.active}"
    >
        {{ page.label }}
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
defineProps<{
    page: any
}>()
</script>