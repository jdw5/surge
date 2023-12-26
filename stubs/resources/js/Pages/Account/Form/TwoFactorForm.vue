<template>
    <div class="space-y-4">
        <h2 class="font-bold font-mono text-gray-900">
            Enable two-factor Authentication
        </h2>
        <div>
            <button v-if="!$page.props.auth.user.two_factor_enabled" 
                @click="enable"
                class="font-semibold text-sm text-blue-500"
            >
                Enable 2FA
            </button>
            <button v-else
                @click="disable"
                class="font-semibold text-sm text-blue-500"
            >
                Disable 2FA
            </button>
        </div>
        <div v-if="$page.props.auth.user.two_factor_enabled">
            <h2 class="font-bold font-mono text-gray-900">
                Recovery codes
            </h2>
            <div>
                <button @click="fetchRecoveryCodes" 
                    v-if="!recoveryCodes.length"
                    class="font-semibold text-sm text-blue-500"
                >
                    Show recovery codes
                </button>
            </div>
            <ul v-if="recoveryCodes.length">
                <li v-for="recoveryCode in recoveryCodes" :key="recoveryCode" class="text-sm">
                    {{ recoveryCode }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';
import axios from 'axios';

const enable = () => {
    axios.post(route('two-factor.enable')).then(() => {
        router.get(route('auth.two-factor'))
    }).catch((error) => {
        if (error.response.status === 423) {
            router.get(route('password.confirm'))
        }
    })
            
}

const disable = () => {
    router.delete(route('two-factor.disable'))
}

const recoveryCodes = ref([])

const fetchRecoveryCodes = () => {
    axios.get(route('two-factor.recovery-codes')).then((response) => {
        recoveryCodes.value = response.data
    }).catch((error) => {
        if (error.response.status === 423) {
            router.get(route('password.confirm'))
        }
    })
}
</script>