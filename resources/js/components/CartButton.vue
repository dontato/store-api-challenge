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
      <span class="pl-2 hidden md:block">Add to Cart</span>
    </a>
    <div class="text-xs flex items-center pl-2 text-gray-500" v-if="showInCart">
      <strong>Already in cart:&nbsp;</strong>
      {{quantityInCart}}
    </div>
  </div>
</template>

<script>
import find from 'lodash/find';
import NumberInputSpinner from 'vue-number-input-spinner';

export default {
  components: {
    NumberInputSpinner,
  },
  props: {
    product: {
      type: Object,
      required: true
    },
    useInCart: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      quantity: 1
    };
  },
  computed: {
    quantityInCart() {
      return (find(this.$root.cart, {uuid: this.product.uuid}) || {quantity: 0}).quantity;
    },
    showInCart() {
      return this.quantityInCart > 0 && !this.useInCart;
    }
  },
  created() {
    if (this.useInCart) {
      this.quantity = this.quantityInCart;
    }
  },
  methods: {
    addToCart() {
      var amount = this.useInCart ? this.quantity - this.quantityInCart : this.quantity;
      this.$root.addToCart(this.product, amount);
      console.log(this.$root.cart)
    }
  }
}
</script>
