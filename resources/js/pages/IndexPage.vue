<template>
  <div class="pt-32 container mx-auto flex-col justify-between">
    <div class="shadow list-group rounded border border-gray-300 bg-white">
      <div class="p-8 flex items-center justify-between relative" v-for="(product, index) in products" :class="{'rounded-t': !index, 'rounded-b': index == lastProductInPage, 'border-b border-grey-300': index !== lastProductInPage}">
        <div class="flex-1">
          <p class="text-lg uppercase font-display font-bold text-gray-700">{{product.name}}</p>
          <p class="text-sm text-gray-600">{{product.description}}</p>
          <div class="flex -mx-2 pt-2">
            <div class="px-2">
              <like-button :uuid="product.uuid" :liked.sync="product.liked" />
            </div>
            <div class="px-2">
              <!-- <cart-button :uuid="product.uuid" :liked.sync="product.liked" /> -->
            </div>
          </div>
        </div>
        <div class="text-right font-display font-bold font-gray-900 w-32 text-xl flex-none">{{product.price|currency}}</div>

      </div>
    </div>
    <div class="py-8 flex justify-center" v-if="meta.lastPage > 1">
      <pagination-links :value="query.page" :click-handler="onPageChange" :page-count="meta.lastPage" container-class="pagination" active-class="active" prev-text="&laquo;" next-text="&raquo;" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: [],
      query: {
        page: 1,
        term: ''
      },
      meta: {
        lastPage: 0,
        perPage: 10,
        total: 0
      }
    };
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
      const response     = await this.$http.get('products', {
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
