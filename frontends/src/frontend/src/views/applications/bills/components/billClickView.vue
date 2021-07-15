<template>
  <form-modal
    title="รายละเอียดรายการ"
    ref="formmodal"
    @save="handleSubmit"
    @cancel="cancel"
  >
    <b-row v-if="form.id">
      <b-col sm="12">
        <h3>
          {{ form.status_data.name }}
        </h3>
      </b-col>
      <form-input
        disabled
        label="First Name"
        v-model="form.customer_data.firstname"
        v-validate="`required`"
        data-vv-as="First Name"
        :col="3"
      />
      <form-input
        disabled
        label="Last Name"
        v-model="form.customer_data.lastname"
        v-validate="`required`"
        :col="3"
      />
      <form-input
        disabled
        label="Email "
        v-model="form.customer_data.email"
        v-validate="`required`"
        data-vv-as="Email "
        :col="3"
      />

      <form-input
        disabled
        label="Town / CITY"
        v-model="form.customer_data.city"
        v-validate="`required`"
        data-vv-as="Town / CITY"
        :col="3"
      />
      <form-input
        disabled
        label="Zip "
        v-model="form.customer_data.zip"
        v-validate="`required`"
        data-vv-as="Zip "
        :col="3"
      />
      <form-input
        disabled
        label="Phone "
        v-model="form.customer_data.phone"
        v-validate="`required`"
        data-vv-as="Phone "
        :col="3"
      />
      <form-input
        disabled
        label="Street Address"
        v-model="form.customer_data.state"
        v-validate="`required`"
        data-vv-as="Street Address"
        :col="6"
      />

      <b-col sm="12">
        <data-table-local
          :columns="_columns"
          :items="form.bill_detail_datas"
          :viewAble="false"
          :editAble="false"
          :deleteAble="false"
        />
      </b-col>

      <b-col sm="12">
        <hr />
      </b-col>
      <b-col sm="3" v-for="(img, index) in form.image_datas" :key="index">
        <img :src="img.filename" class="img-fluid" />
      </b-col>
    </b-row>
  </form-modal>
</template>
<script>
export default {
  data() {
    return { form: {} }
  },
  computed: {
    _title() {
      return ''
    },
    _columns() {
      return [
        {
          label: 'รหัสสินค้า',
          field: 'product_data.code',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
        {
          label: 'รายการ',
          field: 'product_data.name',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
        {
          label: 'จำนวน',
          field: 'product_total',
          type: 'number',

          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
        {
          label: 'ราคา / ชิ้น',
          field: 'product_price',
          type: 'number',
          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
        {
          label: 'รวม',
          field: 'total',
          type: 'number',

          filterOptions: {
            enabled: true,
            placeholder: 'Search ',
          },
        },
      ]
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
