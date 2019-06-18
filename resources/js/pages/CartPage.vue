<template>
  <div class="pt-32 container px-2 md:px-4 mx-auto flex-col">
    <div v-if="$root.cart.length" class="shadow list-group rounded border border-gray-300 bg-white">
      <div class="p-8 flex flex-wrap items-center relative" v-for="(item, index) in $root.cart">
        <div class="flex-1">
          <p class="text-lg uppercase font-display font-bold text-gray-700">{{item.product.name}}</p>
          <p class="text-sm text-gray-600">{{item.product.description}}</p>
          <p class="text-xs text-gray-600"><strong>Stock:</strong> {{item.product.stock}}</p>
        </div>
        <div class="text-right font-display font-bold font-gray-900 w-32 text-xl flex-none">{{item.product.price|currency}}</div>
        <div class="flex w-full -mx-2 pt-2">
          <div class="px-2">
            <like-button :uuid="item.product.uuid" v-model="item.product.liked" />
          </div>
          <div class="px-2">
            <cart-button :product="item.product" :use-in-cart="true" />
          </div>
          <div class="px-2 flex items-center">
            <a href @click.prevent="removeFromCart(item.product)" class="text-grey-500">
              <font-awesome-icon class="fill-current text-xl" icon="times" />
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="p-4 bg-gray-300 border border-gray-500 text-gray-600" v-else>
      There are no products in your cart.
    </div>
    <div class="py-4" v-if="$loggedIn">
      <button class="bg-blue-500 block w-full hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-sm focus:outline-none focus:shadow-outline" type="button" @click="placeOrder">
        Place your order
      </button>
    </div>
    <div class="mt-4 p-4 bg-gray-300 border border-gray-500 text-gray-600" v-else>
      You must <router-link class="text-purple-500" :to="{ name: 'login'}">login</router-link> to place your order
    </div>
  </div>
</template>

<script>
import map from 'lodash/map';
export default {
  computed: {
    totalProductsInPage() {
      return this.$root.cart.length;
    },
    lastProductInPage() {
      return this.totalProductsInPage - 1;
    }
  },
  methods: {
    removeFromCart(product) {
      this.$root.removeFromCart(product)
    },
    placeOrder() {
      this.$notie.confirm({
        text: 'Are you sure you want to place your order?'
      }, async () => {
        try {
          var items    = map(this.$root.cart, (item) => {
            return {uuid: item.uuid, quantity: item.quantity};
          });
          var response = await this.$http.post('orders', {items});
          this.$notie.alert({
            type: 'success',
            text: `Your order was placed`
          });
          this.$root.emptyCart();
        } catch (e) {
          this.$notie.alert({
            type: 'error',
            text: `Something went wrong`
          });
        }
      });
    }
  }
}
</script>
