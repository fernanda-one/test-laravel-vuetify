export const routes = [
  { path: '/', redirect: '/login' },
  { 
    path: '/',
    component: () => import('@/layouts/defaultCustomer.vue'),
    children:[
      {
        path: 'products',
        component: () => import('@/pages/customers/index.vue'),
      },
      {
        path: 'transaction',
        component: () => import('@/pages/customers/transaction.vue'),
      },
    ]
  },
  {
    path: '/admin',
    component: () => import('@/layouts/default.vue'),
    children: [
      {
        path: 'customers',
        component: () => import('@/pages/customers.vue'),
      },
      {
        path: 'products',
        component: () => import('@/pages/products.vue'),
      },
      {
        path: 'typography',
        component: () => import('@/pages/typography.vue'),
      },
      {
        path: 'icons',
        component: () => import('@/pages/icons.vue'),
      },
      {
        path: 'cards',
        component: () => import('@/pages/cards.vue'),
      },
      {
        path: 'tables',
        component: () => import('@/pages/tables.vue'),
      },
      {
        path: 'form-layouts',
        component: () => import('@/pages/form-layouts.vue'),
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: 'login',
        component: () => import('@/pages/login.vue'),
      },
      {
        path: 'logout',
        component: () => import('@/pages/logout.vue'),
      },
      {
        path: 'register',
        component: () => import('@/pages/register.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]
