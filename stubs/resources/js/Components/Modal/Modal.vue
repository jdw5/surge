<template>
    <TransitionRoot appear as="template" :show="show">
        <Dialog as="div" @close="close" class="relative z-50">
            <TransitionChild
                @after-leave="redirect"
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0 "
                enter-to="opacity-100"
                leave="ease-out duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            </TransitionChild>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center items-center sm:p-0">
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="ease-out duration-300"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="relative transform transition-all sm:my-8 w-full max-w-xl">
                            <slot :close="close" />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';
import { useModal } from 'momentum-modal';

const { show, close, redirect } = useModal()

</script>