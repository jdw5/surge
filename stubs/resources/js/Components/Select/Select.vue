<template>
    <Listbox 
        as="div" 
        :value="modelValue" 
        :disabled="disabled" 
        :multiple="multiple"
        @update:model-value="$emit('update:modelValue', $event)" 
    >
        <slot name="label" />
        <div class="relative">
            <slot name="trigger">
                <ListboxButton 
                    v-slot="{ open, value }"
                    class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset 
                        ring-gray-300 focus:outline-none focus:ring-2 focus:ring-primary sm:text-sm sm:leading-6
                        disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 disabled:ring-gray-200"
                >
                    <span class="block truncate">
                        {{ displayBy(value) }}
                    </span>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                        <svg 
                            class="w-4 h-4 transition-transform duration-150 ease-in-out" 
                            :class="{'-rotate-90' : open}" 
                            aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" 
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M19.5 8.25l-7.5 7.5-7.5-7.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </ListboxButton>
            </slot>
    
            <transition 
                leave-active-class="transition ease-in duration-100" 
                leave-from-class="opacity-100" 
                leave-to-class="opacity-0"
            >
                <ListboxOptions 
                    :ref="setListboxButtonRef"
                    class="absolute z-10 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm w-full max-w-48 w-64"
                    :class="listBoxPosition"
                >
                    <slot />
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
  
<script setup lang="ts">
import { computed, ref, Ref } from 'vue'
import { 
    Listbox, 
    ListboxOptions,
    ListboxButton
} from '@headlessui/vue'

const emit = defineEmits<{
    (e: 'update:modelValue', value: any): void
}>()

interface Props {
    modelValue: any,
    disabled: boolean,
    multiple?: boolean,
    displayBy?: (item: any) => string,
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
    multiple: false,
    displayBy: () => 'Select an option'
})

const select: Ref<any> = ref()

const listBoxPosition = computed<string|null>(() => {
    if (select.value && select.value.el) {
        const H = 2*window.innerHeight / 3
        const W = 2*window.innerWidth / 3
        const top = select.value.el.getBoundingClientRect().top
        const left = select.value.el.getBoundingClientRect().left

        if (H >= top && W < left) {
            return 'mt-1 right-0'
        } else if (H < top && W >= left) {
            return '-top-2 left-0 -translate-y-full'
        } else if (H < top && W < left) {
            return '-top-2 right-0 -translate-y-full'
        }
        return 'mt-1 left-0'
    }
    return null
})

const setListboxButtonRef = (el: HTMLElement|null) => {
    if (el) {
        select.value = el;
    }
};
</script>