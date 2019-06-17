// import VeeValidate from 'vee-validate';
import { Validator, install as VeeValidate } from 'vee-validate/dist/vee-validate.minimal.esm.js';
import { required, min, max, min_value, max_value, email, numeric } from 'vee-validate/dist/rules.esm.js';

Validator.extend('email', email);
Validator.extend('min', min);
Validator.extend('max', max);
Validator.extend('min_value', min_value);
Validator.extend('max_value', max_value);
Validator.extend('required', required);
Validator.extend('numeric', numeric);

export default {
  install(Vue) {
    Vue.use(VeeValidate);
  }
}
