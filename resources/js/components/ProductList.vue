<template>
  <div class="pt-32 container px-2 md:px-4 mx-auto flex-col justify-between">
    <div v-if="products.length" class="shadow list-group rounded border border-gray-300 bg-white">
      <product-item :product="product" :last-product-in-page="lastProductInPage" v-for="(product, index) in products" :class="{'rounded-t': !index, 'rounded-b': index == lastProductInPage, 'border-b border-grey-300': index !== lastProductInPage}" :key="product.uuid" />
    </div>
    <div class="p-4 bg-gray-300 border border-gray-500 text-gray-600" v-else>
      There were no results.
    </div>
    <div class="py-8 flex justify-center" v-if="meta.lastPage > 1">
      <pagination-links :value="query.page" :click-handler="onPageChange" :page-count="meta.lastPage" container-class="pagination" active-class="active" prev-text="&laquo;" next-text="&raquo;" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    url: {
      type: String,
      default: 'products'
    }
  },
  data() {
    return {
      products: [],
      query: {
        page: 1
      },
      meta: {
        lastPage: 0,
        perPage: 10,
        total: 0
      }
    };
  },
  watch: {
    '$loggedIn'() {
      this.refresh();
    },
    url() {
      this.refresh();
    }
  },
  created() {
    this.refresh();
  },
  computed: {
    totalProductsInPage() {
      return this.products.length;
    },
    lastProductInPage() {
      return this.totalProductsInPage - 1;
    }
  },
  methods: {
    onPageChange (pageNum) {
      this.query.page = pageNum;
      this.refresh();
    },
    async refresh() {
      const response     = await this.$http.get(this.url, {
        params: Object.assign({}, this.query)
      });
      this.products      = response.data.data;
      this.meta.perPage  = response.data.meta.per_page;
      this.meta.lastPage = response.data.meta.last_page;
      this.meta.total    = response.data.meta.total;
    }
  }
}
</script>
