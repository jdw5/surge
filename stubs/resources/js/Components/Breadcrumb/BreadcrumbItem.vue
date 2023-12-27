<template>
    <li>
        <div class="flex items-center">
            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
            </svg>
            <Link 
                :href="link.href" 
                class="ml-2 text-sm font-medium text-muted hover:text-muted-hover" 
                :aria-current="route().current(link.href) ? 'page' : undefined"
            >
                {{ link.name }}
            </Link>
        </div>
    </li>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
defineProps<{
    link: {
        href: string,
        name: string
    }
}>()

</script>