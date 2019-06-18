<template>
  <div class="p-8 flex flex-wrap items-center relative">
    <div class="flex-1">
      <p class="text-lg uppercase font-display font-bold text-gray-700">{{product.name}}</p>
      <p class="text-sm text-gray-600">{{product.description}}</p>
      <p class="text-xs text-gray-600"><strong>Stock:</strong> {{product.stock}}</p>
    </div>
    <div class="text-right font-display font-bold font-gray-900 w-32 text-xl flex-none">{{product.price|currency}}</div>
    <div class="flex w-full -mx-2 pt-2">
      <div class="px-2">
        <like-button :uuid="product.uuid" v-model="product.liked" />
      </div>
      <div class="px-2">
        <cart-button :product="product" />
      </div>
    </div>
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
  }
}
</script>
