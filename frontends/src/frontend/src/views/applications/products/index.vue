<template>
  <panel>
    <product-click-form-modal
      ref="productClickFormModal"
      @reload="fetchProducts"
    />

    <data-table-local
      :columns="_columns"
      :items="products"
      @clickNew="clickNew"
      @clickEdit="clickEdit"
      @clickDelete="clickDelete"
      :viewAble="false"
    />
  </panel>
</template>

<script>
export default {
  components: {
    productClickFormModal: () => import('./components/productClickFormModal'),
  },
  computed: {
    _columns() {
      return [
        {
          label: 'Product Code',
          field: 'code',
          filterOptions: {
            enabled: true,
            placeholder: 'Search code',
          },
        },
        {
          label: 'Product Name',
          field: 'name',
          filterOptions: {
            enabled: true,
            placeholder: 'Search Name',
          },
        },
        {
          label: 'Product price',
          field: 'price',
          filterOptions: {
            enabled: true,
            placeholder: 'Search price',
          },
        },
        {
          label: 'ยอดเข้าชม',
          field: 'total_click',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ยอดเข้าชม',
          },
        },
        {
          label: 'โปรโมท',
          field: 'promote_text',
          filterOptions: {
            enabled: true,
            placeholder: 'Search โปรโมท',
          },
        },
      ]
    },
  },
  created() {
    this.fetchProducts()
  },
  data() {
    return {
      products: '',
    }
  },
  methods: {
    clickNew() {
      const form = {
        code: '',
        name: '',
        detail: '',
        detail_full: '',
        price: '',
        promote: false,
        product_category_datas: null,
        images_datas: null,
      }
      this.$refs.productClickFormModal.show(form)
    },
    async clickDelete(data) {
      await this.api.del(`/api/admin/products/${data.id}`, '', true)
      this.fetchProducts()
    },
    clickEdit(datas) {
      const data = { ...datas }
      this.$refs.productClickFormModal.show(data)
    },
    async fetchProducts() {
      try {
        this.products = await this.api.get(`/api/admin/products`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
  },
}
</script>
