<template>
    <Head title="Create an account"/>
    <Modal>
        <ModalBody>
            <ModalHeader>
                Create an account
            </ModalHeader>
            <form @submit.prevent="form.post('/register')" class="space-y-4 p-4">
                <div>
                    <FormLabel for="name">
                        Name
                    </FormLabel>
                    <div class="mt-2">

                        <FormInput id="name" type="text"
                            v-model="form.name"
                            required
                        />
                        <FormError :error="form.errors.name" />
                    </div>
                </div>
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
                <div>
                    <FormLabel for="password_confirmation">
                        Confirm Password
                    </FormLabel>
                    <div class="mt-2">

                        <FormInput id="password_confirmation" 
                            type="password"
                            v-model="form.password_confirmation"
                            required
                        />
                    </div>
                </div>
                <div class="">
                    <button type="submit" :disabled="form.processing"
                        class="flex w-full justify-center bg-blue-500 disabled:opacity-50 px-3 py-2 text-sm text-semibold text-white">
                        Create account
                    </button>
                </div>

            </form>           
        </ModalBody>
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal/Modal.vue'
import ModalHeader from '@/Components/Modal/ModalHeader.vue'
import ModalBody from '@/Components/Modal/ModalBody.vue'
import { Head, useForm } from '@inertiajs/vue3'
import FormLabel from '@/Components/Form/FormLabel.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormError from '@/Components/Form/FormError.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

</script>