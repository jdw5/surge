<template>
    <div aria-live="assertive" class="pointer-events-none fixed z-50 inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
        <div class="flex w-full flex-col items-center space-y-2 sm:items-end">
            <TransitionGroup move-class="transition ease-in-out duration-300" 
                leave-active-class="transition ease-in-out duration-300 absolute"
                enter-active-class="transition ease-in-out duration-300"
                leave-to-class="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="opacity-100 translate-y-0 sm:translate-x-0"
                leave-from-class="opacity-100 translate-y-0 sm:translate-x-0"
                enter-from-class="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
            >
                <Toast 
                    v-for="toast in toasts" 
                    :id="toast.id" 
                    :key="toast.id" 
                    :toast="toast"
                    @remove="remove"
                />
            </TransitionGroup>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import bus from '@/Lib/Toast/ToastBus';
import Toast from '@/Components/Toast/Toast.vue';

const toasts = ref([]);

const add = (toast) => {
    toasts.value = [...toasts.value, toast];
};

const remove = (id) => {
    const index = toasts.value.findIndex((m) => m.id === id);
    toasts.value.splice(index, 1);
}

onMounted(() => {
    bus.on('add', add);
    bus.on('remove', remove);
})

onUnmounted(() => {
    bus.off('add', add);
    bus.off('remove', remove);
})
</script>