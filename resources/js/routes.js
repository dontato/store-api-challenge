import IndexPage from './pages/IndexPage.vue';
import LoginPage from './pages/LoginPage.vue';

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
  }
];

export default routes;
