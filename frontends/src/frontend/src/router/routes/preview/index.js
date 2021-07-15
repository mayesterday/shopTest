export default [
	{
		path: `/`,
		name: `index`,
		component: () => import('@preview/'),
		meta: {
			layout: 'full'
		}
	},
  {
		path: '/forgot-password',
		name: 'auth-forgot-password',
		component: () => import('@/views/pages/authentication/ForgotPassword.vue'),
		meta: {
			layout: 'full',
			resource: 'Auth',
			redirectIfLoggedIn: true,
		},
  },
  {
		path: '/register',
		name: 'auth-register',
		component: () => import('@/views/pages/authentication/Register.vue'),
		meta: {
			layout: 'full',
			resource: 'Auth',
			redirectIfLoggedIn: true,
		},
	},
]
