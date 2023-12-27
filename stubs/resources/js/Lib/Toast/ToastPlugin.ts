import { router, usePage } from '@inertiajs/vue3'
import useToast from '@/Composables/useToast'

const { toast } = useToast()

export default () => {
    console.log('Hello')
    router.on('finish', () => {
        let body = usePage().props.toast

        if (body) {
            toast(body, {
                timeout: 2000,
            })
        }

    })
}