<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import TaskListsComponent from "@/Pages/TaskLists/TaskListsComponent.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    taskLists: {
        type: Object
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 flex gap-4">
                <div class=" w-1/4 overflow-hidden">
                    <TaskListsComponent :taskLists="taskLists" />
                </div>

                <div class="w-3/4 bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    ...
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
