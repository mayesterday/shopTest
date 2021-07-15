<template>
  <b-row>
    <div class="wrapper rounded bg-white">
      <div
        class="d-flex align-items-center justify-content-end px-sm-3 pt-3 px-1"
      >
        <div class="text-muted">Handpicked Product</div>
      </div>
      <hr />
      <div class="row pt-3">
        <div class="col-md-3" v-for="(product, index) in products" :key="index">
          <div class="card" @click="countProd(product.id)">
            <router-link :to="`/product/view/${product.id}`">
              <div class="px-2 red text-uppercase" v-show="product.promote">
                แนะนำ
              </div>
              <div class="d-flex justify-content-center">
                <img
                  :src="`${product['image_datas'][0]['filename']}`"
                  class="product"
                  alt=""
                />
              </div>
              <b class="px-2">
                <p class="h4">{{ product.product_category_datas }}</p>
              </b>
              <div
                class="d-flex align-items-center justify-content-start rating border-top border-bottom py-2"
              >
                <div class="text-muted text-uppercase px-2 border-right">
                  #{{ product.code }}
                </div>
                <div class="px-lg-2 px-1">
                  <a href="#" class="px-lg-2 px-1 reviews">{{
                    product.name
                  }}</a>
                </div>
              </div>
              <div
                class="d-flex align-items-center justify-content-between py-2 px-3"
              >
                <div class="h4">
                  {{ withCommas(product.price) }}
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </b-row>
</template>
<script>
export default {
  created() {
    this.fetchRecommendProduct()
  },
  data() {
    return {
      products: '',
    }
  },

  methods: {
    async fetchRecommendProduct() {
      try {
        this.products = await this.api.get(`/api/guest/recommendedProduct`)
      } catch (error) {
        console.error(error)
        return ''
      }
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
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Lora&family=Roboto+Slab&display=swap');

* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  background: linear-gradient(to top, #fff, #37fc0f 150%) no-repeat;
}

.wrapper {
  box-shadow: 10px 10px 80px #c9fab2;
  max-width: 90%;
  margin: 30px auto;
}

select {
  border-radius: 20px;
  outline: none;
  border: 1px solid #ddd;
  color: #555;
}

img {
  object-fit: contain;
  width: 150px;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
}

p.h4 {
  font-family: 'Roboto Slab', serif;
}

.rating {
  font-size: 0.7rem;
}

.fa-star,
.reviews {
  color: #daa520;
}

div.h4 {
  font-size: 1.8rem;
  color: #d4a838;
  font-family: 'Lora', serif;
  margin: 0;
}

.btn {
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  padding: 8px 20px;
}

.card {
  position: relative;
}

.card:hover {
  border: 1px solid #000;
  box-shadow: 3px 3px 30px rgb(166, 255, 144);
}

.red {
  background-color: #e03e3e;
  position: absolute;
  color: #fff;
  border-radius: 5px;
  right: 5px;
  top: 5px;
  font-size: 0.9rem;
}

a:hover {
  text-decoration: none;
}

@media (max-width: 800px) {
  .wrapper {
    margin: 20px 10px;
  }

  p.h4 {
    font-size: 1.35rem;
    padding-top: 10px;
  }
}

@media (max-width: 767px) {
  .wrapper {
    max-width: 500px;
    margin: 20px auto;
  }
}

@media (max-width: 424px) {
  .wrapper {
    width: 100%;
    margin: auto;
  }

  div.text-muted {
    font-size: 0.75rem;
  }
}
</style>
