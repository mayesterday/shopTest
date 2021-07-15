import Vue from 'vue'
const self = Vue

export default function(Vue) {
	Vue.convert = {
		cp(src) {
			return JSON.parse(JSON.stringify(src))
		},
	}

	Object.defineProperties(Vue.prototype, {
		convert: {
			get() {
				return Vue.convert
			},
		},
	})
}
