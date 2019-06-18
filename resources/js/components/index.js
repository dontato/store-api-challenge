import Paginate from 'vuejs-paginate';
import FormGroup from './Form/FormGroup.vue';

export default {
  install(Vue) {
    Vue.component('pagination-links', Paginate);
    Vue.component('form-group', FormGroup);
  }
}
