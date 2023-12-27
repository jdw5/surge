<template>
    <div class="relative w-fit" @mouseenter="onMouseenter" @mouseleave="onMouseleave">
        <component ref="driver"
            :is="as" 
            :aria-describedby="id"
        >
            <slot />
        </component>
        <transition 
            enter-active-class="transition ease-out duration-200" 
            enter-from-class="opacity-0 translate-y-1" 
            enter-to-class="opacity-100 translate-y-0" 
            leave-active-class="transition ease-in duration-150" 
            leave-from-class="opacity-100 translate-y-0" 
            leave-to-class="opacity-0 translate-y-1"
        >
            <div
                :id="id"
                class="fixed z-10" 
                role="tooltip"
                :style="position"
            >
                <div class="relative p-1">

                    <div class="absolute"
                        :style="arrowPosition"
                    >

                        <svg v-if="arrow" 
                            aria-hidden="true" 
                            class="h-3 w-3 text-gray-900 self-center" 
                            :style="arrowRotation"
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 24 24"
                        >
                            <path fill="currentColor" d="M1 21h22L12 2"/>
                        </svg>
                    </div>

                    <div class="w-full max-w-48 text-center rounded bg-gray-900 text-gray-50 px-2 py-1 text-sm overflow-hidden">
                        <slot name="content">
                            {{ tooltip }}
                        </slot>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref, onBeforeUnmount } from 'vue'
import useId from '@/Lib/useId'

const props = withDefaults(
    defineProps<{
        position: 'top' | 'bottom' | 'left' | 'right',
        as: any,
        arrow: boolean,
        delay: number,
        tooltip?: string
    }>(),
    {
        as: 'div',
        position: 'bottom',
        arrow: true,
        delay: 500
    }
)

const onMouseenter = () => {
    console.log('In')
    setTimeout(() => {
        show.value = true;
    }, props.delay);
}

const onMouseleave = () => {
    console.log('Out')
    show.value = false;
}

const onEscape = (e: KeyboardEvent) => {
    if (show.value && e.key === 'Escape') {
        show.value = false
    }
}

onMounted(() => {
    window.addEventListener('keydown', onEscape)
})

onBeforeUnmount(() => {
    window.removeEventListener('keydown', onEscape)
})

const show = ref(false);
const id = useId();
const driver = ref()

const position = computed(() => {
    if (driver.value) {
        const rect = driver.value.getBoundingClientRect()
        console.log(rect)
        switch (props.position) {
            case 'top':
                return 'top: ' + (rect.top) + 'px; left: ' + (rect.left + (rect.width / 2)) + 'px; transform: translate(-50%, -100%);'
            case 'bottom':
                return 'top: ' + (rect.bottom) + 'px; left: ' + (rect.left + (rect.width / 2)) + 'px; transform: translateX(-50%);'
            case 'left':
                return 'top: ' + (rect.top + (rect.height / 2)) + 'px; left: ' + (rect.left) + 'px; transform: translate(-100%, -50%);'
            case 'right':
                return 'top: ' + (rect.top + (rect.height / 2)) + 'px; left: ' + (rect.right) + 'px; transform: translateY(-50%);'
        }
    }
})

const arrowRotation = computed(() => {
    switch (props.position) {
        case 'top':
            return 'transform: rotate(180deg)'
        case 'bottom':
            return 'transform: rotate(0deg)'
        case 'left':
            return 'transform: rotate(90deg)'
        case 'right':
            return 'transform: rotate(-90deg)'
    }
})

const arrowPosition = computed(() => {
    switch (props.position) {
        case 'top':
            return 'bottom: -5px; left: 50%; transform: translateX(-50%);'
        case 'bottom':
            return 'top: -5px; left: 50%; transform: translateX(-50%);'
        case 'left':
            return 'right: -5px'
        case 'right':
            return 'left: -5px'
    }
})

</script>