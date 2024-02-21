import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import ListPage from "@/components/pages/ListPage.vue";
import RegisterPage from "@/components/pages/RegisterPage.vue";
import InformationPage from "@/components/pages/InformationPage.vue";
import AboutPage from "@/components/pages/AboutPage.vue";


Vue.use(VueRouter);

const routes: RouteConfig[] = [
  {
    path: '/',
    name: 'List',
    component: ListPage,
  },
  {
    path: '/register/:id?',
    name: 'Register',
    component: RegisterPage,
  },
  {
    path: '/information/:id',
    name: 'Information',
    component: InformationPage,
    props: true,
  },
  {
    path: '/about',
    name: 'About',
    component: AboutPage,
    props: true,
  },

];

const router = new VueRouter({
  mode: 'history', 
  base: process.env.BASE_URL,
  routes,
});

export default router;
