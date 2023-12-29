<template>
    <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
        <div class="p-4">
            <div class="flex items-start">
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">
                        {{ toast }}
                    </p>
                    <!-- <p class="mt-1 text-sm text-gray-500">
                        {{ message.message }}
                    </p> -->
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" @click="remove" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">
                            Close
                        </span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script setup>
const props = defineProps({
    toast: {
        type: Object,
        required: true,
    }
})

const emit = defineEmits(['remove'])

const remove = () => {
    emit('remove', props.toast.id);
}
</script>