import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
  faHome,
  faShoppingCart,
  faShoppingBag,
  faSearch,
  faCaretDown,
  faCookieBite,
  faBars,
  faPlus,
  faHeart
} from '@fortawesome/free-solid-svg-icons';

library.add(
  faHome, faShoppingCart, faShoppingBag, faSearch, faCaretDown, faCookieBite,
  faBars, faPlus, faHeart
);

export default {
  install(Vue) {
    Vue.component('font-awesome-icon', FontAwesomeIcon);
  }
}
