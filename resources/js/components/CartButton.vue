<template>
  <a href @click.prevent class="no-underline block flex items-center text-sm font-hairline py-2 px-3 border border-red-500 hover:bg-red-500 rounded-sm" :class="{'text-red-500 hover:text-white': !liked, 'text-white': liked}">
    <font-awesome-icon class="fill-current text-xl" :class="svgClass" icon="heart" />
    <span class="pl-2 hidden md:block">{{liked?'Unlike':'Like'}}</span>
  </a>
</template>

<script>
export default {
  props: {
    uuid: {
      type: String,
      required: true
    },
    liked: {
      type: Boolean,
      required: true
    },
    svgClass: {
      type: String,
      default: ''
    }
  }
}
</script>
