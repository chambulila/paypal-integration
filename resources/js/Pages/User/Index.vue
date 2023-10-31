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
            <Link :href="`/leaverequests/show/${leave_request.reference}`">
            <icon name="list" />
            </Link>
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
