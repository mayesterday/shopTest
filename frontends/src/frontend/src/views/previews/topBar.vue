<template>
  <section>
    <b-row>
      <b-col
        sm="12"
        style="
          background: linear-gradient(180deg, #fae189 0%, #19e298 100%);
          padding: 10px;
        "
        class="text-center"
      >
        <font color="black">
          <b>SALE</b> UP TO 20% OFF SELECT POSTERS AND FRAMED PRINTS! CLICK
          DETAILS
        </font>
      </b-col>
    </b-row>
    <b-card>
      <b-row>
        <b-col sm="3">
          <img
            src="https://laz-img-cdn.alicdn.com/images/ims-web/TB1KB2laMFY.1VjSZFnXXcFHXXa.png"
            alt="2"
          />
        </b-col>
        <b-col sm="4">
          <input
            type="search"
            class="form-control mt-3"
            aria-describedby="helpId"
            placeholder="Search Product"
          />
        </b-col>
        <b-col sm="5">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs mt-3" id="navId">
            <li class="nav-item">
              <router-link
                :to="_checkLogin ? '/admin' : '/login'"
                class="nav-link"
              >
                {{ _checkLogin ? 'หน้าจัดการ' : 'Sing In / Sing Up' }}
              </router-link>
            </li>
            <li class="nav-item">
              <test />
            </li>
          </ul>
        </b-col>
      </b-row>
      <b-row>
        <b-col sm="12">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs mt-3" id="navId">
            <li
              class="nav-item"
              v-for="(item, index) in categoryDatas"
              :key="index"
              @click="countCategory(item.id)"
            >
              <router-link :to="`/category/${item.id}`" class="nav-link">{{
                item.category_name
              }}</router-link>
            </li>
          </ul>
        </b-col>
      </b-row>
      <b-row>
        <b-col
          sm="12"
          v-for="(promotion, index) in promotions"
          :key="index"
          v-html="promotion.promotions"
        >
        </b-col>
      </b-row>
    </b-card>
  </section>
</template>

<script>
export default {
  computed: {
    _checkLogin() {
      return localStorage.getItem('refreshToken')
    },
  },
  components: {
    test: () => import('./test'),
    RecommendedProduct: () => import('./RecommendedProduct.vue'),
  },
  data() {
    return {
      categoryDatas: '',
      promotions: '',
    }
  },
  created() {
    this.fetchCategoryData()
    this.fetchPromotions()
  },
  methods: {
    async countCategory(category_data_id) {
      try {
        await this.api.get(
          `/api/guest/category/countproductclick/${category_data_id}`
        )
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    async fetchCategoryData() {
      try {
        this.categoryDatas = await this.api.get(`/api/guest/fetchCategory`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    async fetchPromotions() {
      try {
        this.promotions = await this.api.get(`/api/guest/promotions`)
      } catch (error) {
        console.error(error)
        return ''
      }
    },
  },
}
</script>
