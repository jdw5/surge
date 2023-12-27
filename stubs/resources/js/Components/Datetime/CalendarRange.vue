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
                <div @click="onClick(date)"
                    class="text-sm leading-loose text-center transition duration-100 ease-in-out cursor-pointer"
                    :class="cellClass(date)"
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
    from: {
        type: [String, Date, null],
        required: true
    },
    to: {
        type: [String, Date, null],
        required: true
    },
})

const emit = defineEmits(['update:from', 'update:to', 'change'])

const firstDateSelected = ref(null)
const secondDateSelected = ref(null)
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

    // if (today.toDateString() != now.toDateString()) {
    //     datepickerValue.value = new Date(year.value, month.value, today.getDate()).toDateString();
    // }
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

    return today.toDateString() === d.toDateString();
}

const isSelected = (day) => {
    const d = new Date(year.value, month.value, day);
    const f = new Date(firstDateSelected.value)
    const t = new Date(secondDateSelected.value)
    return f.toDateString() == d.toDateString() || t.toDateString() == d.toDateString();
}

const isBetween = (day) => {
    if (!firstDateSelected.value || !secondDateSelected.value) return false
    const d = new Date(year.value, month.value, day);
    const f = new Date(firstDateSelected.value)
    const t = new Date(secondDateSelected.value)
    return d > f && d < t;

}

const onClick = (date) => {
    let selectedDate = new Date(year.value, month.value, date);

    if (firstDateSelected.value == null) {
        console.log('FIRST IS NULL')
        firstDateSelected.value = selectedDate
        emit('update:from', firstDateSelected.value)

    } else if (selectedDate.toDateString() == firstDateSelected.value.toDateString()) {
        console.log('FIRST IS EQUAL')
        firstDateSelected.value = null
        emit('update:from', firstDateSelected.value)

    } else if (firstDateSelected.value != null && secondDateSelected.value == null && selectedDate > firstDateSelected.value) {
        console.log('SECOND IS NULL, AFTER FIRST')
        secondDateSelected.value = selectedDate
        emit('update:to', secondDateSelected.value)

    } else if (firstDateSelected.value != null && secondDateSelected.value == null) {
        console.log('SECOND IS NULL, NOT AFTER FIRST')
        secondDateSelected.value = firstDateSelected.value
        firstDateSelected.value = selectedDate
        emit('update:from', firstDateSelected.value)
        emit('update:to', secondDateSelected.value)

    } else if (selectedDate.toDateString() == secondDateSelected.value.toDateString()) {
        console.log('SECOND IS EQUAL')
        secondDateSelected.value = null
        emit('update:to', secondDateSelected.value)

    } else if (selectedDate < firstDateSelected.value) {
        console.log('BEFORE FIRST')
        firstDateSelected.value = selectedDate
        emit('update:from', firstDateSelected.value)

    } else if (selectedDate > secondDateSelected.value) {
        console.log('AFTER SECOND')
        secondDateSelected.value = selectedDate
        emit('update:to', secondDateSelected.value) 
    } else {
        console.log('BETWEEN FIRST AND SECOND')
        firstDateSelected.value = selectedDate
        emit('update:from', firstDateSelected.value)
    }
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

const cellClass = (date) => {
    console.log('run')
    if (isToday(date)) {
        return 'text-primary'
    }
    if (isSelected(date)) {
        return 'bg-primary text-on-primary'
    }
    else if (isBetween(date)) {
        return 'bg-primary/20'
    }

    return 'text-gray-500 hover:bg-primary/50'
}
</script>