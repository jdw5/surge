<template>
    <Head title="Two factor authenticate"/>
    <Modal>
        <h2 class="text-center text-2xl font-bold font-mono text-gray-900">
            Two factor authenticate
        </h2>
        <form class="mt-6 space-y-4" @submit.prevent="submit">
            
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
    </Modal>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';


const form = useForm({
    code: ''
})

const submit = () => {
    form.post('/two-factor-challenge')
}
</script>