const fetchData = () => {
  return {
    form: {
      products: [],
      coupon_code: '',
      subtotal: 0,
      tex: 0,
      total: 0,
    
      customer: {
        firstname:'Thanawut',
        lastname:'Wien',
        state:'43 หมู 8 ต. เมืองเก่า อ. เมือง จ.ขอนแก่น 40000',
        city:'Khon kaen',
        zip:'40000',
        phone:'0873551978',
        email: 'test@tee.com',
      }
      ,image_datas:''
    }
  }
}

export const state = fetchData()

export const mutations = {
  ADD_CAR(state, payload) {
    const _product = {...payload.product}
    const {products} = state.form
    const index = products.findIndex(product => product.id == _product.id)
    
    if(index >= 0){
      state.form.products[index].amount += payload.amount * 1
    }else{
      console.log(index)
      _product['amount'] = payload.amount * 1
      state.form.products.push(_product)
      
    }
    return ''
    
  }
}