<template>
  <section>
    <topBar />
    <recommended-product />
  </section>
</template>

<script>
export default {
  components: {
    topBar: () => import('./topBar'),
    RecommendedProduct: () => import('./RecommendedProduct.vue'),
  },
}
</script>
