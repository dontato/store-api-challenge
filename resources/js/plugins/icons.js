import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
  faHome,
  faShoppingCart,
  faShoppingBag,
  faSearch,
  faCaretDown,
  faCookieBite,
  faBars
} from '@fortawesome/free-solid-svg-icons';

library.add(
  faHome, faShoppingCart, faShoppingBag, faSearch, faCaretDown, faCookieBite,
  faBars
);

export default {
  install(Vue) {
    Vue.component('font-awesome-icon', FontAwesomeIcon);
  }
}
