export default [
	{
		path: `/product/view/:product_data_id`,
		name: `product-view`,
		component: () => import('@preview/products/'),
		meta: {
			layout: 'full'
		}
	}
]
