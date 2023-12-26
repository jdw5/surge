<template>
    <Head title="Setup two factor authentication"/>
    <Modal>
        <h2 class="text-center text-2xl font-bold font-mono text-gray-900">
            Setup two factor authentication
        </h2>
        <form class="mt-6 space-y-4" @submit.prevent="submit">
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
    </Modal>
</template>

<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { Head, useForm, Link, router } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';

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