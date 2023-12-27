<template>
    <PopoverRoot>
        <PopoverTrigger
            class="cursor-default outline-none"
            :aria-label="label"
        >
            <input type="hidden" />
            <TextInput :modelValue="modelValue" @update:modelValue="$emit('update:modelValue', $event)" />
        </PopoverTrigger>
        <!-- <transition
            enter-active-class="transition duration-500 ease-in-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-500 ease-in-out"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >    -->
        <PopoverPortal>
            <PopoverContent
                :side="side"
                :side-offset="offset"
                class="rounded p-4 max-w-xs bg-white 
                    shadow focus:shadow will-change-[transform,opacity] 
                    data-[state=open]:data-[side=top]:animate-slideDownAndFade 
                    data-[state=open]:data-[side=right]:animate-slideLeftAndFade data-[state=open]:data-[side=bottom]:animate-slideUpAndFade data-[state=open]:data-[side=left]:animate-slideRightAndFade"
            >
                <Calendar :modelValue="modelValue" @update:modelValue="$emit('update:modelValue', $event)" />
            </PopoverContent>
        </PopoverPortal>
        <!-- </transition>  -->
    </PopoverRoot>
</template>

<script setup>
import { ref } from 'vue';
import Calendar from './Calendar.vue';
import TextInput from '@/UI/TextInput.vue';
import { 
    PopoverContent, 
    PopoverPortal, 
    PopoverRoot, 
    PopoverTrigger 
} from 'radix-vue'

const props = defineProps({
    modelValue: {
        type: [String, Date],
        required: true
    },
    label: {
        type: String,
        default: 'Select date',
    },
    side: {
        type: String,
        default: 'bottom',
        required: false,
    },
    offset: {
        type: Number,
        default: 0,
        required: false,
    },
})
</script>