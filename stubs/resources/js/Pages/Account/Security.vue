<template>
    <Head title="Security" />
    <div class="space-y-12">
        <ChangePasswordForm v-if="$page.props.features['update-passwords']" />
        <TwoFactorForm v-if="$page.props.features['two-factor-authentication']" />
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import MainLayout.vue from '@/Layouts/MainLayout.vue.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import ChangePasswordForm from './Form/ChangePasswordForm.vue';
import TwoFactorForm from './Form/TwoFactorForm.vue';

defineOptions({
    layout: [DefaultLayout, MainLayout.vue],
})
</script>