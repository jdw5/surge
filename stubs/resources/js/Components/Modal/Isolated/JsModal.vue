<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-20" @close="close">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>
    
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" 
                        enter="ease-out duration-300" 
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                        enter-to="opacity-100 translate-y-0 sm:scale-100" 
                        leave="ease-in duration-200" 
                        leave-from="opacity-100 translate-y-0 sm:scale-100" 
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
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
import { 
    Dialog, 
    DialogPanel, 
    TransitionChild, 
    TransitionRoot 
} from '@headlessui/vue'

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
})

const close = () => {
    emit('close', false)
}

const emit = defineEmits(['close'])
</script>