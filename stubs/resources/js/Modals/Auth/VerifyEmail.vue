<template>
    <Head title="Verify your email"/>
    <Modal v-slot="{ close }">
        <ModalHeader>
            Verify your email
        </ModalHeader>
        <ModalBody class="p-4">
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
        </ModalBody>
    </Modal>
</template>

<script setup>
import { Head, router, useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal/Modal.vue'
import ModalHeader from '@/Components/Modal/ModalHeader.vue'
import ModalBody from '@/Components/Modal/ModalBody.vue'
import FormLabel from '@/Components/Form/FormLabel.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormError from '@/Components/Form/FormError.vue';

const form = useForm({})

</script>