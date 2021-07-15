<template>
  <panel>
    <promotion-click-form
      ref="promotionClickForm"
      @handelSubmit="fetchPromotion"
    />
    <data-table-local
      :columns="_columns"
      :items="Promotion"
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
    promotionClickForm: () => import('./components/promotionClickForm'),
  },
  computed: {
    _columns() {
      return [
        {
          label: 'ชื่อ Promotions',
          field: 'name',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
      ]
    },
  },
  created() {
    this.fetchPromotion()
  },
  data() {
    return {
      Promotion: '',
    }
  },
  methods: {
    clickNew() {
      const form = {
        id: '',
        name: '',
        promotions: '',
      }
      this.$refs.promotionClickForm.show(form)
    },
    async clickDelete(data) {
      await this.api.del(`/api/admin/Promotion/${data.id}`, '', true)
      this.fetchPromotion()
    },
    clickEdit(datas) {
      const data = { ...datas }
      this.$refs.promotionClickForm.show(data)
    },
    async fetchPromotion() {
      try {
        this.Promotion = await this.api.get(`/api/admin/Promotion`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
  },
}
</script>
