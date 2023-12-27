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
