<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    taskLists: {
        type: Object,
    },
});
</script>

<template>
    <Link :href="route('task-lists.create')" class="bg-green-500 hover:bg-green-400 text-white rounded-lg p-2 flex justify-between mb-2 items-center shadow-sm sm:rounded-lg " >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <div>
            new Task list
        </div>
    </Link>

    <div class="" v-for="taskList in taskLists">
        <Link :href="route('task-lists.show', taskList)" class="" >
            <div class="bg-white hover:bg-gray-50 rounded-lg p-2 flex justify-between mb-2 items-center shadow-sm sm:rounded-lg ">
                <div class="text-xl w-full px-4">
                    {{ taskList.title }}
                </div>
            </div>
        </Link>
    </div>
</template>
