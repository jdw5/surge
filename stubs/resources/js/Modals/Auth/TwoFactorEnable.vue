<template>
    <Head title="Setup two factor authentication"/>
    <Modal>
        <ModalHeader>
            Setup two factor authentication
        </ModalHeader>
        <ModalBody class="p-4">
            <form class="space-y-4" @submit.prevent="submit">
                <p class="text-sm text-gray-900">
                    To set up two factor authentication, scan the QR code with your authenticator application and enter the code below
                </p>
                <div v-html="qrCode" class="w-1/2 mx-auto" />
                <div>
                    <FormLabel for="code">
                        Code
                    </FormLabel>
                    <FormInput id="code" 
                        type="password"
                        v-model="form.code"
                        required
                    />
                    <FormError :error="form.errors.confirmTwoFactorAuthentication"></FormError>
                </div>
                <div class="">
                    <button type="submit" :disabled="form.processing"
                        class="flex w-full justify-center bg-blue-500 disabled:opacity-50 px-3 py-2 text-sm text-semibold text-white"
                    >
                        Continue
                    </button>
                </div>
    
            </form>        
        </ModalBody>
    </Modal>
</template>

<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { Head, useForm, Link, router } from '@inertiajs/vue3'
import Modal from '@/Components/Modal/Modal.vue'
import ModalHeader from '@/Components/Modal/ModalHeader.vue'
import ModalBody from '@/Components/Modal/ModalBody.vue'
import FormLabel from '@/Components/Form/FormLabel.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormError from '@/Components/Form/FormError.vue';

const qrCode = ref('')

onMounted(() => {
    axios.get(route('two-factor.qr-code')).then((response) => {
        qrCode.value = response.data.svg
    }).catch((error) =>{
        if (error.response.status === 423) {
            router.get(route('password.confirm'))
        }
    })
})

const form = useForm({
    code: ''
})

const submit = () => {
    form.post(route('two-factor.confirm'), {
        onSuccess: () => {
            router.get(route('account.security.index'))
        }
    })
}
</script>