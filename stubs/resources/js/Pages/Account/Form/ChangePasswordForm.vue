<template>
    <div>
        <h2 class="font-bold font-mono text-gray-900">
            Change password
        </h2>
        <form @submit.prevent="submit" class="mt-6 space-y-4">
            <div>
                <FormLabel for="current_password">
                    Current password
                </FormLabel>
                <div class="mt-2">
                    <FormInput type="password"
                        id="current_password" 
                        v-model="form.current_password"
                        required
                    />
                    <FormError :error="form.errors.current_password"/>
                </div>
            </div>

            <div>
                <FormLabel for="password">
                    Password
                </FormLabel>
                <div class="mt-2">

                    <FormInput type="password"
                        id="password" 
                        v-model="form.password"
                        required
                    />
                    <FormError :error="form.errors.password"/>
                </div>
            </div>

            <div>
                <FormLabel for="password_confirmation">
                    Confirm password
                </FormLabel>
                <div class="mt-2">

                    <FormInput type="password"
                        id="password_confirmation" 
                        v-model="form.password_confirmation"
                        required
                    />
                    <FormError :error="form.errors.password_confirmation"/>
                </div>
            </div>


            <div class="">
                <button type="submit" :disabled="form.processing"
                    class="flex w-full justify-center bg-blue-500 disabled:opacity-50 px-3 py-2 text-sm text-semibold text-white"
                >
                    Change Password
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';


const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('user-password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

</script>