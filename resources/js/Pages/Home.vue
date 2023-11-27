<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <GuestLayout>
        <Head title="Task management service" />

        <main>
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <h1 class="text-2xl">TODO</h1>
                <div class="mt-2 text-md italic">The best task management service</div>

                <div v-if="canLogin" class="mt-8">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >{{ $page.props.auth.user.name }}</Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >Log in</Link
                        >

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >Register</Link
                        >
                    </template>
                </div>
            </div>
        </main>
    </GuestLayout>
</template>
