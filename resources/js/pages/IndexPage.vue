<template>
  <product-list :url="url"></product-list>
</template>

<script>
export default {
  computed: {
    url() {
      var term = null;

      if (this.$route.query) {
        term = this.$route.query.term || null;
      }

      return 'products' + (term ? `?term=${term}` : '');
    }
  }
}
</script>
