<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild 
                as="template" 
                enter="ease-in-out duration-500" 
                enter-from="opacity-0" 
                enter-to="opacity-100" 
                leave="ease-in-out duration-500" 
                leave-from="opacity-100" 
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>
            
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 flex max-w-full" 
                        :class="isRight ? 'pl-10 right-0' : 'pr-10 left-0'"
                    >
                        <TransitionChild 
                            as="template" 
                            enter="transform transition ease-in-out duration-500 sm:duration-700" 
                            :enter-from="isRight ? 'translate-x-full' : '-translate-x-full'"
                            enter-to="translate-x-0" 
                            leave="transform transition ease-in-out duration-500 sm:duration-700" 
                            leave-from="translate-x-0" 
                            :leave-to="isRight ? 'translate-x-full' : '-translate-x-full'"
                        >
                            <DialogPanel class="pointer-events-auto relative w-screen max-w-md">
                                <div class="flex h-full flex-col overflow-y-scroll bg-surface shadow-xl">
                                    <div class="px-4 sm:px-6">
                                        <DialogTitle class="text-base font-semibold leading-6 text-gray-900">
                                            Panel title
                                        </DialogTitle>
                                    </div>
                                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                        <slot />
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = withDefaults(
    defineProps<{
        side?: 'left' | 'right'
    }>(),
    {
        side: 'left'
    }
)

const isRight = computed(() => props.side === 'right')

const open = defineModel()

const close = () => {
    open.value = false
}
</script>