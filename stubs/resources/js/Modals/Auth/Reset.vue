<template>
    <Head title="Reset your password"/>
    <Modal v-slot="{ close }">
        <ModalHeader>
            Reset your password
        </ModalHeader>
        <ModalBody class="p-4">
            <form class="space-y-4" @submit.prevent="form.post(route('password.update'), { onSuccess: () => close })">
                <div>
                    <FormLabel for="email">
                        Email
                    </FormLabel>
                    <div class="mt-2">
                        <FormInput id="email" 
                            disabled
                            readonly
                            :value="form.email"
                            required
                        />
                    </div>
                </div>
    
                <div>
                    <FormLabel for="password">
                        Password
                    </FormLabel>
                    <div class="mt-2">
                        <FormInput id="password" 
                            type="password"
                            v-model="form.password"
                            required
                        />
                        <FormError :error="form.errors.password"/>
                    </div>
                </div>
    
                <div>
                    <FormLabel for="password_confirmation">
                        Confirm password
                    </FormLabel>
                    <div class="mt-2">
                        <FormInput id="password_confirmation" 
                            type="password"
                            v-model="form.password_confirmation"
                            required
                        />
                        <FormError :error="form.errors.password_confirmation"/>
                    </div>
                </div>
    
                <div>
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
import { Head, useForm, Link } from '@inertiajs/vue3'
import Modal from '@/Components/Modal/Modal.vue'
import ModalHeader from '@/Components/Modal/ModalHeader.vue'
import ModalBody from '@/Components/Modal/ModalBody.vue'
import FormLabel from '@/Components/Form/FormLabel.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormError from '@/Components/Form/FormError.vue';

const props = defineProps({
    email: {
        type: String,
        required: true
    },
    token: {
        type: String,
        required: true
    }
})

const form = useForm({
    email: props.email,
    token: props.token,
    password: '',
    password_confirmation: ''
})

</script>