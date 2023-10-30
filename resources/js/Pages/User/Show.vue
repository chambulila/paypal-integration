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
          <SecondaryLink v-if="canManage"  @click="showModal(leave_request.reference, 1)" title="Approve"/>
          <DeleteLink v-if="canManage" class="bg-genered text-black hover:text-white" @click="showModal(leave_request.reference, 2)" title="Reject"/>
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
                <!-- <tr class="text-gray-700  dark:text-gray-400">
                  <th class="text-left px-5">Request For</th>
                  <td class="text-left px-4 py-3 text-sm">
                    {{ leave_request.inNeed }}
                  </td>
                </tr> -->
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


       <!-- modal for filter per single student -->
       <div v-if="openModal" class="modal overflow-y-auto">
        <div id="modal"
            class="w-xl px-4 py-2 mb-5 border-b overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog">
            <form @submit.prevent="approve_reject()">
                <label class="block mt-1 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Request Note</span>
                <textarea required
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-blue-500 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="6" placeholder="Tell something about leave" v-model="form.accept_reject_reason"></textarea>
            </label>

                <footer
                    class="flex flex-col items-center justify-end px-6 py-2 -mx-6 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                    <div class="flex items-center justify-end px-8 py-4 border-t border-gray-100">
                        <PrimaryButton type="submit" :disabled="!form.accept_reject_reason">Submit Request</PrimaryButton>
                    </div>
                    <button
                        class="w-full px-5 py-3 text-sm font-medium leading-5  text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                        @click="openModal = false">
                        Cancel
                    </button>
                </footer>
            </form>
        </div>
    </div>
</template>
<script>
import TextareaInput from "../../Shared/TextareaInput"
import { ref } from 'vue';

export default {
  components: {
    TextareaInput,
  },
  props: {
    leave_request: Object,
    back_url: String,
    can_manage: String,
    canManage: Boolean,
  },
  data(){
    return {
      openModal: false,
      reference: '',
      action: '',
    }
  },
  setup(){
    const form = ref({
      accept_reject_reason: ''
    });
    return { form }
  },
  methods: {
    showModal(reference, number){
      if (number == 1) {
        this.action = "approve"
      } else if(number == 2) {
        this.action = "reject"
      }
    this.openModal = true;
    this.reference = reference;
  },
    approve_reject() {
      if (confirm('Approve this request ?')) {
        this.$inertia.post('/leaverequests/approve-reject-leave', {
          reference: this.reference,
          accept_reject_reason: this.form.accept_reject_reason,
          action: this.action
        });
      }
      this.form.accept_reject_reason = '';
      this.openModal = false;
    },

  }
}
</script>
<style scoped>
.modal {
    position: fixed;
    z-index: 999;
    top: 15%;
    left: 25%;
    width: 100%;
}

@media screen and (max-width: 992px) {
    .modal {
        left: 1%;
        right: 1%;
    }
}

/* On screens that are 600px or less, set the background color to olive */
@media screen and (max-width: 600px) {
    .modal {
        right: 1%;
        left: 1%;
    }
}
</style>