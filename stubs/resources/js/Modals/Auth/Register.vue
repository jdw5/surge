<template>
    <Head title="Create an account"/>
    <Modal>
        <h2 class="text-center text-2xl font-bold font-mono text-gray-900">
            Create an account
        </h2>
        <form @submit.prevent="form.post('/register')" class="mt-6 space-y-4">
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
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue'
import { Head, useForm } from '@inertiajs/vue3'
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

</script>