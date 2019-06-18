<template>
  <a href @click.prevent="likeOrUnlike" class="no-underline block flex items-center text-sm font-hairline py-2 px-3 border border-red-500 hover:bg-red-500 rounded-sm" :class="{'text-red-500 hover:text-white': !value, 'text-white bg-red-500': value}">
    <font-awesome-icon class="fill-current text-xl" icon="heart" />
    <span class="pl-2 hidden md:block">{{value?'Unlike':'Like'}}</span>
  </a>
</template>

<script>
export default {
  props: {
    uuid: {
      type: String,
      required: true
    },
    value: {
      type: Boolean,
      required: true
    },
    svgClass: {
      type: String,
      default: ''
    }
  },
  computed: {
    url() {
      return `products/${this.uuid}/likes`;
    }
  },
  methods: {
    async likeOrUnlike() {
      var response;

      if (!this.$loggedIn) {
        this.$notie.alert({
          text: 'You must login in order to like products',
          type: 'info'
        })
        return;
      }

      try {
        if (this.value) {
          response = await this.unlike();
        } else {
          response = await this.like();
        }

        this.$emit('input', !this.value)
      } catch (e) {
        console.error(e);
      }
    },
    async like() {
      return await this.$http.post(this.url);
    },
    async unlike() {
      return await this.$http.delete(this.url);
    }
  }
}
</script>
