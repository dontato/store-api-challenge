<template>
  <div class="flex flex-col items-center justify-center w-full px-8">
    <div class="text-center mb-16">
      <router-link class="text-gray-900 text-base text-2xl no-underline hover:no-underline font-bold font-dosis" :to="{ name: 'index' }">
        <font-awesome-icon class="text-3xl mr-1" icon="cookie-bite" />
        Snack Store
      </router-link>
    </div>
    <form class="max-w-sm w-full" @submit.prevent="submit">
      <form-group name="email" label="E-mail">
        <input v-model="data.email" class="form-field" name="email" type="email" placeholder="E-mail" v-validate="{required: true, email: true}">
      </form-group>
      <form-group name="password" label="Password">
        <input v-model="data.password" class="form-field" name="password" type="password" placeholder="Password" v-validate="{required: true}">
      </form-group>

      <div class="text-center mb-4">
        <button class="bg-blue-500 block w-full hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-sm focus:outline-none focus:shadow-outline" type="submit">
          Sign In
        </button>
      </div>

      <div class="text-center mb-2 text-xs">
        Don&#039;t have an account yet?
      </div>
      <div class="text-center">
        <router-link :to="{name: 'register'}" class="bg-gray-300 block w-full hover:bg-gray-400 text-blue-500 border border-gray-500 text-sm py-2 px-4 rounded-sm focus:outline-none focus:shadow-outline" >
          Sign Up
        </router-link>
      </div>


    </form>
  </div>
</template>

<script>
import FocusesOnError from '../mixins/FocusesOnError';

export default {
  mixins: [FocusesOnError],
  data() {
    return  {
      data: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    async submit() {
      const valid = await this.$validator.validate();

      if (!valid) {
        this.focusOnError();
        return;
      }

      return this.login();
    },
    async login() {
      try {
        const response = await this.$auth.login({
          data: this.data
        });

        this.$notie.alert({
          text: `Welcome, ${response.data.data.name}`,
          type: 'success'
        });
      } catch (e) {
        each(e.response.data.errors || [], (errors, field)  => {
          this.errors.add({field, msg: errors[0]});
        });

        this.focusOnError();

        this.$notie.alert({
          text: 'Wrong credentials',
          type: 'error'
        });
      }
    },
  }
}
</script>
