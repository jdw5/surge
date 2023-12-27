<template>
    <Combobox 
		as="div"
		:value="modelValue" 
		:disabled="disabled" 
		@update:model-value="$emit('update:modelValue', $event)" 
	>	
		<slot />
		<div class="relative">
			<ComboboxInput 
				class="w-full rounded border-0 bg-surface py-1.5 pl-3 pr-10 text-on-surface 
					shadow-sm ring-1 ring-inset ring-muted focus:ring-2 focus:ring-inset 
					focus:ring-primary sm:text-sm sm:leading-6
					disabled:cursor-not-allowed disabled:bg-gray-50 disabled:opacity/50 disabled:ring-gray-200" 
				:display-value="(item) => displayAs(item)" 
				@change="comboboxQuery = $event.target.value" 
			/>
			<ComboboxButton 
				class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none disabled:cursor-not-allowed"
			>
				<svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
				</svg>
			</ComboboxButton>
	
			<ComboboxOptions 
				v-if="filteredItems.length > 0"
				:ref="setComboboxButtonRef"
				class="absolute z-10 max-h-60 w-full overflow-auto rounded-md bg-surface py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
				:class="comboBoxPosition"
			>
					<ComboboxItem 
						v-for="(item, index) in filteredItems" 
						:key="index"
						:value="valueAs(item)"
					>
						{{ itemAs(item) }}
					</ComboboxItem>
			</ComboboxOptions>
		</div>
    </Combobox>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import {
	Combobox,
	ComboboxButton,
	ComboboxInput,
	ComboboxOptions,
} from '@headlessui/vue'
import ComboboxItem from './ComboboxItem.vue'
import { defaultSearchBy } from './comboboxFilters'

interface Props {
	modelValue: any,
	items: any[],
	disabled: boolean,
	displayAs: (item: any) => string,
	itemAs: (item: any) => string,
	valueAs: (item: any) => string,
	searchField?: string,
}

const props = withDefaults(defineProps<Props>(), {
	displayAs: (item: any) => item,
	itemAs: (item: any) => item,
	searchField: undefined,
	valueAs: (item: any) => item,
})

const emit = defineEmits(['update:modelValue']);

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
	return undefined
})

const setComboboxButtonRef = (el) => {
    if (el) {
        combobox.value = el;
    }
};

const filteredItems = computed(() => {
	return comboboxQuery.value === ''
		? props.items
		: props.items.filter((item) => {
			return defaultSearchBy(item, comboboxQuery.value, props.searchField)
		})
})
</script>