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
                    <div v-for="taskList in taskLists" class="">
                        <div class="m-2 border-2 border-gray-100 rounded-lg p-2 flex justify-between mb-4 items-center" v-for="task in taskList.tasks" :class="{'text-gray-300': task.is_done}">
                            <Link :href="route('tasks.done', task.id)" class="" >
                                <div class="border-2 border-gray-300 rounded-full w-5 h-5 relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor"
                                         class="w-8 h-8 -top-3 -left-1.5 absolute"
                                         v-show="task.is_done">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            </Link>
                            <div class="w-full px-4">
                                <div class="text-xl" :class="{'line-through': task.is_done}">{{ task.title }}</div>
                                <div class="text-sm text-blue-300" >{{ taskList.title }}</div>
                            </div>
                            <div class="actions flex gap-3">
                                <Link :href="route('tasks.show', task.id)" class="" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                </Link>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
