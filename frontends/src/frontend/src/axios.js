// axios
import axios from 'axios'
import store from './store'

const domain = process.env.VUE_APP_API_BASEURL
axios.baseURL = domain
const api = axios.create({
	baseURL: domain,
	// domain
	// You can add your headers here
})
api.interceptors.request.use(
    config => {
		const JWT_TOKEN = store.getters.getToken
		if (JWT_TOKEN !== null) {
			config.headers = {
				Authorization: JWT_TOKEN,
				Accept: 'application/json',
			}
		}
		// Do something before request is sent
		return config
	},
	error =>
		// Do something with request error
		Promise.reject(error)
)

export default api
