<template>
    <br />
    <a class="flex items-center justify-between p-4 mb-4 text-sm font-semibold text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
        href="#">
        <div class="flex items-center">
            <icon name="stack" />
            <span>Create Leave Request </span>
        </div>
    </a>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="px-2 mb-1 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid gap-1 mb-2 md:grid-cols-2">
                <div>
                    <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start
                        Date</label>
                    <input v-model="form.start_date" :error="form.errors.start_date" type="date" :min="start_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="John" required />
                </div>
                <div>
                    <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End
                        Date</label>
                    <input v-model="form.end_date" :error="form.errors.end_date" type="date" :min="start_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Doe" required />
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Leave Reason</label>
                    <select v-model="form.leave_reason" :error="form.errors.leave_reason"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">---select---</option>
                        <option v-for="reason in reasons" :value="reason.id">
                            {{ reason.name }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Leave Type</label>
                    <select v-model="form.leave_type_id" :error="form.errors.leave_type_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">---select---</option>
                        <option v-for="ltype in leave_type" :value="ltype.id">
                            {{ ltype.name }}
                        </option>
                    </select>
                </div>
            </div>

            <label for="File">Attachment</label>
            <input type="file" @change="previewImage" ref="photo"
                class="w-full mr-8 px-3 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" />
            <img v-if="url" :src="url" class="w-1/3 mt-4 h-40" />

            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>

            <label class="block mt-1 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Request Note</span>
                <textarea required
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-blue-500 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="6" placeholder="Tell something about leave" v-model="form.note"></textarea>
            </label>
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
        leave_type: {
            type: Object,
            required: true,
        },
        start_date: {
            type: String,
            required: true,
        },
        students: {
            type: Object,
            required: false,
        },
        reasons: {
            type: Object,
            required: true,
        },
    },
    setup() {
        const form = useForm({
            image: null,
            leave_type_id: "",
            start_date: "",
            end_date: "",
            note: "",
            leave_reason: "",
        });

        return { form };
    },
    data() {
        return {
            staticModal: false,
        }
    },
    methods: {
        showmodal() {
            this.staticModal = true;
        },
        submit() {
            alert(4);
            if (this.$refs.photo) {
                this.form.image = this.$refs.photo.files[0];
            }
            this.form.post("/leaverequests/store");
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
    },
};
</script>


