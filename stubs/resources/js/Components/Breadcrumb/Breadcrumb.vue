<template>
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-2">
            <li>
                <div>
                    <Link href="#" class="text-muted hover:text-muted-hover">
                        <svg class="h-5 w-5 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p class="sr-only">Home</p>
                    </Link>
                </div>
            </li>
            <BreadcrumbItem v-for="link in links" :key="link.href" :link="link"/>
        </ol>
    </nav>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import BreadcrumbItem from './BreadcrumbItem.vue';

withDefaults(defineProps<{
    links?: Array<{
        href: string,
        text: string
    }>
}>(), {
    links: []
})


</script>