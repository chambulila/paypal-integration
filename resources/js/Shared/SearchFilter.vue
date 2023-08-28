<template>
  <div class="row">
    <div class="col-12">
      <div class="px-4 py-2 input-group input-group-outline mb-2">
  <!-- <dropdown :auto-close="false" class="focus:z-10 px-4 hover:bg-gray-100 border-r focus:border-white rounded-l focus:ring md:px-6" placement="bottom-start">
        <template #default>
          <div class="flex items-baseline">
            <span class="hidden text-gray-700 md:inline">Filter</span>
            <svg class="w-2 h-2 fill-gray-700 md:ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 961.243 599.998">
              <path d="M239.998 239.999L0 0h961.243L721.246 240c-131.999 132-240.28 240-240.624 239.999-.345-.001-108.625-108.001-240.624-240z" />
            </svg>
          </div>
        </template>
        <template #dropdown>
          <div class="mt-2 px-4 py-6 w-screen bg-white rounded shadow-xl" :style="{ maxWidth: `${maxWidth}px` }">
            <slot />
          </div>
        </template>
      </dropdown> -->
      <input class="form-control" autocomplete="off" type="text" name="search" placeholder="Search Here…" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
    </div>
    <!-- <div class="col-2">
      <div class="input-group input-group-outline mb-4">
    <button class="btn btn-primary"  type="button" @click="$emit('reset')">
        Clear
    </button>
  </div>
</div> -->
</div>
  </div>
</template>

<script>
import Dropdown from './Dropdown'

export default {
  components: {
    Dropdown,
  },
  props: {
    modelValue: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
  emits: ['update:modelValue', 'reset'],
}
</script>
