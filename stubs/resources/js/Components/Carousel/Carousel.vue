<template>
    <div class="relative" aria-roledescription="carousel" role="region">
        <div class="overflow-hidden">
            <div 
                ref="container"
                class="flex w-fit" 
                style="transition: transform 0.3s ease;"
                :style="transform"
            >
                <slot />
            </div>
        </div>
        <div class="flex justify-between">
            <button @click="increment">
                Prev
            </button>
            <button @click="decrement">
                Next
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { provide, ref, onMounted, computed } from 'vue';

const active = ref(0) // Index

const container = ref()
const children = ref([])

const increment = () => {
    active.value = (active.value + 1) % children.value.length
}

const decrement = () => {
    if (active.value == 0) {
        active.value = children.value.length - 1
    } else {
        active.value = (active.value - 1)
    }
}

function setActive(index: number) {
  if (active.value == index) {
    active.value = -1
  } else {
    active.value = index
  }
}

onMounted(() => {
  children.value = Array.from(container.value.children)
})

provide('carousel-context', {
    active,
    setActive,
    peers: children,
})

const transform = computed(() => {
    if (active.value == -1) {
        return 'transform: translateX(0)'
    }

    return `transform: translateX(-${active.value * 100}%)`
    
})
</script>
