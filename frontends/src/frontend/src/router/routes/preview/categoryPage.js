export default [
	{
		path: `/category/:category_data_id`,
		name: `category-page`,
		component: () => import('@preview/categoryPages/'),
		meta: {
			layout: 'full'
		}
	}
]
