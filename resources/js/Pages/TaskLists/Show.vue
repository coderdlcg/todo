<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TaskListsComponent from "@/Pages/TaskLists/TaskListsComponent.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref } from "vue";

defineProps({
    taskLists: {
        type: Object,
    },
    taskList: {
        type: Object,
    },
    tasks: {
        type: Object,
    },
});

const form = useForm({
    title: '',
})

const confirmingTaskListDeletion = ref(false);
const confirmTaskListDeletion = () => {
    confirmingTaskListDeletion.value = true;
};

const closeModal = () => {
    confirmingTaskListDeletion.value = false;
};

const deleteTaskList = (taskList) => {
    form.delete(route('task-lists.destroy', taskList.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};
</script>

<template>
    <Head title="Task lists" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task list > show</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 flex gap-4">
                <div class=" w-1/4 overflow-hidden">
                    <TaskListsComponent :taskLists="taskLists" />
                </div>

                <div class="w-3/4 bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="my-2 border-b-2 py-2 flex justify-between mb-4 items-center">
                        <div class="text-xl w-full">{{ taskList.title }}</div>
                        <div class="actions flex gap-3">
                            <Link :href="route('task-lists.edit', taskList.id)" class="px-4 py-2 bg-gray-800 text-white rounded-lg" >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </Link>
                            <DangerButton @click="confirmTaskListDeletion">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </DangerButton>
                        </div>
                    </div>

                    <Link :href="route('tasks.create', taskList.id )" class="px-4 py-2 w-32 flex bg-sky-400 text-sm text-white rounded-lg" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>

                        new Task
                    </Link>

                    <div class="m-2 rounded-lg p-2 flex justify-between mb-4 items-center" v-for="task in tasks" :class="{'text-gray-300': task.is_done}">
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
                        <div class="text-xl w-full px-4" :class="{'line-through': task.is_done}">{{ task.title }}</div>
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

                <Modal :show="confirmingTaskListDeletion" @close="closeModal">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Are you sure you want to delete your task list: {{ taskList.title }}?
                        </h2>

                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                            <DangerButton
                                class="ms-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click="deleteTaskList(taskList)"
                            >
                                Delete task list
                            </DangerButton>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
