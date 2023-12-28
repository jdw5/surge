<template>
    <div>
        <div class="min-h-screen flex flex-col bg-background dark:bg-background-dark">
            <nav class="">
                <div class="">
                    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
                        <div class="flex justify-between h-16 border-b border-accent dark:border-gray-700">
                            <div class="flex">
                                <div class="shrink-0 flex items-center">
                                    <Link :href="route('home.index')">
                                        X
                                    </Link>
                                </div>
                                <div v-if="$page.props.auth.user" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <NavLink :href="route('home.index')" :active="route().current('home.index')">
                                        Dashboard
                                    </NavLink>
                                    
                                </div>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Settings Dropdown -->
                                <div v-if="$page.props.auth.user">
                                    
                                </div>
                                <div v-else>
                                    <SecondaryButton 
                                        :as="Link" 
                                        :href="route('auth.register')"
                                    >
                                        Register
                                    </SecondaryButton>
                                    <PrimaryButton 
                                        :as="Link" 
                                        :href="route('auth.login')"
                                    >
                                        Log in
                                    </PrimaryButton>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                Hamburger
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    class="sm:hidden"
                >
                    Hello
                    
                </div>
            </nav>
            <main class="flex-grow relative">
                <div>    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Content -->
                        <slot />
                    </div>
                </div>
            </main>

            <footer class="w-full relative bg-primary shadow">
                <!-- Footer -->
            </footer>
        </div>
        <Modal />
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import NavLink from './Partials/NavLink.vue'
import { Modal } from 'momentum-modal'
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue'
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue'
// import Toast from '@/Components/Toast.vue'

const showMobileNavigation = ref<boolean>(false)

</script>


