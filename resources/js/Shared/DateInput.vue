<template>
  <div class="col-6">
    <div class="input-group input-group-outline">
      <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
      <input :id="id"  ref="input" v-bind="{ ...$attrs, class: null }" class="form-control" :class="{ error: error }" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
      <div v-if="error" class="input-group input-group-outline is-invalid my-3">{{ error }}</div>
  </div>
</div>
</template>


<script>
import { v4 as uuid } from 'uuid'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `date-input-${uuid()}`
      },
    },
    type: {
      type: Date,
      default: 'date',
    },
    error: String,
    label: String,
    modelValue: String,
  },
  emits: ['update:modelValue'],
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end)
    },
  },
}
</script>
