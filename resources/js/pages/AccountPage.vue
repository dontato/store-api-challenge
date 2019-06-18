<template>
  <div class="flex flex-col items-center justify-center w-full px-8">
    <div class="text-center mb-16">
      <router-link class="text-gray-900 text-base text-2xl no-underline hover:no-underline font-bold font-display uppercase" :to="{ name: 'index' }">
        <font-awesome-icon class="text-3xl mr-1" icon="cookie-bite" />
        Snack Store
      </router-link>
    </div>
    <form class="max-w-sm w-full" @submit.prevent="submit">
      <form-group name="name" label="Name">
        <input v-model="data.name" class="form-field" name="name" type="name" placeholder="Name" v-validate="{required: true}">
      </form-group>
      <form-group name="email" label="E-mail">
        <input v-model="data.email" class="form-field" name="email" type="email" placeholder="E-mail" v-validate="{required: true, email: true}">
      </form-group>
      <form-group name="password" label="Password">
        <input v-model="data.password" class="form-field" name="password" type="password" placeholder="Password" v-validate="{regex: /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/ }">
      </form-group>

      <div class="text-center">
        <button class="bg-blue-500 block w-full hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-sm focus:outline-none focus:shadow-outline" type="submit">
          Update account
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import FocusesOnError from '../mixins/FocusesOnError';
import each from 'lodash/each';

export default {
  mixins: [FocusesOnError],
  data() {
    return  {
      data: {
        name: '',
        email: '',
        password: ''
      }
    };
  },
  created() {
    this.data.name  = this.$user.name;
    this.data.email = this.$user.email;
  },
  methods: {
    async submit() {
      const valid = await this.$validator.validate();

      if (!valid) {
        this.focusOnError();
        return;
      }

      return this.update();
    },
    async update() {
      try {
        const response = await this.$http.put('account', this.data);

        this.$auth.user(response.data.data);

        this.$notie.alert({
          text: `Your account was updated`,
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
