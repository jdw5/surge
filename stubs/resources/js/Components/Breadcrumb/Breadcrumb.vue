<template>
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <div>
                    <Link :href="route(home)" class="text-muted hover:text-muted-hover">
                        <svg class="h-5 w-5 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p class="sr-only">Home</p>
                    </Link>
                </div>
            </li>
            <BreadcrumbItem v-for="item in items" :key="item.href" :item="item"/>
        </ol>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import BreadcrumbItem from './BreadcrumbItem.vue';
defineProps({
    home: {
        type: String,
        default: '#'
    },
    items: {
        type: Array,
        default: () => []
    }
})

</script>