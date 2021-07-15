<template>
  <section>
    <top-bar />
    <panel>
      <b-row>
        <b-col sm="8">
          <h4>BillDetail</h4>
          <b-row>
            <form-input
              label="First Name"
              v-model="form.customer.firstname"
              v-validate="`required`"
              data-vv-as="First Name"
              :col="6"
            />
            <form-input
              label="Last Name"
              v-model="form.customer.lastname"
              v-validate="`required`"
              :col="6"
            />

            <form-input
              label="Street Address"
              v-model="form.customer.state"
              v-validate="`required`"
              data-vv-as="Street Address"
              :col="12"
            />
            <form-input
              label="Town / CITY"
              v-model="form.customer.city"
              v-validate="`required`"
              data-vv-as="Town / CITY"
              :col="12"
            />
            <form-input
              label="Zip "
              v-model="form.customer.zip"
              v-validate="`required`"
              data-vv-as="Zip "
              :col="12"
            />
            <form-input
              label="Phone "
              v-model="form.customer.phone"
              v-validate="`required`"
              data-vv-as="Phone "
              :col="12"
            />
            <form-input
              label="Email "
              v-model="form.customer.email"
              v-validate="`required`"
              data-vv-as="Email "
              :col="12"
            />
            <b-col sm="12">
              <product-upload-image
                helpText="เพิ่มรูป Slip การโอน"
                v-model="form.image_datas"
              />
              <pre>
  {{ form }}
</pre
              >
            </b-col>
          </b-row>
        </b-col>
        <b-col sm="4">
          <h4>Prodects</h4>
          <table class="table table-bordered table-hover mt-2">
            <thead>
              <th class="text-center">#</th>
              <th class="text-center">Product</th>
              <th class="text-center">Subtotal</th>
            </thead>
            <tbody>
              <tr v-for="(product, index) in form.products" :key="index">
                <td class="text-center">{{ index + 1 }}</td>
                <td>
                  {{ product.name }}
                  {{ withCommas(product.price) }} x
                  {{ withCommas(product.amount) }}
                </td>

                <td class="text-right">
                  {{ withCommas(product.price * product.amount) }}
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table">
            <tr>
              <td>Subtotal</td>
              <td class="text-right">{{ withCommas(_subtotal) }}</td>
            </tr>
            <tr>
              <td>Tex</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <td>Total</td>
              <td class="text-right">{{ withCommas(_subtotal) }}</td>
            </tr>
            <tr>
              <td>Copon Code</td>
              <td class="text-right">{{ form.coupon_code }}</td>
            </tr>
            <tr>
              <td colspan="2" class="text-right">
                <button
                  type="button"
                  class="btn btn-warning"
                  @click="clickSubmit"
                >
                  PLACE ORDER
                </button>
              </td>
            </tr>
          </table>
        </b-col>
      </b-row>
    </panel>
  </section>
</template>
<script>
import { mapState } from 'vuex'
import ProductUploadImage from '../../applications/products/components/productUploadImage.vue'
export default {
  components: {
    topBar: () => import('../topBar'),
    ProductUploadImage,
  },
  computed: {
    ...mapState('cars', ['form']),
    _subtotal() {
      return this.form.products.reduce((cur, item) => {
        return (cur += item.amount * 1 * item.price)
      }, 0)
    },
  },
  methods: {
    clickDelete(product, index) {
      this.form.products.splice(index, 1)
    },
    async clickSubmit() {
      try {
        const validatetor = await this.$validator.validateAll()
        if (!validatetor) {
          alert('กรุณากรอกข้อมูลให้ครบ')
          return ''
        }
        await this.api.post(`/api/guest/bill/store`, this.form)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
  },
}
</script>
