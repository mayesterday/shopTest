<template>
  <section>
    <top-bar />

    <div class="breadcrumb-wrapper">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/">Home</router-link>
        </li>
        <li class="breadcrumb-item active">
          <span aria-current="location"> {{ _product_category_datas }} </span>
        </li>
      </ol>
    </div>
    <div>
      <h1>
        {{ _product_category_datas }}
      </h1>
    </div>
    <hr />
    <panel>
      <b-row>
        <b-col sm="6"> Show 15 30 45 </b-col>
        <b-col sm="6" class="text-right">
          <select class="form-select" aria-label="Default select example">
            <option selected>Default sorting</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </b-col>
      </b-row>

      <div class="container mt-100 mt-3">
        <div class="row">
          <div
            class="col-md-4 col-sm-6"
            v-for="(product, index) in _products"
            :key="index"
          >
            <div class="card mb-30" @click="countProd(product.id)">
              <router-link
                :to="`/product/view/${product.id}`"
                class="card-img-tiles"
              >
                <div class="inner">
                  <div class="main-img">
                    <pre></pre>
                    <img
                      :src="`${product.previews.images[0]['filename']}`"
                      alt="Category"
                      @mouseover="onmouseover(product)"
                    />
                  </div>
                </div>
              </router-link>

              <div class="card-body text-center">
                <h4 class="card-title">{{ product.name }}</h4>
                <p
                  style="
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                  "
                >
                  {{ product.detail }}
                </p>
                <p class="text-muted">
                  <font color="#ea5455">$ {{ withCommas(product.price) }}</font>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <b-row>
        <b-col sm="12" class="text-center">
          <b-pagination
            v-model="currentPage"
            :total-rows="_length"
            :per-page="perPage"
            first-number
            aria-controls="my-table"
            last-number
            align="center"
            prev-class="prev-item"
            next-class="next-item"
          />
        </b-col>
      </b-row>
    </panel>
  </section>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
  components: {
    topBar: () => import('../topBar'),
  },
  watch: {
    $route(to, from) {
      this.fetchCategory()
    },
  },
  created() {
    this.fetchCategory()
  },
  computed: {
    _product_category_datas() {
      return this.products?.previews?.category_name[0]
    },
    _length() {
      return this.products.length
    },
    _products() {
      const products = this.products
      const page = this.currentPage
      const perPage = this.perPage
      return products.slice((page - 1) * perPage, page * perPage)
    },
  },
  data() {
    return {
      currentPage: 1,
      products: '',
      perPage: 15,
      currentPage: 1,
    }
  },
  methods: {
    ...mapMutations('cars', ['ADD_CAR']),
    async countProd(product_data_id) {
      try {
        await this.api.get(`/api/guest/countproductclick/${product_data_id}`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    onmouseover(product) {
      this.ADD_CAR({ product: product, amount: 1 })
    },
    async fetchCategory() {
      try {
        if (!this.$route.params?.category_data_id) {
          this.$router.push({ path: '/' })
          return ''
        }
        this.products = await this.api.get(
          `/api/guest/fetchCategoryWithProduct/${this.$route.params.category_data_id}`
        )
      } catch (error) {}
    },
  },
}
</script>
