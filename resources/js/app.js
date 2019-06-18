import axios from 'axios';

import Vue from 'vue/dist/vue.runtime';
import App from './components/App.vue';

Vue.use(require('./plugins/router').default);
Vue.use(require('./plugins/http').default, axios);
Vue.use(require('./plugins/auth').default);
Vue.use(require('./plugins/validator').default);
Vue.use(require('./plugins/dayjs').default);
Vue.use(require('./plugins/directives').default);
Vue.use(require('./plugins/icons').default);
Vue.use(require('./plugins/notie').default);
Vue.use(require('./components').default);

export default new Vue({
  router: Vue.router,
  render: h => h(App)
}).$mount('#app');
