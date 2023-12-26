<template>
    <Head title="Profile Information"></Head>
    <div class="">
        <h2 class="font-bold font-mono text-gray-900">
            Profile Information
        </h2>
        <form @submit.prevent="submit" class="mt-6 space-y-4">
            <div>
                <FormLabel for="name">
                    Name
                </FormLabel>
                <div class="mt-2">

                    <FormInput id="name" 
                        v-model="form.name"
                        required
                    />
                    <FormError :error="form.errors.name"/>
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
                <FormLabel for="photo">
                    Profile photo
                </FormLabel>
                <div class="mt-2 flex items-center gap-x-4">
                    <div>
                        <img :src="photoPreview" 
                            v-if="photoPreview"
                            class="h-12 w-12 rounded-full"
                            alt="Photo preview"
                        >
                        <img :src="$page.props.auth.user.avatar" 
                            v-else
                            class="h-12 w-12 rounded-full"
                            alt="Current avatar"
                        >
                    </div>
                    <div>
                        <button type="button" v-if="photo" @click="photo = null" class="text-sm font-semibold text-blue-500">
                            Clear
                        </button>
                        <label v-else for="photo" class="text-sm font-semibold text-blue-500">
                            Choose new photo
                        </label>
                        <input type="file" 
                            id="photo" 
                            class="sr-only"
                            @change="photo = $event.target.files[0]"
                        >

                    </div>
                </div>
            </div>

            <div class="">
                <button type="submit" :disabled="form.processing"
                    class="flex w-full justify-center bg-blue-500 disabled:opacity-50 px-3 py-2 text-sm text-semibold text-white"
                >
                    Update
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { Head, useForm, Link, usePage } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import AccountLayout from '@/Layouts/AccountLayout.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';

defineOptions({
    layout: [DefaultLayout, AccountLayout],
})

const page = usePage()

const form = useForm({
    _method: 'PUT',
    name: page.props.auth.user.name,
    email: page.props.auth.user.email,
    photo: null,
})

const submit = () => {
    form.post(route('user-profile-information.update'), {
        preserveScroll: true,

    })
}

const photo = ref()

const photoPreview = computed(() => {
    return photo.value ? URL.createObjectURL(photo.value) : null
})

watch(photo, () => {
    form.photo = photo.value
})

</script>