<template>
  <div
    class="flex items-center justify-between p-2 my-4 text-sm text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
    href="#">
    <div class="flex items-center">
      <icon name="stack" />
      <span class="pl-4">List of Tasks</span>
    </div>
    <a :href="'/tasks/dashboard'" title="Go Back">
      Go Back &RightArrow;
    </a>
  </div>
  <div class="w-full flex-auto">
    <span>
      <input v-model="search" type="text"
        class="w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Search here.." @keyup="getSearch" />
    </span>
    <span>
      <div class=' mt-6 text-sm flex justify-end'>
        <LinkWithIcon :link-route="`/create-ransaction`" title="Add Task">
          <template #icon>
            +
          </template>
        </LinkWithIcon>
      </div>
    </span>
  </div>
  <div class="w-full mb-8 mt-3 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table v-if="tasks.data.length" class="w-full whitespace-no-wrap mt-2">
        <thead>
          <tr
            class="text-xs tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-2 py-2">#</th>
            <th class="px-2 py-2">User</th>
            <th class="px-2 py-2">Task</th>
            <th class="px-2 py-2">Description</th>
            <th class="px-2 py-2">Date</th>
            <th class="px-2 py-2">
              <center>Status</center>
            </th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="task in tasks.data" :key="task.id" class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2 text-sm">
              {{ task.i }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ task.user }}
            </td>
            <td class="px-2 py-2 text-xs">
              {{ task.task }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ task.description }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ task.date }}
            </td>
            <td class="px-2 py-2 text-sm">
              <center>
                <span v-if="task.status === 'partial'"
                  class=" px-2 py-1 text-center text-dark-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ task.status }}
                </span>
                <span v-else-if="task.status === 'paid'"
                  class=" px-2 py-1 text-center text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ task.status }}
                </span>
                <span v-else
                  class=" px-2 py-1 text-center text-red-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ task.status }}
                </span>
              </center>
            </td>
        <td class="flex">
          <Link :href="`/tasks/show/${task.uuid}`">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            </Link>
            <Link @click="destroy(task.uuid)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-red-700">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            </Link>
        </td>
          </tr>
        </tbody>
      </table>
      <p v-if="tasks.data.length === 0">No task found</p>

    </div>
    <FlashMessages />
    <div v-if="task_count > 10">
      <pagination class="mt-4" :links="tasks.links" />
    </div>
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
    tasks: {
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
    month: Object,
    back_url: String,
    task_count: Number,
  },
  mounted() {
    this.list()
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
        this.$inertia.get('/tasks', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    getSearch() {
      this.$inertia.get('/tasks', {
        search: this.search,
      }).then(function (response) {
        this.search = this.search_data
      }).bind(this);
    },
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    destroy(uuid){
      if (confirm('Delete this task ?')) {
        this.$inertia.delete(`/tasks/destroy/${uuid}`);
      }
    },

    getByMonth: function () {
      this.show = true;
      this.$inertia.get('/tasks', {
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
}</style>
