import notie from 'notie';

export default {
  install(Vue) {
    Object.defineProperty(Vue.prototype, '$notie', {
      get() {
        return notie;
      }
    });
  }
}
