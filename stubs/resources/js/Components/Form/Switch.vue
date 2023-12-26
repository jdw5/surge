<template>
    <Switch v-model="proxy"
        class="'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2'"
        :class="[modelValue ? 'bg-primary' : 'bg-muted']">
        <span v-if="label" class="sr-only">
            {{ label }}
        </span>
        <span aria-hidden="true" :class="[modelValue ? 'translate-x-5' : 'translate-x-0']"
            class="'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-surface shadow ring-0 transition duration-200 ease-in-out'"
        />
    </Switch>
</template>
  
<script setup>
import { computed } from 'vue'
import { Switch } from '@headlessui/vue'

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true,
    },
    label: {
        type: String,
        default: null
    },
})

const emit = defineEmits(['update:modelValue'])

const proxy = computed({
    get() {
        return props.modelValue;
    },

    set(val) {
        emit('update:modelValue', val);
    },
});
</script>