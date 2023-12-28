<template>
    <Head title="Sign in"/>
    <Modal>
        <ModalBody>
            <ModalHeader>
                Sign in
            </ModalHeader>
            <form @submit.prevent="form.post('/login')" class="space-y-4 p-4">
                <div>
                    <FormLabel for="email">
                        Email
                    </FormLabel>
                    <div class="mt-2">

                        <FormInput id="email" 
                            v-model="form.email"
                            required
                        />
                        <FormError :error="form.errors.email"/>
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
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" 
                            v-model="form.remember"
                            class="w-4 h-4 text-blue-500 focus:ring-blue-500"
                        >
                        <FormLabel for="remember" class="block ml-2">
                            Remember me
                        </FormLabel>
                    </div>
                    <div>
                        <Link :href="route('auth.recover')" class="text-sm text-blue-500 font-semibold">
                            Forgot your password?
                        </Link>
                    </div>
                </div>
                <div class="">
                    <button type="submit" :disabled="form.processing"
                        class="flex w-full justify-center bg-blue-500 disabled:opacity-50 px-3 py-2 text-sm text-semibold text-white"
                    >
                        Sign in
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

const form = useForm({
    email: '',
    password: '',
    remember: false
})

</script>