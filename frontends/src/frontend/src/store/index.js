import Vue from 'vue'
import Vuex from 'vuex'

// Modules
// import ecommerceStoreModule from '@/views/apps/e-commerce/eCommerceStoreModule'
import app from './app'
import appConfig from './app-config'
import verticalMenu from './vertical-menu'
import storeImporter from '../modules/importers/storeImporter'
const modules = storeImporter(require.context('./modules', false, /.*\.js$/))

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		app,
		appConfig,
		verticalMenu,
		// 'app-ecommerce': ecommerceStoreModule,
		...modules,
	},
	strict: process.env.DEV,
})
