import ClickOutside from 'vue-click-outside';

export default {
  install(Vue) {
    Vue.directive('click-outside', ClickOutside);
  }
}
