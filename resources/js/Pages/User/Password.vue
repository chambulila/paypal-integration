<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
<div>
  <center>
    <img src="{{ asset('NIT_logoBg.png') }}" alt="" width="10%">
    <span class="uppercase font-bold">nit leave request management system</span>
  </center>
</div>
<div class="text-center">
  <center>Password Reset</center>
</div>
<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
  <form @submit.prevent="update">
    <!-- Old Password -->
    <div v-if="error">
      <li >{{ error }}</li>
    </div>
    <div class="mt-4">
      <label for="password" class="block font-medium text-sm text-gray-700">
        Old Password
      </label>
      <input id="password" v-model="form.old_password" type="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"  >
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
      <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
        Submit
      </button>
    </div>
  </form>
</div>
</div>
</template>
<script>
import { Link, useForm } from '@inertiajs/vue3'

export default {

remember: 'form',
props: {
  errors: Object,
},

data() {
return {
  form: this.$inertia.form({
    password: '',
    old_password: '',
    password_confirmation: '',
  }),
}
},
methods: {
update() {
  if (confirm('Are you sure you want to update this information?')) {
    this.form.post(`/users/update-password`);
  }
},
},
}
</script>