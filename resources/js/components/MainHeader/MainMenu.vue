<template>
  <ul class="list-reset md:flex flex-1 items-center px-4 md:px-0">
    <menu-item :link="{name: 'index'}">
      <font-awesome-icon slot="icon" icon="home" />
      Home
    </menu-item>
    <menu-item :link="{name: 'cart'}">
      <font-awesome-icon slot="icon" icon="shopping-cart" />
      My Cart
    </menu-item>
    <!-- <menu-item :link="{name: 'orders'}">
      <font-awesome-icon slot="icon" icon="shopping-bag" />
      My Orders
    </menu-item> -->
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
