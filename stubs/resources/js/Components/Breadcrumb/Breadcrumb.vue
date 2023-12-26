<template>
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <div>
                    <Link :href="route('site.home.index')" class="text-muted hover:text-muted-hover">
                        <svg class="h-5 w-5 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p class="sr-only">Home</p>
                    </Link>
                </div>
            </li>
            <li v-for="page in pages" :key="page.name">
                <div class="flex items-center">
                    <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                    </svg>
                    <Link :href="page.href" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" 
                        :aria-current="page.current ? 'page' : undefined">
                        {{ page.name }}
                    </Link>
                </div>
            </li>
        </ol>
    </nav>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  defineProps({
    home: {
        type: String,
        default: '#'
    },
    pages: {
        type: Array,
        default: () => []
    }
  })
  
  </script>