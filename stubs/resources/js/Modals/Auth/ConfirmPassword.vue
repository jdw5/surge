<template>
    <Head title="Confirm password"/>
    <Modal v-slot="{ close }">
        <h2 class="text-center text-2xl font-bold font-mono text-gray-900">
            Confirm password
        </h2>
        <form class="space-y-4" @submit.prevent="form.post(route('password.confirm'), { onSuccess: () => close })">
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
import { Head, useForm, Link } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';

const form = useForm({
    password: ''
})

</script>