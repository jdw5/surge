<template>
    <Head title="Recover your account"/>
    <Modal v-slot="{ close }">
        <ModalBody>
            <ModalHeader>
                Recover your account
            </ModalHeader>
            <form class="space-y-4 p-4" @submit.prevent="form.post(route('password.email'), { onSuccess: () => close })">
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
                    <PrimaryButton type="submit" 
                        :disabled="form.processing"
                        class="w-full" 
                    >
                        Continue
                    </PrimaryButton>
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
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';

const form = useForm({
    email: ''
})

</script>