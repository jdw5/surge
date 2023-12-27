<template>
    <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
        <div class="flex w-full flex-col items-center space-y-2 sm:items-end">
            <TransitionGroup move-class="transition ease-in-out duration-300" 
                leave-active-class="transition ease-in-out duration-300 absolute"
                enter-active-class="transition ease-in-out duration-300"
                leave-to-class="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="opacity-100 translate-y-0 sm:translate-x-0"
                leave-from-class="opacity-100 translate-y-0 sm:translate-x-0"
                enter-from-class="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
            >
                <Toast :id="`toast_${message.id}`" v-for="message in messages" :key="message.id" :message="message" @remove="remove"/>
            </TransitionGroup>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import bus from './ToastEventBus.js';
import Toast from './Toast.vue';

let messageIdx = 0;

const emit = defineEmits(['close']);

const messages = ref([]);

const add = (message) => {
    if (message.id == null) {
        message.id = messageIdx++;
    }

    messages.value = [...messages.value, message];
};

const remove = (message) => {
    console.log(messages)
    let index = -1;

    for (let i = 0; i < messages.value.length; i++) {
        if (messages.value[i] === message) {
            index = i;
            break;
        }
    }

    messages.value.splice(index, 1);
    emit('close', message);
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