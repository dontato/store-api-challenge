<template>
  <nav id="header" class="bg-white fixed w-full z-10 top-0 shadow">
    <div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">
      <div class="flex-none pl-2 md:pl-0">
        <router-link class="text-gray-900 text-base xl:text-xl no-underline hover:no-underline font-bold font-display uppercase" :to="{ name: 'index' }">
          <font-awesome-icon class="text-xl mr-1" icon="cookie-bite" />
          Snack Store
        </router-link>
      </div>
      <div class="flex-1 pr-0">
        <div class="flex items-center justify-end relative">
          <auth-menu v-if="$loggedIn" />
          <template v-else>
            <div class="block pr-2">
              <router-link class="leading-none text-sm inline-block px-3 py-2 border rounded text-white bg-green-500 border-green-600 hover:text-gray-100 hover:border-green-900 hover:bg-green-800 focus:outline-none" :to="{ name: 'login' }">Sign In</router-link>
            </div>
            <div class="block pr-2 md:pr-0">
              <router-link class="leading-none text-sm inline-block px-3 py-2 border rounded text-white bg-blue-500 border-blue-600 hover:text-gray-100 hover:border-blue-900 hover:bg-blue-800 focus:outline-none" :to="{ name: 'register' }">Sign Up</router-link>
            </div>
          </template>
          <div class="block md:hidden pr-2 md:pr-0">
            <button @click="toggleMenu" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-teal-500 appearance-none focus:outline-none">
              <font-awesome-icon icon="bars" class="fill-current" />
            </button>
          </div>
        </div>
      </div>
      <div class="w-full flex-grow md:flex md:items-center lg:w-full md:block mt-2 md:mt-0 bg-white z-20" :class="{hidden: !open}">
        <main-menu />
        <div class="relative pull-right pl-4 pr-4 md:pr-0">
          <input v-model="term" type="search" placeholder="Search" class="w-full bg-gray-100 text-sm text-gray-800 transition border focus:outline-none focus:border-gray-700 rounded py-1 px-2 pl-10 appearance-none leading-normal">
          <div class="absolute search-icon flex items-center inset-y-0 left-0 pl-6">
            <font-awesome-icon icon="search" />
          </div>
        </div>
      </div>
    </div>
  </nav>

</template>

<script>
import MainMenu from './MainHeader/MainMenu.vue';
import AuthMenu from './MainHeader/AuthMenu.vue';
import HasMenu from '../mixins/HasMenu';
import debounce from 'lodash/debounce';

export default {
  components: {MainMenu, AuthMenu},
  mixins: [HasMenu],
  data() {
    return {term: ''};
  },
  watch: {
    term: debounce(function (term) {
      if (term) {
        this.$router.push({
          name: 'index',
          query: {term}
        })
      } else {
        this.$router.push({
          name: 'index'
        })
      }
    }, 500)
  }
}
</script>
