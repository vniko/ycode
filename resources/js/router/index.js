import Vue from 'vue';
import Router from 'vue-router';
import List from '@/pages/Websites/List';
import Create from '@/pages/Websites/Create';

Vue.use(Router);

export default new Router({
  mode: 'hash',
  linkActiveClass: 'is-active',
  routes: [
    {
      path: '/websites',
      name: 'websites.list',
      component: List,
    },
    {
      path: '/websites/create',
      name: 'websites.create',
      component: Create,
    },
    {path: '*', redirect: '/websites'}
  ],
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return {x: 0, y: 0}
    }
  }
})
