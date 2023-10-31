<template>
  <!-- Responsive cards -->
  <div class="flex my-3 justify-between bg-sky-100">
    <h4 class="text-lg border-b font-semibold text-gray-600 dark:text-gray-300">
      Hi, Welcome {{ user }}
    </h4>
    <LinkWithIcon :link-route="`/leaverequests/create`" title="Add Leave">
      <template #icon>
        <icon name="plus" />
      </template>
    </LinkWithIcon>
  </div>
  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Card -->
    <div class="flex items-center p-4 bg-gray-50 rounded-lg shadow-xs dark:bg-gray-800 hover:shadow-sm">
      <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
        </svg>
      </div>
      <div>
        <Link :href="'/leaverequests/index'">
        <p class="mb-0 text-sm font-medium text-gray-600 dark:text-gray-400">
          Total
        </p>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
          {{ leave_requests_count }}
        </p>
        </Link>
      </div>
    </div>
    <!-- Card -->
    <div class="flex items-center p-4 bg-gray-50 rounded-lg shadow-xs dark:bg-gray-800 hover:shadow-sm">
      <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
        </svg>
      </div>
      <div>
        <Link :href="'/leaverequests/index?read=approved'">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
          Approved
        </p>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
          {{ approved_requests_count }}
        </p>
        </Link>
      </div>
    </div>
    <!-- Card -->
    <div class="flex items-center p-4 bg-gray-50 rounded-lg shadow-xs dark:bg-gray-800 hover:shadow-sm">
      <div class="p-3 mr-4 text-genedark bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
        </svg>
      </div>
      <div>
        <Link :href="'/leaverequests/index?read=rejected'">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
          Rejected
        </p>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
          {{ rejected_requests_count }}
        </p>
        </Link>
      </div>
    </div>
    <!-- Card -->
    <div class="flex items-center p-4 bg-gray-50 rounded-lg shadow-xs dark:bg-gray-800 hover:shadow-sm">
      <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
        </svg>
      </div>
      <div>
        <Link :href="'/leaverequests/index?read=pending'">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
          Pending
        </p>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
          {{ pending_requests_count }}
        </p>
        </Link>
      </div>
    </div>

    <div class="flex items-center p-4 bg-gray-50 rounded-lg shadow-xs dark:bg-gray-800 hover:shadow-sm">
      <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
        </svg>
      </div>
      <div>
        <Link :href="'/leaverequests/index?read=progress'">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
          In Progress
        </p>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
          {{ progress_requests_count }}
        </p>
        </Link>
      </div>
    </div>
  </div>

  <div class="w-full mb-8 mt-3 overflow-hidden rounded-lg shadow-xs">
    <p class="font-bold px-3 py-2 text-black text-md dark:text-white">
      Pending Requests
    </p>
    <div class="w-full overflow-x-auto">
      <table v-if="pending_requests.length" class="w-full whitespace-no-wrap mt-2">
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-2 py-2">#</th>
            <th class="px-2 py-2">Name</th>
            <th class="px-2 py-2">Requested</th>
            <th class="px-2 py-2">Leave Type</th>
            <th class="px-2 py-2">Start Date</th>
            <th class="px-2 py-2">End Date</th>
            <th class="px-2 py-2">
              <center>Days</center>
            </th>
            <th class="px-2 py-2">
              <center>Status</center>
            </th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="(leave_request, pIndex) in pending_requests" :key="pIndex" class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2 text-sm">
              {{ leave_request.sn }}
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
              <center>{{ leave_request.number_of_days }}</center>
            </td>
            <td class=" text-center">
              <center>
                <span v-if="leave_request.status === 'Pending'"
                  class=" px-2 py-1  text-dark-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ leave_request.status }}
                </span>
                <span v-else-if="leave_request.status === 'Approved'"
                  class=" px-2 py-1  text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ leave_request.status }}
                </span>
                <span v-else
                  class=" px-2 py-1  text-red-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                  {{ leave_request.status }}
                </span>
              </center>
            </td>
            <td class=" text-center">
              <center>
                <Link :href="`/leaverequests/show/${leave_request.reference}`">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                </Link>
              </center>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-if="pending_requests.length === 0">No leave request found</p>
    </div>
  </div>
</template>

<script>
import SecondaryButton from '../../Shared/Buttons/SecondaryButton'
import Icon from '../../Shared/Icon'

export default {
  components: {
    SecondaryButton,
    Icon,
  },
  props: {
    leave_requests_count: {
      type: Number,
      required: true,
    },
    user: String,
    approved_requests: {
      type: Object,
      required: true,
    },
    pending_requests: {
      type: Object,
      required: true,
    },
    approved_requests_count: Number,
    pending_requests_count: Number,
    rejected_requests_count: Number,
    progress_requests_count: Number,
  },

};
</script>