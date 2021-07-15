<template>
  <form-modal
    :title="`${_title} Promotion`"
    ref="formmodal"
    @save="handleSubmit"
    @cancel="cancel"
  >
    <b-row>
      <form-input
        label="ชื่อ Promotion"
        v-model="form.name"
        v-validate="`required`"
        data-vv-as="ชื่อ Promotion"
        :col="12"
      />

      <b-col sm="12">
        <h3>รายละเอียด</h3>
        <quill-editor
          name="xxsd"
          v-model="form.promotions"
          v-validate="`required`"
          data-vv-as="รายละเอียด Promotion"
        />

        <div
          id="helpId"
          class="form-text text-danger"
          v-if="errors.items.find((f) => f.field === 'xxsd')"
        >
          {{ errors.items.find((f) => f.field === 'xxsd').msg }}
        </div>
        <pre>
          {{ form.promotions }}
        </pre>
      </b-col>
    </b-row>
  </form-modal>
</template>
<script>
import { quillEditor } from 'vue-quill-editor'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
export default {
  components: {
    quillEditor,
  },
  data() {
    return { form: {} }
  },
  computed: {
    _title() {
      return this.form?.id ? 'แก้ไข' : 'เพิ่ม'
    },
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
          this.alert.validator()
          return ''
        }
        await this.api.createOrUpdate(`/api/admin/Promotion`, this.form)
        this.$emit('handelSubmit', this.form)
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
<style lang="scss">
@import '@core/scss/vue/libs/quill.scss';
</style>
