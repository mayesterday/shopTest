export default [
	{
		path: `/admin`,
		name: `admin-page`,
    component: () => import('@app/index'),
    meta: {
      pageTitle: 'Apex Chart',
      breadcrumb: [
        {
          text: 'Extensions',
        },
        {
          text: 'Apex Chart',
          active: true,
        },
      ],
    },
  },
  
	{
		path: `/admin/category`,
		name: `admin-category-page`,
    component: () => import('@app/categorys'),
    meta: {
      pageTitle: 'Category',
    },
  },
  
	{
		path: `/admin/product`,
		name: `admin-product-page`,
    component: () => import('@app/products'),
    meta: {
      pageTitle: 'product',
    },
	},
	{
		path: `/admin/bill`,
		name: `admin-bill-page`,
    component: () => import('@app/bills'),
    meta: {
      pageTitle: 'Bill',
    },
	},
	{
		path: `/admin/promotion`,
		name: `admin-promotion-page`,
    component: () => import('@app/promotions'),
    meta: {
      pageTitle: 'promotion',
    },
	},

]
