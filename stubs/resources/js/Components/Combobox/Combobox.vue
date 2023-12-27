<template>
    <Combobox as="div" @update:modelValue="$emit('update:modelValue', $event)" 
		:value="modelValue" :disabled="disabled" :multiple="multiple">
		<slot name="label"/>
		<div class="relative">
			<ComboboxInput class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset 
				focus:ring-indigo-600 sm:text-sm sm:leading-6
				disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 disabled:ring-gray-200" 
				@change="comboboxQuery = $event.target.value" 
				:display-value="(item) => item[displayField]" 
			/>
			<ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none
				disabled:cursor-not-allowed"
			>
				<svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
				</svg>
			</ComboboxButton>
	
			<ComboboxOptions v-if="filteredItems.length > 0"
				class="absolute z-10 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
				:class="comboBoxPosition"
				:ref="setComboboxButtonRef"
			>
					<ComboboxItem v-for="(item, index) in filteredItems" 
						:key="index"
						:value="item"
					>
						{{ item[displayField] }}
					</ComboboxItem>
			</ComboboxOptions>
		</div>
    </Combobox>
</template>

<script setup>
import { computed, ref } from 'vue'
import {
	Combobox,
	ComboboxButton,
	ComboboxInput,
	ComboboxOptions,
} from '@headlessui/vue'
import ComboboxItem from './ComboboxItem.vue'

const props = defineProps({
	modelValue: {
		type: Object,
	},
	query: {
		type: [String, Number],
		default: null
	},
	items: {
		type: Array,
		required: true
	},
	disabled: {
		type: Boolean,
		default: false
	},
	multiple: {
		type: Boolean,
		default: false
	},
	displayField: {
		type: String,
		default: 'name'
	},
})

const comboboxQuery = ref('')
const combobox = ref()

const comboBoxPosition = computed(() => {
    if (combobox.value && combobox.value.el) {
        const H = 2*window.innerHeight / 3
        const W = 2*window.innerWidth / 3
        const top = combobox.value.el.getBoundingClientRect().top
        const left = combobox.value.el.getBoundingClientRect().left

        if (H >= top && W < left) {
            return 'mt-1 right-0'
        } else if (H < top && W >= left) {
            return '-top-2 left-0 -translate-y-full'
        } else if (H < top && W < left) {
            return '-top-2 right-0 -translate-y-full'
        }
        return 'mt-1 left-0'
    }
})

const setComboboxButtonRef = (el) => {
    if (el) {
        combobox.value = el;
    }
};

const emit = defineEmits(['update:modelValue']);

const filteredItems = computed(() =>
	comboboxQuery.value === ''
		? props.items
		: props.query ?
			props.items.filter((item) => {
				return item[props.query].toLowerCase().includes(comboboxQuery.value.toLowerCase())
			})
			: props.items.filter((item) => {
				return item.toLowerCase().includes(comboboxQuery.value.toLowerCase())
			})
)
</script>