<template>
  <panel>
    <bill-click-view ref="BillClickView" />
    <data-table-local
      ref="billData"
      :columns="_columns"
      :items="billData"
      :editAble="false"
      :deleteAble="false"
      @clickView="clickView"
      @clickEdit="clickEdit"
      @clickNew="clickNew"
      @clickDelete="clickDelete"
    />
  </panel>
</template>

<script>
import BillClickView from './components/billClickView.vue'
export default {
  components: { BillClickView },
  data() {
    return {
      billData: '',
    }
  },
  created() {
    this.fetchBillData()
  },
  computed: {
    _columns() {
      return [
        {
          label: 'ผู้สั่ง',
          field: 'customer_data.full_name',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
        {
          label: 'สถานะ',
          field: 'status_data.name',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
        {
          label: 'จำนวน',
          field: 'total_product',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
        {
          label: 'ยอด',
          field: 'total',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
      ]
    },
  },
  methods: {
    async fetchBillData() {
      try {
        this.billData = await this.api.get(`/api/admin/billdata`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    clickView(data) {
      this.$refs.BillClickView.show({ ...data })
    },
    clickEdit(datas) {
      const data = { ...datas }
      this.$refs.billDataClickEdit.show(data)
    },
    clickNew() {
      const data = { id: '', category_name: '', promote: false }
      this.$refs.billDataClickEdit.show(data)
    },
    async clickDelete(data) {
      await this.api.del(`/api/admin/category/${data.id}`, '', true)
      this.fetchBillData()
    },
  },
}
</script>

<style></style>
