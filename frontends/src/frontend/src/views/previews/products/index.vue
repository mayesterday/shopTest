<template>
  <section v-if="products">
    <top-bar />

    <div class="breadcrumb-wrapper">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/">Home</router-link>
        </li>
        <li class="breadcrumb-item active">
          <span aria-current="location"> {{ products.name }} </span>
        </li>
      </ol>
    </div>

    <vue-gallery-slideshow
      :images="_images"
      :index="index"
      @close="index = null"
    />

    <panel>
      <b-row>
        <b-col sm="6">
          <b-row>
            <img
              v-for="(image, index) in _images"
              :src="image"
              class="img-fluid col-sm-3"
              :key="index"
              @click="onClick(index)"
            />
          </b-row>
        </b-col>
        <!-- detail -->
        <b-col sm="6">
          <h3>{{ products.name }}</h3>
          <p>{{ withCommas(products.price) }}</p>
          <div class="text">
            {{ products.detail }}
          </div>
          <b-row class="mt-3">
            <b-col sm="2">
              <div class="form-group">
                <input
                  type="number"
                  class="form-control"
                  v-model="amount"
                  min="1"
                />
              </div>
            </b-col>
            <b-col sm="6">
              <button
                type="button"
                class="btn btn-warning"
                @click="clickAddCar(products)"
              >
                Add to Cart
              </button>
            </b-col>

            <b-col sm="12">
              <p>Code # {{ products.code }}</p>
            </b-col>
          </b-row>
        </b-col>
        <!-- ในรูปแบบ wyswyg html -->
        <b-col sm="12" class="mt-3">
          <h3>Detail</h3>
          <hr />
          <div v-html="products.detail_full"></div>
        </b-col>
      </b-row>
    </panel>

    <h3 class="mt-3">Relation Products</h3>
    <panel class="mt-2">
      <b-row>
        <b-col
          sm="3"
          v-for="(ref, index) in products.previews.category_ref"
          :key="index"
          @click="countProd(ref.id)"
        >
          <router-link :to="`/product/view/${ref.id}`">
            <img
              :src="ref.previews.images[0]['filename']"
              class="img-fluid"
              alt=""
            />

            <h4 class="mt-1">{{ ref.name }}</h4>
            <p class="mt-1">หมวด {{ ref.previews.category_name[0] }}</p>
            <p class="mt-1">$ {{ withCommas(ref.price) }}</p>
          </router-link>
        </b-col>
      </b-row>
    </panel>
  </section>
</template>
<script>
import VueGallerySlideshow from 'vue-gallery-slideshow'
import { mapMutations } from 'vuex'
export default {
  watch: {
    $route(to, from) {
      this.fetchProductData(to.params.product_data_id)
    },
  },
  computed: {
    _images() {
      try {
        const images = this.products.previews.images.map((img) => img.filename)
        return images
      } catch (error) {
        return []
      }
    },
  },
  created() {
    const product_data_id = this.$route.params.product_data_id
    if (!product_data_id) {
      this.$router.push({ path: '/' })
      return ''
    }
    this.fetchProductData(product_data_id)
  },
  components: {
    VueGallerySlideshow,
    topBar: () => import('../topBar'),
  },

  data() {
    return {
      products: '',
      images: [],
      index: null,
      amount: 1,
    }
  },

  methods: {
    ...mapMutations('cars', ['ADD_CAR']),
    clickAddCar(product) {
      const amount = this.amount
      if (amount < 1) {
        alert('จำนวนสิ้นค้าห้ามเป็น 0')
        return ''
      }
      this.ADD_CAR({ product: product, amount })
    },
    async fetchProductData(product_data_id) {
      try {
        this.products = await this.api.post(`/api/guest/findproduct`, {
          product_data_id,
        })
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    onClick(i) {
      this.index = i
    },
    async countProd(product_data_id) {
      try {
        await this.api.get(`/api/guest/countproductclick/${product_data_id}`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
  },
}
</script>
