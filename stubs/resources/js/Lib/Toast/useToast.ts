import bus from './ToastEventBus.js';

export function useToast() {
    return {
        add: (message) => {
            if (typeof message === 'string') {
                message = { message: message };
            }
            bus.emit('add', message);
        },
        remove: (message) => {
            bus.emit('remove', message);
        },
    }
}


// import { ref, computed } from 'vue'

// const active = ref(false)

// const toastOptions = ref({
//     body: '',
//     timeout: 2000,
// })

// let timeout = null

// export default () => {
//     const toast = (body, options) => {
//         if (active.value) {
//             clearTimeout(timeout)
//         }
//         toastOptions.value = {...toastOptions.value, ...options}

//         toastOptions.value.body = body
//         active.value = true

//         timeout = setTimeout(() => {
//             clear()
//         }, toastOptions.value.timeout)
//     }

//     const clear = () => {
//         active.value = false
//     }

//     const hide = () => {
//         clearInterval(timeout)
//         clear()
//     }

//     return {
//         toast,
//         active,
//         hide,
//         body: computed(() => toastOptions.value.body),
//     }
// }
