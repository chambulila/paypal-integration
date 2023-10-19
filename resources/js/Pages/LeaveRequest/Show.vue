<template>
  <div
    class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-5 h-20 w-full rounded font-semibold text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
    <div class=" w-full">
      <div class="mt-2 px-4 py-3 flex justify-end">
        <p class="font-bold text-black text-md dark:text-white mt-2">
          Leave Request Details
        </p>
        <span class="ml-auto flex justify-end space-x-4">
          <SecondaryLink :link-route="`${back_url}`" title="Back"/>
          <SecondaryLink v-if="can_manage" @click="approveStatus(leave_request.reference)" title="Approve"/>
          <DeleteLink v-if="can_manage" class="bg-genered text-white" @click="rejectStatus(leave_request.reference)" title="Reject"/>
        </span>
      </div>
    </div>
  </div>
  <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <table class="text-left">
      <tbody class="bg-white text-sm divide-y dark:divide-gray-700 dark:bg-gray-800">
        <div class="grid grid-cols-2 gap-4">
          <div class="col-span-2">
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-1">
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Name</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.user }}
                  </td>
                </tr>
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Role</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.role }}
                  </td>
                </tr>
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Request For</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.inNeed }}
                  </td>
                </tr>
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Leave Reason</th>
                  <td class="text-left px-4 py-3 text-sm">
                      {{ leave_request.reason }}
                  </td>
                </tr>
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Requested On</th>
                  <td class="text-left px-4 py-3 text-sm">
                      {{ leave_request.created_at }}
                  </td>
                </tr>
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Leave Type</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.type }}
                  </td>
                </tr>
              </div>
              <div class="col-span-1">
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Start Date</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.start_date }}
                  </td>
                </tr>
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">End Date</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ (leave_request.end_date) }}
                  </td>
                </tr>
                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Number of Days</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.number_of_days }}
                  </td>
                </tr>
                  <tr v-if="leave_request.attachment" class=" text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Attachment</th>
                  <td class="text-left px-4 py-3 text-sm">
                    <a :href="'/image/' + leave_request.attachment" target="_blank" class="hover:underline">
                        Open File
                    </a>
                  </td>
                </tr>
                <tr class="text-gray-700 mt-5 dark:text-gray-400">
                  <th class="text-left px-5">Request Status</th>
                  <td class="text-left">
                    <span v-if="leave_request.leavestatus_id === 'Pending'"
                      class="px-2 py-1 font-semibold leading-tight text-dark-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                      {{ leave_request.status }}
                    </span>
                    <span v-else-if="leave_request.leavestatus_id === 'Approved'"
                      class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                      {{ leave_request.status }}
                    </span>
                    <span v-else
                      class="px-2 py-1 font-semibold leading-tight text-red-700 bg-green-100 rounded-full dark:text-white dark:bg-orange-600">
                      {{ leave_request.status }}
                    </span>
                  </td>
                </tr>
              </div>
            </div>
          </div>
          <div class="col-span-2">
            <div class="grid grid-cols-1">
              <div class="col-span-1">


                <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Request Note</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.note }}
                  </td>
                </tr>
              </div>
            </div>
          </div>
        </div>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  props: {
    leave_request: Object,
    back_url: String,
    can_manage: String,
  },
  methods: {
    approveStatus(reference) {
      if (confirm('Approve this request ?')) {
        this.$inertia.get('/leaverequests/approveleavestatus/' + reference)
      }
    },
    rejectStatus(reference) {
      if (confirm('Reject this leave request ?')) {
        this.$inertia.get('/leaverequests/rejectleavestatus/' + reference)
      }
    },
  }
}
</script>
