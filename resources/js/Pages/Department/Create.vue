<template>
    <br />
    <a class="flex items-center justify-between p-4 mb-4 text-sm font-semibold text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
        href="#">
        <div class="flex items-center">
            <icon name="stack" />
            <span>Create Department </span>
        </div>
    </a>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="px-2 mb-1 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid gap-1 mb-2 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Department Name"</label>
                    <input v-model="form.name" :error="form.errors.name" type="text" :min="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Department Name" required />
                </div>
                <div>
                    <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Department Code</label>
                    <input v-model="form.code" :error="form.errors.code" type="text" :min="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Department Code" required />
                </div>

            </div>
            <div class="flex items-center justify-end px-8 py-4 border-t border-gray-100">
                <PrimaryButton type="submit">Submit Request</PrimaryButton>
            </div>
        </div>
    </form>



</template>
<script>
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import TextareaInput from "../../Shared/TextareaInput";

export default {
    components: {
        Head,
        Link,
        TextareaInput
    },
    setup() {
        const form = useForm({
            name: "",
            code: "",
        });

        return { form };
    },
    methods: {
        submit() {
            this.form.post("/departments/store");
        }
    },
};
</script>


