<template>
    	<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
		<div>
			<center>
				<img src="{{ asset('NIT_logoBg.png') }}" alt="" width="10%">
				<span class="uppercase font-bold">nit leave request management system</span>
			</center>
	</div>

		<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
			<form @submit.prevent="update">
			<!-- Name -->
				<div>
					<label for="name" class="block font-medium text-sm text-gray-700">
						Name
					</label>
					<input id="name" v-model="form.name" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"  required autofocus>
				</div>
					<!-- Phone -->
					<div>
						<label for="name" class="block font-medium text-sm text-gray-700">
							Phone
						</label>
						<input id="phone" v-model="form.phone" type="number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"  required autofocus>
					</div>
				<!-- Email Address -->
				<div class="mt-4">
					<label for="email" class="block font-medium text-sm text-gray-700">
						Email
					</label>
					<input id="email" v-model="form.email" type="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"  required>
				</div>
				<div class="form-group">
				  <label for="">Department</label>
				  <select class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.department_id" >
					<option>----select---</option>
					<option v-for="(department, index) in departments" :key="index"  :value="department.id">{{ department.name }}</option>
				  </select>
				</div>
				<div class="form-group">
				  <label for="">Role</label>
				  <select class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.role_id" >
					<option>----select---</option>
					<option v-for="(role, index) in roles" :key="index" :value="role.id" >{{ role.name }}</option>
				  </select>
				</div>
					<!-- Password -->
					<div class="mt-4">
						<label for="password" class="block font-medium text-sm text-gray-700">
							Reginstation Number
						</label>
	
						<input id="reg" v-model="form.reg" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
					</div>
				<!-- Password -->
				<div class="mt-4">
					<label for="password" class="block font-medium text-sm text-gray-700">
						Password
					</label>
					<input id="password" v-model="form.password" type="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"  autocomplete="new-password">
				</div>

				<!-- Confirm Password -->
				<div class="mt-4">
					<label for="password_confirmation" class="block font-medium text-sm text-gray-700">
						Confirm Password
					</label>
					<input id="password_confirmation" v-model="form.password_confirmation" type="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :required="form.password">
				</div>

				<div class="flex items-center justify-end mt-4">
					<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
						Already registered?
					</a>
					<button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
						Register
					</button>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
import { Link, useForm } from '@inertiajs/vue3'
import TextInput from '../../Shared/TextInput'
import TextareaInput from '../../Shared/TextareaInput'
import LoadingButton from '../../Shared/LoadingButton'
import SelectInput from '../../Shared/SelectInput'

export default {
    props: {
        user: Object,
        roles: Object,
        departments: Object,
    },
    components: {
    LoadingButton,
    TextareaInput,
    TextInput,
    SelectInput
  },
    remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.user.name,
        reg: this.user.reg,
        email: this.user.email,
        phone: this.user.phone,
        password_confirmation: '',
        password: this.user.password,
        password: this.user.password,
        department_id: this.user.department_id,
        role_id: this.user.role_id,
      }),
    }
  },
  methods: {
    update() {
      if (confirm('Are you sure you want to update this information?')) {
        this.form.post(`/users/update/${this.user.reference}`);
      }
    },
  },
}
</script>