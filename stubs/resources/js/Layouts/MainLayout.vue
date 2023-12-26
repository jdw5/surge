<template>
    <div>
        <Navigation />
        <div>
            <slot />
        </div>
        
        <Toast />
        <Modal />
    </div>
</template>

<script setup>
import Navigation from './Partials/Navigation.vue'
import { Modal } from 'momentum-modal'
import Toast from '@/Components/Toast.vue'

</script>