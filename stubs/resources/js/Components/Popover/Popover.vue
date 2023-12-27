<template>
    <Popover as="div" class="relative">
        <PopoverButton as="template">
            <slot name="trigger"/>
        </PopoverButton>
    
        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
            <PopoverPanel v-slot="{ open }" as="div">
                <slot name="panel" :open="open"/>
            </PopoverPanel>
        </transition>
    </Popover>
</template>
  
<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'

</script>