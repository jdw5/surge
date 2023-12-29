import useId from '@/Lib/useId';
import bus from './ToastBus';
import { ref, computed } from 'vue'

const toastOptions = ref({
    id: null,
    type: null, // success, error, warning, info, none
    body: '',
    timeout: 2000,
})

export default () => {
    const toast = (body: string, options: any) => {
        toastOptions.value = {...toastOptions.value, ...options}
        toastOptions.value.id = useId()
        toastOptions.value.body = body
        bus.emit('add', toastOptions.value)

        setTimeout(() => {
            bus.emit('remove', toastOptions.value.id)
        }, toastOptions.value.timeout)
    }

    return {
        toast,
        body: computed(() => toastOptions.value.body),
    }
}
