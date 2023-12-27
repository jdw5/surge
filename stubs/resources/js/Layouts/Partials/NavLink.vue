<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string;
    active: boolean;
}>()


const classes = computed(() =>
    props.active
        ? 'text-primary-active focus:outline-none focus:border-primary-active'
        : 'text-on-surface dark:text-on-surfaceDark hover:text-primary dark:hover:text-primary focus:outline-none focus:text-primary focus:border-primary'
);
</script>

<template>
    <Link 
        :href="href" 
        class="inline-flex group flex-col items-center justify-center px-1 pt-1 text-sm font-medium leading-5 transition-colors duration-150 ease-in-out"
        :class="classes"
    >
        <slot />
        <div :class="active ? 'bg-primary-active' : 'bg-transparent group-hover:bg-primary'" class="w-1 h-1 mt-0.5 transition-colors duration-150 ease-in-out"></div>
    </Link>
</template>
