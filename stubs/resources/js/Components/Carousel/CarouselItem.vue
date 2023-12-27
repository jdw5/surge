<template>
    <div 
        ref="container"
        role="group" 
        aria-roledescription="slide" 
        class="min-w-0 shrink-0 grow-0 basis-full pl-4"
    >
        <!-- :class="{
            '-translate-x-full': before,
            'translate-x-full': after,
        }" -->
        <div class="p-1">
            <slot />
            {{ index }}
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, provide, inject, ref } from "vue"

const container = ref()

const context: any = inject("carousel-context")

const index = computed(() => {
  return context.peers?.value ? context.peers.value.indexOf(container.value) : -1
})

const isActive = computed(() => index.value == context.active.value)
const before = computed(() => index.value < context.active.value)
const after = computed(() => index.value > context.active.value)

const toggle = () => context.setActive(index.value)
</script>

