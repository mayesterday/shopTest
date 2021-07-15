import Vue from 'vue'

// axios
import axios from 'axios'
const domain = process.env.VUE_APP_API_BASEURL
const axiosIns = axios.create({
	// You can add your headers here
	// ================================
	baseURL: domain,
	timeout: 2000,
	headers: { 'X-Custom-Header': 'foobar' },
})

axiosIns.interceptors.response.use(function (response) {
  return response
}, function (error) {

  if (error.response.status === 401) {
    localStorage.removeItem('accessToken')
    localStorage.removeItem('refreshToken')
    localStorage.removeItem('userData')
    location.reload();
  }
  return Promise.reject(error)
})

// axios.defaults.headers = { 'X-Custom-Header': 'foobar' }

Vue.prototype.$http = axiosIns

export default axiosIns
