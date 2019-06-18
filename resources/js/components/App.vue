<template>
  <div class="flex flex-col min-h-screen bg-gray-300 font-body">
    <transition
      enter-active-class="animated fadeInDown"
      leave-active-class="animated fadeOutUp">
      <main-header v-if="$route.meta.nav" />
    </transition>
    <router-view class="flex-1 flex" :key="$route.fullPath"></router-view>
    <div class="flex-none text-center w-full">
      <div class="container mx-auto text-sm text-gray-500 border-t border-gray-400 py-3">
        &copy; {{year}}. All rights reserved
      </div>
    </div>
  </div>
</template>

<script>
import MainHeader from './MainHeader.vue';

export default {
  components: {MainHeader},
  data() {
    return {
      year: (new Date).getFullYear()
    };
  }
}
</script>
