<template>
  <button type="button" class="btn btn-primarynav-link" @click="btnClick">
    <font color="red">{{ amount }} - </font> &nbsp; items
  </a>
  </button>
</template>
<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      amount: 0,
    }
  },
  watch: {
    form: {
      deep: true,
      handler() {
        this.amount = this.form.products.reduce((cur, item) => {
          return (cur += item.amount * 1)
        }, 0)
      },
    },
  },
  computed: {
    ...mapState('cars', ['form']),
  },
  created() {
    this.amount = this.form.products.reduce((cur, item) => {
          return (cur += item.amount * 1)
        }, 0)
  },
  methods: {
    btnClick(){
      this.$router.push({ path: '/bill' })
    }
  },
}
</script>
