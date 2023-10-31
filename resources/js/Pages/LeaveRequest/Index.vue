<template>
  <div
    class="flex items-center justify-between p-2 my-4 text-sm text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
    href="#">
    <div class="flex items-center">
      <icon name="stack" />
      <span class="pl-4">List of Leave Requests</span>
    </div>
    <a :href="`${back_url}`" title="Go Back">
      Go Back &RightArrow;
    </a>
  </div>
  <!-- <div class="w-full flex mt-0">
    <search-filter v-model="form.search" class="mr-4 flex-grow max-w-md" @reset="reset"></search-filter>
    <form class="form-horizontal w-1/2 ml-5 mb-5" role="form" method="post">
      <div class="flex gap-6">
        <div class='flex-1 mt-1 text-sm'>
          <label class="block text-sm text-gray-700 dark:text-gray-400">Leave Type</label>
          <select v-model="ltype" @change="getByType()"
            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-500 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
            <option value="" selected>Select leave type</option>
            <option v-for="subject in leavetypes" :key="subject.id" :value="subject.id">{{ subject.name }}
            </option>
          </select>
          <a v-if="ltype.length != 0"
            class="group relative inline-flex items-center overflow-hidden rounded border border-current px-8 py-2 text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
            :href="`/leaverequests-print?read=print&&ltype=${ltype}&&date=${month}`" target="_blank">
            <span class="absolute -start-full transition-all group-hover:start-4">
              <icon name="backarrow" />
            </span>
            <span class="text-sm font-medium transition-all group-hover:ms-4">
              Print Report
            </span>
          </a>
        </div>
        <div class='flex-1 mt-1 text-sm'>
          <text-input type="month" label="Month" v-model="stmonth" @change="getByMonth()"></text-input>
        </div>
      </div>
    </form>
  </div> -->
  <div class="w-full flex-auto">
     <span>
      <input v-model="search" type="text"
        class="w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Search here.." @keyup="getSearch" />
     </span>
<span>
  <div class=' mt-6 text-sm flex justify-end'>
        <LinkWithIcon :link-route="`/leaverequests/create`" title="Add Request">
          <template #icon>
            +
          </template>
        </LinkWithIcon>
      </div>
</span>
  </div>
  <div class="w-full mb-8 mt-3 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table v-if="leave_requests.data.length" class="w-full whitespace-no-wrap mt-2">
        <thead>
          <tr
            class="text-xs tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-2 py-2">#</th>
            <th class="px-2 py-2">Name</th>
            <th class="px-2 py-2">Requested</th>
            <th class="px-2 py-2">Leave Type</th>
            <th class="px-2 py-2">Start Date</th>
            <th class="px-2 py-2">End Date</th>
            <th class="px-2 py-2"> Days</th>
            <th class="px-2 py-2">
              <center>Position</center>
            </th>
            <th class="px-2 py-2">
              <center>Status</center>
            </th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="leave_request in leave_requests.data" :key="leave_request.id"
            class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2 text-sm">
              {{ leave_request.i }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.user }}
            </td>
            <td class="px-2 py-2 text-xs">
              {{ leave_request.created_at }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.type }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.start_date }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ leave_request.end_date }}
            </td>
            <td class="px-2 py-2 text-sm text-center">
              {{ leave_request.number_of_days }}
            </td>
            <td class="px-2 py-2 text-sm text-center">
              <center> {{ leave_request.position }}</center>
            </td>
            <td class="px-2 py-2 text-sm">
              <center>
                <span v-if="leave_request.status === 'Pending'"
                  class=" px-2 py-1 text-center text-dark-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ leave_request.status }}
                </span>
                <span v-else-if="leave_request.status === 'Approved'"
                  class=" px-2 py-1 text-center text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ leave_request.status }}
                </span>
                <span v-else
                  class=" px-2 py-1 text-center text-red-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ leave_request.status }}
                </span>
              </center>
            </td>
            <Link :href="`/leaverequests/show/${leave_request.reference}`">
            <icon name="list" />
            </Link>
          </tr>
        </tbody>
      </table>
      <p v-if="leave_requests.data.length === 0">No leave request found</p>

    </div>
    <FlashMessages />
    <div v-if="leave_count > 10">
      <pagination class="mt-4" :links="leave_requests.links" />
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
    leave_requests: {
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
    search_data: String,
    leave_count: Number,
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
        this.$inertia.get('/leaverequests/index', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
  getSearch(){
    this.$inertia.get('/leaverequests/index', {
        search: this.search,
    }).then(function(response){
      this.search = this.search_data
    }).bind(this);
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
}</style>
