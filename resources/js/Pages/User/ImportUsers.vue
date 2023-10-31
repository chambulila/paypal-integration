<template>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="px-2 mb-1 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid gap-1 mb-2 md:grid-cols-2">
            <input type="file"  ref="users" label="Attachment" required
                class="w-full flex justify-center mr-8 px-3 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" />
            </div>
            <div class="flex items-center justify-center px-8 py-4 border-t border-gray-100">
                <PrimaryButton type="submit">Upload</PrimaryButton>
            </div>
        </div>
    </form>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    setup() {
        const form = useForm({
            users: null,
        });

        return { form };
    },
    methods: {
        submit() {
            if (this.$refs.users) {
                this.form.users = this.$refs.users.files[0];
            }
            this.form.post("/users/import/store");
        },
    }
}
</script>