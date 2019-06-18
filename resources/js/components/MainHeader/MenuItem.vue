<template>
  <li class="mr-6 my-2 md:my-0">
    <router-link class="block py-1 md:py-3 pl-1 align-middle no-underline hover:text-gray-900 border-b-2" :class="linkClass" :to="link">
      <slot name="icon"></slot>
      <span class="pb-1 md:pb-0 text-sm">
        <slot></slot>
      </span>
    </router-link>
  </li>
</template>

<script>
export default {
  props: {
    link: {
      type: Object,
      required: true
    }
  },
  computed: {
    active() {
      return this.$route.name == this.link.name;
    },
    linkClass() {
      return {
        'text-orange-600 border-orange-600': this.active,
        'text-gray-500 border-white hover:border-purple-500': !this.active
      }
    }
  }
}
</script>
