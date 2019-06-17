import VueAxios from 'vue-axios';

export default {
  install(Vue, axios) {
    axios.defaults.baseURL = '/api';
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    let token = document.head.querySelector('meta[name="csrf-token"]');

    // send the x-csrf-token, just incase
    if (token) {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
      console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    // define Vue.axios required for vue-auth
    Vue.use(VueAxios, axios);
  }
}
