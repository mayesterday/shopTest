import Vue from 'vue'
import VueRouter from 'vue-router'

// Routes
import { canNavigate } from '@/libs/acl/routeProtection'
import {
	isUserLoggedIn,
	getUserData,
	getHomeRouteForLoggedInUser
} from '@/auth/utils'
 

Vue.use(VueRouter)

import routeImporter from '../modules/importers/routeImporter'
// const applications = routeImporter(
// 	require.context('./routes/applications', false, /.*\.js$/)
// ).map(data => {
// 	/**
//    * เติ่ม application นำหน้า path
//    */
// 	data.path = `/admin/${data.path}`
// 	return data
// })
const previews = routeImporter(
	require.context('./routes/preview', false, /.*\.js$/)
)
const admin = routeImporter(
	require.context('./routes/admin', false, /.*\.js$/)
)

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	scrollBehavior() {
		return { x: 0, y: 0 }
	},
  routes: [
    ...admin,
		...previews
		,{
			path: '/login',
			name: 'auth-login',
			component: () => import('@/views/pages/authentication/Login.vue'),
			meta: {
				layout: 'full',
				resource: 'Auth',
				redirectIfLoggedIn: true
			}
		},
		{
			path: '*',
			redirect: 'error-404'
		}
	]
})

router.beforeEach((to, _, next) => {
  const check = to.path.split('/')
  if (check.length < 1) {
    return next()
  } else if (check[1] != 'admin') {
    return next()
  }
	const isLoggedIn = isUserLoggedIn()

	if (!canNavigate(to)) {
		// Redirect to login if not logged in
		if (!isLoggedIn) return next({ name: 'auth-login' })

		// If logged in => not authorized
		return next({ name: 'misc-not-authorized' })
	}

	// Redirect if logged in
	if (to.meta.redirectIfLoggedIn && isLoggedIn) {
		const userData = getUserData()
		next(getHomeRouteForLoggedInUser(userData ? userData.role : null))
	}
	return next()
})

export default router
