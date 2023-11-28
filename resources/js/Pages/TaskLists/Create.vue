<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TaskListsComponent from "@/Pages/TaskLists/TaskListsComponent.vue";

defineProps({
    taskLists: {
        type: Object,
    },
});

const form = useForm({
    title: '',
})

const submit = () => {
    form.post(route('task-lists.store'), {
        preserveScroll: true
    })
}
</script>

<template>
    <Head title="Task lists" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task list > create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 flex gap-4">
                <div class=" w-1/4 overflow-hidden">
                    <TaskListsComponent :taskLists="taskLists" />
                </div>

                <div class=" w-3/4 bg-white shadow-sm sm:rounded-lg p-4">
                    <form @submit.prevent="submit" class="">
                        <div>
                            <TextInput
                                id="title"
                                type="text"
                                class="block w-full"
                                v-model="form.title"
                                required
                                autofocus
                                placeholder="Enter title"
                            />
                            <InputError
                                class="my-4"
                                :message="form.errors.title"
                            />
                        </div>

                        <PrimaryButton class="my-2" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
