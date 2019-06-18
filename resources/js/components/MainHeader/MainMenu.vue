<template>
  <ul class="list-reset md:flex flex-1 items-center px-4 md:px-0">
    <menu-item :link="{name: 'index'}">
      <font-awesome-icon slot="icon" icon="home" />
      Home
    </menu-item>
    <menu-item class="relative" :link="{name: 'cart'}">
      <font-awesome-icon slot="icon" icon="shopping-cart" />
      My Cart
      <span v-if="$root.cart.length" class="top-0 right-0 -mr-3 bg-red-500 text-white rounded-full text-xs w-4 h-4 absolute text-center">{{$root.cart.length}}</span>
    </menu-item>
    <menu-item :link="{name: 'liked'}">
      <font-awesome-icon slot="icon" icon="heart" />
      Liked Products
    </menu-item>
  </ul>
</template>

<script>
import MenuItem from './MenuItem.vue';

export default {
  components: {MenuItem},
  data() {
    return {
      items: {

      }
    };
  }
}
</script>
