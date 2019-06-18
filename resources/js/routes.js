import IndexPage from './pages/IndexPage.vue';
import LoginPage from './pages/LoginPage.vue';
import RegisterPage from './pages/RegisterPage.vue';
import AccountPage from './pages/AccountPage.vue';
import CartPage from './pages/CartPage.vue';
import LikedPage from './pages/LikedPage.vue';

const routes = [
  {
    name: 'index',
    path: '/',
    component: IndexPage,
    meta: {
      title: 'Home',
      nav: true
    }
  },
  {
    name: 'login',
    path: '/login',
    component: LoginPage,
    meta: {
      title: 'Login',
      nav: false,
      auth: false,
    }
  },
  {
    name: 'register',
    path: '/register',
    component: RegisterPage,
    meta: {
      title: 'Register',
      nav: false,
      auth: false,
    }
  },
  {
    name: 'account',
    path: '/account',
    component: AccountPage,
    meta: {
      title: 'Update My Account',
      nav: false,
      auth: true,
    }
  },
  {
    name: 'cart',
    path: '/cart',
    component: CartPage,
    meta: {
      title: 'My Cart',
      nav: true
    }
  },
  {
    name: 'liked',
    path: '/liked',
    component: LikedPage,
    meta: {
      title: 'Liked Products',
      nav: true,
      auth: true,
    }
  }
];

export default routes;
