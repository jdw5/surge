<template>
    <Disclosure v-slot="{ open }" :defaultOpen="defaultOpen">
        <dt>
            <DisclosureButton class="flex w-full items-start justify-between text-left text-on-surface">
                <span class="text-base font-semibold leading-7 flex-grow">
                    <slot name="header" />
                </span>
                <span class="ml-6 flex h-7 items-center">
                    <slot name="actions">
                        <PlusIcon class="w-6 h-6 transition-transform ease-in-out duration-300" :class="{'rotate-[135deg]' : open}"/>
                    </slot>
                </span>
            </DisclosureButton>
        </dt>
        <transition enter-from-class='max-h-0'
            enter-active-class='overflow-hidden transition-all duration-300 ease-in-out'
            enter-to-class='max-h-48'
            leave-from-class='max-h-48'
            leave-active-class='overflow-hidden transition-all duration-300 ease-in-out'
            leave-to-class='max-h-0'
        >

            <DisclosurePanel as="dd" class="mt-2 pr-12">
                <p class="text-base leading-7 text-on-background">
                    <slot name="content"/>
                </p>
            </DisclosurePanel>
        </transition>
    </Disclosure>
</template>
  
<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline'
import { 
    Disclosure, 
    DisclosureButton, 
    DisclosurePanel 
} from '@headlessui/vue'

const props = defineProps({
    defaultOpen: {
        type: Boolean,
        default: false,
    },
})
</script>