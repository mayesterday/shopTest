export default [
	{
		path: `/bill`,
		name: `bill-page`,
		component: () => import('@preview/bills/'),
		meta: {
      layout: 'full'
      
		}
	},
	{
		path: `/bill/confirm`,
		name: `bill-confirm-page`,
		component: () => import('@preview/bills/confirm'),
		meta: {
			layout: 'full'
		}
	}
]
