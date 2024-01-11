<template>
  <div
    class="flex items-center justify-between p-2 my-4 text-sm text-blue-100 bg-gray-800 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
    href="#">
    <div class="flex items-center">
      <icon name="stack" />
      <span class="pl-4">List of Payments</span>
    </div>
    <a :href="'/payments/dashboard'" title="Go Back">
      Go Back &RightArrow;
    </a>
  </div>
  <div class="w-full flex-auto">
    <span>
      <input v-model="search" type="text"
        class="w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Search here.." @keyup="getSearch" />
    </span>
  </div>
  <div class="w-full mb-8 mt-3 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table v-if="payments.data.length" class="w-full whitespace-no-wrap mt-2">
        <thead>
          <tr
            class="text-xs tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-2 py-2">#</th>
            <th class="px-2 py-2">Payer</th>
            <th class="px-2 py-2">Amount</th>
            <th class="px-2 py-2">Currency</th>
            <th class="px-2 py-2">Date</th>
            <th class="px-2 py-2">
              <center>Status</center>
            </th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="payment in payments.data" :key="payment.id" class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2 text-sm">
              {{ payment.i }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ payment.payer }}
            </td>
            <td class="px-2 py-2 text-xs">
              {{ payment.amount }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ payment.currency }}
            </td>
            <td class="px-2 py-2 text-sm">
              {{ payment.date }}
            </td>
            <td class="px-2 py-2 text-sm">
              <center>
                <span v-if="payment.status === 'PARTIAL'"
                  class=" px-2 py-1 text-center text-dark-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ payment.status }}
                </span>
                <span v-else-if="payment.status === 'COMPLETED'"
                  class=" px-2 py-1 text-center text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ payment.status }}
                </span>
                <span v-else
                  class=" px-2 py-1 text-center text-red-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ payment.status }}
                </span>
              </center>
            </td>
            <Link :href="`/payments/show/${payment.uuid}`">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            </Link>
          </tr>
        </tbody>
      </table>
      <p v-if="payments.data.length === 0">No payments data found</p>

    </div>
    <FlashMessages />
    <div v-if="payment_count > 10">
      <pagination class="mt-4" :links="payments.links" />
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
    payments: {
      type: Object,
      required: true,
    },
    filters: {
      type: Object,
      required: true,
    },
    back_url: String,
    payment_count: Number,
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
        this.$inertia.get('/payments', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    getSearch() {
      this.$inertia.get('/payments', {
        search: this.search,
      }).then(function (response) {
        this.search = this.search_data
      }).bind(this);
    },
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    getByType: function () {
      this.show = true;
      this.$inertia.get('/payments', {
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
      this.$inertia.get('/payments', {
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
