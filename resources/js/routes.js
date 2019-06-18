import IndexPage from './pages/IndexPage.vue';
import LoginPage from './pages/LoginPage.vue';
import AccountPage from './pages/AccountPage.vue';

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
    name: 'account',
    path: '/account',
    component: AccountPage,
    meta: {
      title: 'Update My Account',
      nav: false,
      auth: true,
    }
  }
];

export default routes;
