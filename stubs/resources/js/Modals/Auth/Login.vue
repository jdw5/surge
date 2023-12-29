<template>
    <Head title="Sign in"/>
    <Modal>
        <ModalBody>
            <ModalHeader>
                Sign in
            </ModalHeader>
            <form @submit.prevent="onSubmit" class="space-y-4 p-4">
                <div>
                    <FormLabel for="email">
                        Email
                    </FormLabel>
                    <div>

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
                    <div>
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
                        <Checkbox id="remember" 
                            v-model="form.remember"
                        />
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
                    <PrimaryButton type="submit" :disabled="form.processing" class="w-full">
                        Sign in
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
import Checkbox from '@/Components/Form/Checkbox.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormError from '@/Components/Form/FormError.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false
})

const onSubmit = () => {
    form.post('/login', {
        onError: () => {
            console.log('WHY')
        }
    })
}
</script>