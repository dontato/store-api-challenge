import VueAuth from '@websanova/vue-auth';

export default {
  install(Vue) {
    Vue.use(VueAuth, {
        auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
        http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
        router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
        notFoundRedirect: {path: '/404'},
        forbiddenRedirect: {path: '/403'},
        authRedirect: {path: '/login'},
        loginData: {url: 'login', method: 'POST', redirect: '/', fetchUser: true},
        fetchData: {url: 'me', method: 'GET', enabled: false},
        refreshData: {url: 'auth/refresh', method: 'POST', enabled: false, interval: 30},
        parseUserData: function (data) {
          return data.data;
        },
        // token: [{request: 'Authorization', response: 'Authorization', authType: 'bearer', foundIn: 'header'}, {request: 'token', response: 'meta.access_token', authType: 'bearer', foundIn: 'response'}]
    });

    Object.defineProperty(Vue.prototype, '$loggedIn', {
      get() {
        return this.$auth.check();
      }
    });

    Object.defineProperty(Vue.prototype, '$guest', {
      get() {
        return !this.$auth.check();
      }
    });

    Object.defineProperty(Vue.prototype, '$authReady', {
      get() {
        return this.$auth.ready();
      }
    });

    Object.defineProperty(Vue.prototype, '$user', {
      get() {
        return this.$auth.user();
      }
    });
  }
}
