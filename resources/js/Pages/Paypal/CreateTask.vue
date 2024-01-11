<template>
    <br />
    <a class="flex items-center justify-between p-4 mb-4 text-sm font-semibold text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
        href="#">
        <div class="flex items-center">
            <icon name="stack" />
            <span>Create Task<i class="fas fa-theater-masks    "></i> </span>
        </div>
    </a>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="px-2 mb-1 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid gap-1 mb-2 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Your Name</label>
                    <input v-model="form.user" :error="form.errors.user" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="eg Juma Jamari" required />
                </div>
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Task Name</label>
                    <input v-model="form.task" :error="form.errors.task" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="eg Writing" required />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Currency Type</label>
                    <select v-model="form.currency_type" :error="form.errors.currency_type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">---select---</option>
                        <option value="tsh">Tsh</option>
                        <option value="us">US Dollar</option>
                    </select>
                </div>
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Task Price</label>
                    <input v-model="form.price" :error="form.errors.price" type="number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="" required />
                </div>
            </div>

            <label class="block mt-1 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Task Description</span>
                <textarea required
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-blue-500 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="6" placeholder="Task description here.." v-model="form.description"></textarea>
            </label>
            <div class="flex items-center justify-end px-8 py-4 border-t border-gray-100">
                <PrimaryButton :disabled="!form.task || !form.user " type="submit">Submit Task</PrimaryButton>
            </div>
        </div>
    </form>


</template>
<script>
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import SelectInput from "../../Shared/SelectInput";
import LoadingButton from "../../Shared/LoadingButton";
import TextareaInput from "../../Shared/TextareaInput";

export default {
    components: {
        Head,
        Link,
        LoadingButton,
        SelectInput,
        TextareaInput
    },
    props: {
        openInNewTab: {
            type: Boolean,
            required: true,
        },
    },
    setup() {
        const form = useForm({
            currency_type: "",
            user: "",
            description: "",
            price: "",
            task: "",
        });

        return { form };
    },

    methods: {
        submit() {
            this.form.post("/process-transaction");
        },
    },
    mounted(){
        if (this.openInNewTab !== "" && thhis.openInNewTab == true) {
        // Open the link in a new tab using JavaScript
        window.open("{{ route('createTransaction') }}", "_blank");
    }
    }
};
</script>

