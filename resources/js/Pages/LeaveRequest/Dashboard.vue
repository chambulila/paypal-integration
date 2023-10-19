<template>
  <!-- Responsive cards -->
 <div class="flex my-3 justify-between">
  <h4 class="text-lg border-b font-semibold text-gray-600 dark:text-gray-300">
    Leave Requests Dashboard
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
        <icon name="exit" />
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
        <icon name="approved" />
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
       <icon name="reject"/>
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
        <icon name="widgets" />
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
            <th class="px-2 py-2">Name</th>
            <th class="px-2 py-2">Requested</th>
            <th class="px-2 py-2">Leave Type</th>
            <th class="px-2 py-2">Start Date</th>
            <th class="px-2 py-2">End Date</th>
            <th class="px-2 py-2"> Days</th>
            <th class="px-2 py-2">Status</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="(leave_request, pIndex) in pending_requests" :key="pIndex" class="text-gray-700 dark:text-gray-400">
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
            <td class="text-center">
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
            </td>
            <Link :href="`/leaverequests/show/${leave_request.reference}`">
            <icon name="list" />
            </Link>
          </tr>
        </tbody>
      </table>
      <p v-if="pending_requests.length === 0">No leave request found</p>
    </div>
  </div>
</template>

<script>
import SecondaryButton from '../../Shared/Buttons/SecondaryButton'

export default {
  components: {
    SecondaryButton,
  },
  props: {
    leave_requests_count: {
      type: Number,
      required: true
    },
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
  },

};
</script>