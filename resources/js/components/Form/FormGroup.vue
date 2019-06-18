<template>
  <div class="form-group" :class="{'has-error': !!error}">
    <label class="form-label">
      {{label}}
    </label>
    <slot></slot>
    <p v-if="!!error" class="text-red-500 text-xs italic">{{error}}</p>
  </div>
</template>

<script>
export default {
  inject: ['$validator'],
  props: {
    label: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: false,
      default: ''
    },
  },
  computed: {
    error() {
      return this.name ? this.errors.first(this.name) : false;
    }
  }
}
</script>
