<template>
    <br>
    <a class="flex items-center justify-between p-4 mb-4 text-sm font-semibold text-purple-100 bg-genedark rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
        href="/dashboard">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                </path>
            </svg>
            <span>Star this project on GitHub</span>
        </div>
        <span>View more &RightArrow;</span>
    </a>
    <div class="px-2 py-2 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <!-- With avatar -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Table with avatars  <button @click="open = true"  class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-genedark border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-genedark hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Open Modal
                        </button> <br><br><br><br><br><br><br><br><br><br>
        </h4>
        <div class="block mt-4 text-sm">
            <div v-if="open" class="modal">
                <div 
                   class="w-full px-4 py-2 overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                    role="dialog" id="modal">
                    <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                    <header class="flex justify-end">
                        <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                        </button>
                    </header>
                    <!-- Modal body -->
                    <div class="mt-4 mb-6">
                        <!-- Modal title -->
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                            Modal header
                        </p>
                        <!-- Modal description -->
                        <p class="text-sm text-gray-700 dark:text-gray-400">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum et
                            eligendi repudiandae voluptatem tempore!
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-400">
                            This is possibly the most accessible a modal can get , using JavaScript. When opened, it uses assets/js/focus-trap.js to create a focus trap , which means that if you use your keyboard to navigate around, focus won't leak to the elements behind, staying inside the modal in a loop, until you take any action.
                        </p>
                    </div>
                    <footer class="flex flex-col items-center justify-end px-6 py-4 -mx-6 mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                        <button @click="open = false"  class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                            Cancel
                        </button>
                        <button @click="open = false"  class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-genedark border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-genedark hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Accept
                        </button>
                        <br>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            open: false
        }
    }
}
</script>

<style scoped>
.modal {
    position: fixed;
    z-index: 999;
    top: 20%;
    left: 50%;
    width: 100%;
    margin-left: -220px;
}
</style>
