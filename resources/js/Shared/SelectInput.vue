<template>
  <div class="col-6">
    <div class="input-group input-group-static mb-4">
      <label v-if="label"  :for="id">{{ label }}:</label>
      <select :id="id" ref="input" v-model="selected" v-bind="{ ...$attrs, class: null }" class="form-control px-3" :class="{ error: error }">
        <slot />
      </select>
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
        return `select-input-${uuid()}`
      },
    },
    error: String,
    label: String,
    modelValue: [String, Number, Boolean],
  },
  emits: ['update:modelValue'],
  data() {
    return {
      selected: this.modelValue,
    }
  },
  watch: {
    selected(selected) {
      this.$emit('update:modelValue', selected)
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>
