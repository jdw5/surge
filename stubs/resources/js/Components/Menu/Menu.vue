<template>
    <Menu 
        v-slot="{ open }" 
        ref="menu"
        as="div" 
        class="relative inline-block text-left" 
    >
        <div>
            <slot name="trigger" :open="open">
                <MenuButton>
                    <span 
                        class="inline-flex w-full items-center justify-center gap-x-4 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 
                            shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-gray-800
                            transition-colors ease-in-out duration-150"
                    >
                        {{ label }}
                        <svg class="w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.5 8.25l-7.5 7.5-7.5-7.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </MenuButton>
            </slot>
        </div>
  
        <teleport :to="useFixed ? 'body' : undefined">
            <transition 
                enter-active-class="transition ease-out duration-100" 
                enter-from-class="transform opacity-0 scale-95" 
                enter-to-class="transform opacity-100 scale-100" 
                leave-active-class="transition ease-in duration-75" 
                leave-from-class="transform opacity-100 scale-100" 
                leave-to-class="transform opacity-0 scale-95"
            >
                <MenuItems 
                    class="absolute overflow-hidden z-10 mt-1 py-0.5 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none -translate-x-full"
                    :style="style"
                >
                    <slot />
                </MenuItems>
            </transition>
        </teleport>
    </Menu>
</template>
  
<script setup lang="ts">
import { 
    Menu, 
    MenuButton, 
    MenuItems 
} from '@headlessui/vue'
import { onMounted, ref } from 'vue';

interface Props {
    label: string,
    useFixed?: boolean,
}

const props = withDefaults(defineProps<Props>(), {
    useFixed: false,
})

const menu = ref()
const style = ref('')

onMounted(() => {
    if (props.useFixed) {
        const left = menu.value.$el.getBoundingClientRect().right + window.scrollX
        const top = menu.value.$el.getBoundingClientRect().bottom + window.scrollY
        style.value = `top: ${top}px; left: ${left}px;`
    }
})
</script>