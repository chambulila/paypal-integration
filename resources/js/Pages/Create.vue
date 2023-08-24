<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Employee Basic Info</h5>
                </div>
                <div class="card-body pt-0">
                    <form @submit.prevent="store">
                        <div class="row">
                            <text-input v-model="form.name" :error="form.errors.first_name" label="Staff name" />
                            <select-input v-model="form.sex" :error="form.errors.sex" required id="choices-gender">
                                <option value="">---- Sex---</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select-input>
                        </div>
                        <div class="row">
                            <text-input onfocus="(this.type = 'date')" onblur="(this.type = 'text')" v-model="form.dob"
                                :error="form.errors.dob" label="Date of Birth" />
                            <text-input onfocus="(this.type = 'date')" onblur="(this.type = 'text')" v-model="form.jod"
                                :error="form.errors.jod" label="Joining Date" />
                        </div>
                        <div class="row">
                            <select-input v-model="form.department_id" :error="form.errors.department_id"
                                label="Staff Department">
                                <option :value="null" />
                                <option v-for="organization in tasks" :key="organization.id" :value="organization.id">
                                    {{ organization.name }}</option>
                            </select-input>

                            <select-input class="form-control" v-model="form.role_id" :error="form.errors.role_id" label="Staff Role">
                                <option :value="null" />
                                <option v-for="role in tasks" :key="role.id" :value="role.id">{{ role.name }}</option>
                            </select-input>
                        </div>
                        <div class="row">
                            <div>
                                <loading-button :loading="form.processing" class="btn-success" type="submit">Add
                                    Staff</loading-button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    Link
} from '@inertiajs/vue3'
// import Layout from '../Shared/Layout'
import TextInput from '../Shared/TextInputB'
import SelectInput from '../Shared/SelectInput'
import MultipleInput from '../Shared/MultipleInput'
import LoadingButton from '../Shared/LoadingButton'
import DateInput from '../Shared/LoadingButton'

export default {
    components: {
        Link,
        LoadingButton,
        SelectInput,
        MultipleInput,
        TextInput,
        DateInput
    },
    props: {
        tasks: Object,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                role_id: '',
                email: '',
                phone: '',
                address: '',
                sex: '',
                salary: '',
                dob: '',
                jod: '',
                department_id: '',
            }),
        }
    },
    methods: {
        store() {
            alert(this.form.name);
        },
    },
}

</script>
