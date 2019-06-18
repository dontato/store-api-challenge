<template>
  <div class="pt-32 container px-2 md:px-4 mx-auto flex-col justify-between">
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
  </div>
</template>

<script>
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
    }
  }
}
</script>
