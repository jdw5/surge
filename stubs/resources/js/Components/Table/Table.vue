<template>
    <table class="min-w-full divide-y divide-accent">
        <thead>
            <slot name="head"/>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-surface">
            <slot name="body" />
        </tbody>
    </table>
</template>

<script setup>

</script>