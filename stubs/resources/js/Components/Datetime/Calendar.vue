<template>
    <div>
        <div class="flex items-center justify-between">
            <div class="space-x-1">
                <span class="font-bold text-gray-700">
                    {{ month_names[month] }}
                </span>
                <span class="font-regular text-gray-500">
                    {{ year }}
                </span>
            </div>
            <div>
                <button type="button" class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer hover:bg-gray-200" 
                    @click.stop="decrementMonth(); getNoOfDays()"
                >
                    <span class="sr-only">Previous month</span>
                    <ChevronLeftIcon class="w-5 h-5 text-gray-500" />
                </button>
                <button type="button" class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer hover:bg-gray-200" 
                    @click.stop="incrementMonth(); getNoOfDays()"
                >
                    <span class="sr-only">Next month</span>
                    <ChevronRightIcon class="w-5 h-5 text-gray-500" />							  
                </button>
            </div>
        </div>

        <div class="flex">
            <div v-for="day in days" :key="day" class="px-1 w-[14.28%] text-xs font-medium text-center text-gray-700">
                {{ day }}
            </div>
        </div>

        <div class="flex flex-wrap">
            <div v-for="blankday in blankdays" 
                class="p-1 text-sm text-center w-[14.28%]"
            />
            <div v-for="date in no_of_days" :key="date" class="px-1 mb-1 w-[14.28%]">
                <div @click.stop="getDateValue(date)"
                    class="text-sm leading-loose text-center transition duration-100 ease-in-out cursor-pointer"
                    :class="{'bg-primary text-on-primary': isToday(date) == true, 'bg-secondary text-on-secondary': isSelected(date) == true, 'text-gray-500 hover:bg-blue-200': isToday(date) == false }"	
                > 
                    {{ date }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onBeforeMount, computed } from 'vue';
import { ChevronRightIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    modelValue: {
        type: [String, Date],
        required: true
    },
})

const emit = defineEmits(['update:modelValue', 'change'])

const datepickerValue = ref('')
const dateSelected = ref('')
const month = ref('')
const year = ref('')
const no_of_days = ref([])
const blankdays = ref([])
const days = ref(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'])
const month_names = ref(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])

onBeforeMount(() => {
    initDate()
    getNoOfDays()
})

const initDate = () => {
    let today = new Date();
    if (props.modelValue != null && props.modelValue != '' && props.modelValue != undefined) {
        today = new Date(props.modelValue);
    }

    month.value = today.getMonth();
    year.value = today.getFullYear();

    let now = new Date();

    if (today.toDateString() != now.toDateString()) {
        datepickerValue.value = new Date(year.value, month.value, today.getDate()).toDateString();
    }
}

const decrementMonth = () => {
    if(--month.value == -1) {
        month.value = 11
        year.value--
    }
}

const incrementMonth = () => {
    if (++month.value == 12) {
        month.value = 0
        year.value++
    }
}

const isToday = (date) => {
    const today = new Date();
    const d = new Date(year.value, month.value, date);

    return today.toDateString() === d.toDateString() ? true : false;
}

const isSelected = (date) => {
    const d = new Date(year.value, month.value, date);
    const s = new Date(dateSelected.value)
    return s.toDateString() === d.toDateString() ? true : false;
}      

const getDateValue = (date) => {
    let selectedDate = new Date(year.value, month.value, date);
    dateSelected.value = selectedDate
    datepickerValue.value = selectedDate.toDateString();

    emit('update:modelValue', datepickerValue.value)
    emit('change', selectedDate)
}

const getNoOfDays = () => {
    const daysInMonth = new Date(year.value, month.value + 1, 0).getDate();
    const dayOfWeek = new Date(year.value, month.value).getDay();
    let blankdaysArray = [];
    for (let i = 1; i <= dayOfWeek; i++) {
        blankdaysArray.push(i);
    }

    let daysArray = [];
    for (let i = 1; i <= daysInMonth; i++) {
        daysArray.push(i);
    }

    blankdays.value = blankdaysArray;
    no_of_days.value = daysArray;
}

const cellClass = computed(() => {
    if (isToday(date)) {
        return 'bg-primary text-ditaPrimaryText'
    }
    if (isSelected(date)) {
        return 'bg-ditaSecondary text-ditaSecondaryText'
    }
    return 'text-gray-500 hover:bg-blue-200'
})

</script>