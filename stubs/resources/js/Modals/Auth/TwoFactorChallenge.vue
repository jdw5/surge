<template>
    <Head title="Two factor authenticate"/>
    <Modal>
        <ModalHeader>
            Two factor authenticate
        </ModalHeader>
        <ModalBody class="p-4">
            <form class="space-y-4" @submit.prevent="submit">
                <div>
                    <FormLabel for="code">
                        Code
                    </FormLabel>
                    <FormInput id="code" 
                        type="password"
                        v-model="form.code"
                        required
                    />
                    <FormError :error="form.errors.code"></FormError>
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
import { Head, useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal/Modal.vue'
import ModalHeader from '@/Components/Modal/ModalHeader.vue'
import ModalBody from '@/Components/Modal/ModalBody.vue'
import FormLabel from '@/Components/Form/FormLabel.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormError from '@/Components/Form/FormError.vue';

const form = useForm({
    code: ''
})

const submit = () => {
    form.post('/two-factor-challenge')
}
</script>