<template>
    <div>
        <p class="text-sm text-on-surface">
            Showing
            {{ ' ' }}
            <span class="font-medium">
                {{ from }}
            </span>
            {{ ' ' }}
            to
            {{ ' ' }}
            <span class="font-medium">
                {{ to }}
            </span>
            {{ ' ' }}
            of
            {{ ' ' }}
            <span class="font-medium">
                {{ total }}
            </span>
            {{ ' ' }}
            results
        </p>
    </div>
</template>

<script setup>
defineProps({
    from: {
        type: Number,
        required: true
    },
    to: {
        type: Number,
        required: true
    },
    total: {
        type: Number,
        required: true
    }
})
</script>