import Paginate from 'vuejs-paginate';
import FormGroup from './Form/FormGroup.vue';
import LikeButton from './LikeButton.vue';
import CartButton from './CartButton.vue';
import ProductList from './ProductList.vue';
import ProductItem from './ProductItem.vue';

export default {
  install(Vue) {
    Vue.component('like-button', LikeButton);
    Vue.component('cart-button', CartButton);
    Vue.component('pagination-links', Paginate);
    Vue.component('form-group', FormGroup);
    Vue.component('product-list', ProductList);
    Vue.component('product-item', ProductItem);
  }
}
