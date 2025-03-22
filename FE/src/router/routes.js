const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/DiscoverPage.vue') },
      { path: 'register', component: () => import('pages/RegisterPage.vue') },
      // { path: 'login', component: () => import('pages/LoginPage.vue') },
      { path: 'posts', component: () => import('pages/PostsPage.vue') },
      { path: 'create-post', component: () => import('pages/CreatePost.vue') },
      { path: 'edit-post/:id', component: () => import('pages/EditPost.vue') },
      { path: 'login', component: () => import('pages/SendVerify.vue') },
      { path: 'confirmLogin/:number', component: () => import('pages/ConfirmLogin.vue') },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
]

export default routes
