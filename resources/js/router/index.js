import { createRouter, createWebHistory } from 'vue-router';
import store from '@/store';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('@/views/Home.vue'),
    meta: { title: 'Home | mycomponents.xyz' },
  },
  {
    path: '/create',
    name: 'Create',
    component: () => import('@/views/Create.vue'),
    meta: { title: 'Create | mycomponents.xyz' },
  },
  {
    path: '/component/:uuid',
    name: 'Component',
    component: () => import('@/views/Component.vue'),
    meta: { title: 'Component | mycomponents.xyz' },
  },
  {
    path: '/404',
    component: () => import('@/views/404.vue'),
    meta: { title: '404 Oops! | mycomponents.xyz' },
  },
  {
    path: '/:catchAll(.*)',
    component: () => import('@/views/404.vue'),
    meta: { title: '404 Oops! | mycomponents.xyz' },
  },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  store.dispatch('popups/closeAllPopups');
  document.title = to.meta.title;
  next();
});

export default router;
