import IndexPage from './pages/IndexPage.vue';

const routes = [
  {
    name: 'index',
    path: '/',
    component: IndexPage,
    meta: {
      title: 'Home',
      hideSearch: true
    }
  }
];

export default routes;
