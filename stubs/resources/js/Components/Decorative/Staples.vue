<template>
    <div class="flex gap-x-8">
        <div v-for="i in quantity" :key="i" class="h-16 w-8 bg-primary transform -skew-y-[30deg] rotate-[30deg] shadow" />
    </div>
</template>

<script setup>
const props = defineProps({
    quantity: {
        type: Number,
        default: 1
    }
})
</script>