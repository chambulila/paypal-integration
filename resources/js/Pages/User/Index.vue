<template>
  <div
    class="flex items-center justify-between p-2 my-4 text-sm text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
    href="#">
    <div class="flex items-center">
      <icon name="stack" />
      <span class="pl-4">List of Staff Members</span>
    </div>
    <a :href="`${back_url}`" title="Go Back">
      Go Back &RightArrow;
    </a>
  </div>



  <div class='flex-1 mt-6 text-sm flex justify-end'>
    <SecondaryLink :link-route="`/users/import/add`" title="Import Excel">
    </SecondaryLink>
    <LinkWithIcon :link-route="`/users/create`" title="Add User">
      <template #icon>
        +
      </template>
    </LinkWithIcon>
  </div>
  <div class="w-full mb-8 mt-3 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table v-if="users.data.length" class="w-full whitespace-no-wrap mt-2">
        <thead>
          <tr
            class="text-xs tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-2 py-2">#</th>
            <th class="px-2 py-2">Name</th>
            <th class="px-2 py-2">Reg No</th>
            <th class="px-2 py-2">Department</th>
            <th class="px-2 py-2">Phone</th>
            <th class="px-2 py-2">Email</th>
            <th class="px-2 py-2">Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="leave_request in users.data" :key="leave_request.id" class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2 text-sm">
              {{ leave_request.i }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.name }}
            </td>
            <td class="px-2 py-2 text-xs">
              {{ leave_request.reg }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.department }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.phone }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.email }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.role }}
            </td>
           <td>
            <div class="flex">
              <Link :href="`/users/show/${leave_request.reference}`">
            <icon name="list" />
            </Link>
            <Link :href="`/users/edit/${leave_request.reference}`">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
              </svg>
            </Link>
            <Link @click="destroy(leave_request.reference)">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-700">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
            </Link>
            </div>
           </td>
          </tr>
        </tbody>
      </table>
      <p v-if="users.data.length == 0">No user found</p>
    </div>
    <FlashMessages />
    <div v-if="user_count > 10">
    <pagination class="mt-4" :links="users.links" />
    </div>
    <!-- <pagination align="center" :data="leave_requests" @pagination-change-page="list"></pagination> -->

  </div>
</template>
<script>
import FlashMessages from '../../Shared/FlashMessages'
import Pagination from '../../Shared/Pagination'
import Icon from '../../Shared/Icon'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import SearchFilter from '../../Shared/SearchFilter'
import TextInput from '../../Shared/TextInput'
import { Link, Head, useForm } from '@inertiajs/vue3'
import axios from 'axios'
export default {

  components: {
    Pagination,
    FlashMessages,
    SearchFilter,
    TextInput,
    Icon,
  },
  props: {
    users: {
      type: Object,
      required: true,
    },
    filters: {
      type: Object,
      required: true,
    },
    readStatus: {
      type: String,
      required: false,
      default: '',
    },
    coments: Object,
    leavetypes: Object,
    ltype: Number,
    month: Object,
    back_url: String,
    user_count: Number,
  },
  mounted() {
    this.list()
  },
  data() {
    return {
    number: 0,
      openModal: false,
      show: false,
      ltype: '',
      stmonth: '',
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/leaverequests/index', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    destroy(reference){
      if (confirm('Delete this user ?')) {
        this.$inertia.delete(`/users/destroy/${reference}`);
      }
    },
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    getByType: function () {
      this.show = true;
      this.$inertia.get('/leaverequests/index', {
        month: this.stmonth,
        read: this.readStatus,
        ltype: this.ltype,
      }).then(function (response) {
        this.show = true;
        console.log(response.data);
      }.bind(this));
    },
    getByMonth: function () {
      this.show = true;
      this.$inertia.get('/leaverequests/index', {
        month: this.stmonth,
        read: this.readStatus,
        ltype: this.ltype,
      }).then(function (response) {
      }.bind(this));
    },
  },
}
</script>
<style scoped>
.flash-message {
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  border-radius: 5px;
  position: fixed;
  top: 10px;
  right: 10px;
  animation: fadeIn 1s, fadeOut 1s 2s;
}

@keyframes fadeIn {
  0% {
    opacity: 0;
  }

  100% {
    opacity: 1;
  }
}

@keyframes fadeOut {
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0;
  }
}
</style>
