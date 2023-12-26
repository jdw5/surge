<template>
    <Head title="Verify your email"/>
    <Modal v-slot="{ close }">
        <h2 class="text-center text-2xl font-bold font-mono text-gray-900">
            Verify your email
        </h2>
        <form class="space-y-4" @submit.prevent="form.post(route('verification.send'), { onSuccess: () => close})">
            <p class="text-sm text-gray-900">
                You'll need to verify your email before accessing that.
            </p>
            <div>
                <button type="submit"
                    class="flex w-full justify-center bg-blue-500 disabled:opacity-50 px-3 py-2 text-sm text-semibold text-white"
                >
                    Resend email
                </button>
            </div>
        </form>
    </Modal>
</template>

<script setup>
import { Head, router, useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';

const form = useForm({})

</script>