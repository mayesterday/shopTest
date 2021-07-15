<template>
  <section>
    <top-bar />
    <panel>
      <b-row>
        <b-col sm="8">
          <table class="table table-bordered table-hover">
            <thead>
              <th class="text-center">#</th>
              <th class="text-center">Product</th>
              <th class="text-center">Price</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Subtotal</th>
              <th class="text-center"></th>
            </thead>
            <tbody>
              <tr v-for="(product, index) in form.products" :key="index">
                <td class="text-center">{{ index + 1 }}</td>
                <td>
                  {{ product.name }}
                </td>
                <td class="text-right">
                  {{ withCommas(product.price) }}
                </td>
                <td class="text-right">
                  <input
                    type="number"
                    class="form-control"
                    v-model="product.amount"
                  />
                </td>

                <td class="text-right">
                  {{ withCommas(product.price * product.amount) }}
                </td>
                <td class="text-center">
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="clickDelete(product, index)"
                  >
                    del
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </b-col>
        <b-col sm="4">
          <h3>Car Totals</h3>
          <table class="table">
            <tr>
              <td>Subtotal</td>
              <td>{{ withCommas(_subtotal) }}</td>
            </tr>
            <tr>
              <td>Tex</td>
              <td>0</td>
            </tr>
            <tr>
              <td>Total</td>
              <td>{{ withCommas(_subtotal) }}</td>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-primary btn-sm">
                  ยืนยัน Coupon
                </button>
              </td>
              <td>
                <input
                  class="form-control"
                  type="text"
                  v-model="form.coupon_code"
                  placeholder="Copon Code"
                />
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-right">
                <router-link to="/bill/confirm" class="btn btn-primary"
                  >Process to Checkout</router-link
                >
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
export default {
  components: {
    topBar: () => import('../topBar'),
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
  },
}
</script>
