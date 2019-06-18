import each from 'lodash/each';
import find from 'lodash/find';
import findIndex from 'lodash/findIndex';

export default {
  data() {
    return {
      cart: []
    };
  },
  created() {
    try {
      each(JSON.parse(window.localStorage.cart), (item) => {
        this.cart.push(item);
      })
    } catch (e) {
      this.cart = [];
    }

    this.persistCart();
  },
  methods: {
    addToCart(product, quantity) {
      var item  = find(this.products, {uuid: product.uuid}) || {quantity: 0};
      var index = findIndex(this.products, {uuid: product.uuid});

      if (item.stock < (item.quantity + quantity)) {
        this.$notie.alert({
          text: 'There is not enough stock to order that quantity',
          type: 'error'
        })
        return;
      }

      if (index < 0) {
        this.cart.push({quantity, uuid: product.uuid, product});
      } else {
        quantity += item.quantity;
        this.cart[index] = {quantity, product, uuid: product.uuid};
      }

      this.$notie.alert({
        type: 'success',
        text: `${product.name} added to cart`
      });

      this.persistCart();
    },
    removeFromCart(product) {
      var index = findIndex(this.products, {uuid: product.uuid});

      this.$notie.confirm({
        text: 'Are you sure you want to remove this product from your cart?'
      });

      if (index > -1) {
        this.cart.slice(index, 1);
      }

      this.persistCart();

      this.$notie.alert({
        type: 'success',
        text: `${product.name} removed from cart`
      });
    },
    persistCart() {
      window.localStorage.setItem('cart', JSON.stringify(this.cart));
    }
  }
}
