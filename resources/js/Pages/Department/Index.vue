<template>
  <div
    class="flex items-center justify-between p-2 my-4 text-sm text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
    href="#">
    <div class="flex items-center">
      <icon name="stack" />
      <span class="pl-4">List Of Departments</span>
    </div>
    <a :href="`${back_url}`" title="Go Back">
      Go Back &RightArrow;
    </a>
  </div>
  <div v-if="can_add" class='flex-1 mt-6 text-sm flex justify-end'>
            <LinkWithIcon :link-route="`/departments/create`" title="Add Department">
              <template #icon>
                +
              </template>
            </LinkWithIcon>
          </div>
  <div class="w-full mb-8 mt-3 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table v-if="departments.data.length" class="w-full whitespace-no-wrap mt-2">
        <thead>
          <tr
            class="text-xs tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-2 py-2">#</th>
            <th class="px-2 py-2">Department Name</th>
            <th class="px-2 py-2">Department Code</th>
            <th class="px-2 py-2">Employees</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="leave_request in departments.data" :key="leave_request.id"
            class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2 text-sm">
              {{ leave_request.sn }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.name }}
            </td>
            <td class="px-2 py-2 text-xs">
              {{ leave_request.code }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.users }}
            </td>
            <td class="px-2 py-2 text-sm">
              <div class="flex items-center space-x-4 text-sm">
                                        <Link :href="`/departments/edit/${leave_request.uuid}`" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-genedark rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                          </Link>
              <Link href="#" @click="destroy(leave_request.uuid)" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-700 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                          </Link>
                                          </div>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-if="departments.data.length === 0">No leave request found</p>

    </div>
  <FlashMessages />
  <pagination class="mt-4" :links="departments.links" />
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
    departments: {
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
    ltype: Number,
    month: Object,
    back_url: String,
    can_add: Boolean,
  },
 
  data() {
    return {
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
        this.$inertia.get('/departments/index', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    destroy(uuid){
      if (confirm('Delete this department ?')) {
        this.$inertia.delete(`/departments/delete/${uuid}`);
      }
    },
    getByType: function () {
      this.show = true;
      this.$inertia.get('/departments/index', {
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
      this.$inertia.get('/departments/index', {
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
