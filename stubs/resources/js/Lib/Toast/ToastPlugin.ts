import { router, usePage } from '@inertiajs/vue3'
import useToast from './useToast'

const { toast } = useToast()

export default () => {
    router.on('finish', () => {
        let data: any = usePage().props.toast
        if (data) {
            toast(data, {
                timeout: 2000,
            })
        }
    })
}