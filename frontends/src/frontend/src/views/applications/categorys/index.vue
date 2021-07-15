<template>
  <panel>
    <categorys-click-edit ref="categorysClickEdit" @reload="fetchCategory" />
    <data-table-local
      ref="categorys"
      :columns="_columns"
      :items="categorys"
      :view-able="false"
      @clickEdit="clickEdit"
      @clickNew="clickNew"
      @clickDelete="clickDelete"
    />
  </panel>
</template>

<script>
import categorysClickEdit from './components/categorysClickForm.vue'
export default {
  components: { categorysClickEdit },
  data() {
    return {
      categorys: '',
    }
  },
  created() {
    this.fetchCategory()
  },
  computed: {
    _columns() {
      return [
        {
          label: 'category name',
          field: 'category_name',
          filterOptions: {
            enabled: true,
            placeholder: 'Search category',
          },
        },
        {
          label: 'จำนวนการกด',
          field: 'count_click',
          filterOptions: {
            enabled: true,
            placeholder: 'Search category',
          },
        },
        {
          label: 'status promote',
          field: 'promote',
          filterOptions: {
            enabled: true,
            placeholder: 'Search promote',
          },
        },
      ]
    },
  },
  methods: {
    async fetchCategory() {
      try {
        this.categorys = await this.api.get(`/api/admin/category`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    clickEdit(datas) {
      const data = { ...datas }
      this.$refs.categorysClickEdit.show(data)
    },
    clickNew() {
      const data = { id: '', category_name: '', promote: false }
      this.$refs.categorysClickEdit.show(data)
    },
    async clickDelete(data) {
      await this.api.del(`/api/admin/category/${data.id}`, '', true)
      this.fetchCategory()
    },
  },
}
</script>

<style></style>
