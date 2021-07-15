<template>
  <form-modal
    :title="_title"
    ref="formmodal"
    @save="handleSubmit"
    @cancel="cancel"
  >
    <b-row>
      <b-col sm="12">
        <div class="form-group">
          <label for="">เลือกหัวข้อ</label>
          <treeselect
            v-model="form.product_category_datas"
            :multiple="true"
            :options="options.categorys"
            v-validate="`required`"
            data-vv-as="เลือกหัวข้อ"
            name="product_category_datas"
          />
          <div
            class="alert alert-danger mt-1 col-12"
            role="alert"
            v-if="
              errors.items.find((f) => f.field === 'product_category_datas')
            "
          >
            {{
              errors.items.find((f) => f.field === 'product_category_datas').msg
            }}
          </div>
        </div>
      </b-col>

      <form-input
        label="รหัสสินค้า"
        v-model="form.code"
        v-validate="`required`"
        data-vv-as="รหัสสินค้า"
        :col="6"
      />
      <form-input
        label="ชื่อสินค้า"
        v-model="form.name"
        v-validate="`required`"
        data-vv-as="ชื่อสินค้า"
        :col="6"
      />
      <form-input-currency
        label="ราคาขาย"
        v-model="form.price"
        v-validate="`required`"
        data-vv-as="ราคาขาย"
        :col="6"
      />
      <b-col sm="6">
        <b-form-group label="สถานะโปรโมท" v-slot="{ ariaDescribedby }">
          <b-form-radio-group
            id="radio-group-1"
            v-model="form.promote"
            :options="[
              { text: 'ปิด', value: false },
              { text: 'เปิด', value: true },
            ]"
            :aria-describedby="ariaDescribedby"
            name="radio-options"
          ></b-form-radio-group>
        </b-form-group>
      </b-col>
      <form-input
        label="รายละเอียด"
        v-model="form.detail"
        v-validate="`required`"
        data-vv-as="รายละเอียด"
        :col="12"
        textarea
      />
      <b-col sm="12">
        <quill-editor v-model="form.detail_full" />
      </b-col>
      <b-col sm="12">
        <productUploadImage v-model="form.image_datas" />
      </b-col>
    </b-row>
  </form-modal>
</template>
<script>
import { quillEditor } from 'vue-quill-editor'

import Treeselect from '@riophae/vue-treeselect'
// import the styles
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  mounted() {
    this.fetchCategory()
  },
  components: {
    productUploadImage: () => import('./productUploadImage'),
    quillEditor,
    Treeselect,
  },
  data() {
    return {
      options: {
        categorys: [],
      },
      form: {},

      snowOption: {
        theme: 'snow',
      },
      content: ``,
    }
  },
  computed: {
    _title() {
      return ''
    },
  },
  methods: {
    async fetchCategory() {
      try {
        const category = await this.api.get(`/api/admin/category`)
        this.options.categorys = category.map((item) => {
          item['label'] = item.category_name
          return item
        })
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    show(data) {
      this.clearForm()
      this.form = data
      // debugger
      this.form.product_category_datas =
        data.product_category_datas?.map((item) => item.category_data_id) ??
        null
      this.switch('show')
    },
    async handleSubmit() {
      try {
        const validatetor = await this.$validator.validateAll()
        if (!validatetor) {
          this.alert.validator()
          return ''
        }

        await this.api.createOrUpdate(
          `/api/admin/products`,
          this.form,
          `products`
        )
        this.$emit('reload')
        this.switch('hide')
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    cancel() {
      this.clearForm()
    },
    clearForm() {
      const form = this.form
      Object.keys(form).forEach((fill) => [(form[fill] = '')])
      this.form.product_category_datas = null
      this.switch('hide')
    },
    switch(type) {
      type === 'show'
        ? this.$refs.formmodal.show()
        : this.$refs.formmodal.hide()
    },
  },
}
</script>
<style lang="scss">
@import '@core/scss/vue/libs/quill.scss';
</style>
