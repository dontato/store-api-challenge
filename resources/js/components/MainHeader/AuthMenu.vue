<template>
  <div class="relative text-sm" v-click-outside="closeMenu">
    <button @click="toggleMenu" class="flex items-center focus:outline-none mr-3">
      Hi, {{$user.name}}
      <font-awesome-icon icon="caret-down" class="ml-2 text-lg" />
    </button>
    <transition
      enter-active-class="animated fadeInDown"
      leave-active-class="animated fadeOutUp">
      <div class="w-32 bg-white rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30" v-if="open">
        <ul class="list-reset">
          <li><router-link class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline" :to="{ name: 'account' }">My account</router-link></li>
          <li><hr class="border-t mx-2 my-0 border-gray-400"></li>
          <li><a href @click.prevent="logout" class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Logout</a></li>
        </ul>
      </div>
    </transition>
  </div>
</template>

<script>
import HasMenu from '../../mixins/HasMenu';

export default {
  mixins: [HasMenu],
  methods: {
    logout() {
      this.$auth.logout({
        makeRequest: false,
        redirect: '/'
      });
    }
  }
}
</script>
