<template>
  <div class="flex">
    <number-input-spinner
      :min="1"
      :max="product.stock"
      :integerOnly="true"
      v-model="quantity"
    />
    <a href @click.prevent="addToCart" class="no-underline block flex items-center text-sm font-hairline py-2 px-3 border border-teal-700 hover:bg-teal-700 rounded-r-sm border-l-0 text-teal-700 hover:text-white" >
      <font-awesome-icon class="fill-current text-xl" icon="shopping-cart" />
      <span class="pl-2 hidden md:block">Añadir</span>
    </a>
  </div>
</template>

<script>
import NumberInputSpinner from 'vue-number-input-spinner';

export default {
  components: {
    NumberInputSpinner,
  },
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      quantity: 1
    }
  },
  methods: {
    addToCart() {
      this.$root.addToCart(this.product, this.quantity);
    }
  }
}
</script>
