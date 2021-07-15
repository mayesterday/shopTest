<template>
  <form-modal
    :title="`${_title} Category`"
    ref="formmodal"
    @save="handleSubmit"
    @cancel="cancel"
  >
    <b-row>
      <form-input
        label="category name"
        v-model="form.category_name"
        v-validate="`required`"
        data-vv-as="category name"
        :col="10"
      />
      <b-form-group label="สถานะโปรโมท" v-slot="{ ariaDescribedby }">
        <b-form-radio
          v-model="form.promote"
          :aria-describedby="ariaDescribedby"
          name="some-radios"
          :value="true"
          >เปิด</b-form-radio
        >
        <b-form-radio
          v-model="form.promote"
          :aria-describedby="ariaDescribedby"
          name="some-radios"
          :value="false"
          >ปิด</b-form-radio
        >
      </b-form-group>
    </b-row>
  </form-modal>
</template>
<script>
export default {
  computed: {
    _title() {
      return this.form.id ? 'แก้ไข' : 'เพิ่ม'
    },
  },
  data() {
    return { form: {} }
  },
  methods: {
    show(data) {
      this.clearForm()
      this.form = data
      this.switch('show')
    },
    async handleSubmit() {
      try {
        const validatetor = await this.$validator.validateAll()
        if (!validatetor) {
          this.alertValidate()
          return ''
        }
        await this.api.createOrUpdate(
          `/api/admin/category`,
          this.form,
          `category`
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
