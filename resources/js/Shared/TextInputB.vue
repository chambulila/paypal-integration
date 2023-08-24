<template>
  <div class="col-6">
    <div class="input-group input-group-dynamic mb-4">
      <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
      <input :id="id" ref="input" v-bind="{ ...$attrs, class: null }" class="form-control" :class="{ error: error }" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
      <div v-if="error" class="form-error">{{ error }}</div>
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
        return `text-inputb-${uuid()}`
      },
    },
    type: {
      type: String,
      default: 'text',
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
