import Paginate from 'vuejs-paginate';
import FormGroup from './Form/FormGroup.vue';
import LikeButton from './LikeButton.vue';

export default {
  install(Vue) {
    Vue.component('like-button', LikeButton);
    Vue.component('pagination-links', Paginate);
    Vue.component('form-group', FormGroup);
  }
}
