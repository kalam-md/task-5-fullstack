import { createWebHistory, createRouter } from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Categories from '../pages/Category/Categories';
import AddCategory from '../pages/Category/AddCategory';
import EditCategory from '../pages/Category/EditCategory';
import Articles from '../pages/Article/Articles';
import AddArticle from '../pages/Article/AddArticle';
import EditArticle from '../pages/Article/EditArticle';

export const routes = [
  {
    name: 'home',
    path: '/',
    component: Home
  },
  {
    name: 'register',
    path: '/register',
    component: Register
  },
  {
    name: 'login',
    path: '/login',
    component: Login
  },
  {
    name: 'dashboard',
    path: '/dashboard',
    component: Dashboard
  },
  {
    name: 'categories',
    path: '/categories',
    component: Categories
  },
  {
    name: 'addcategory',
    path: '/categories/add',
    component: AddCategory
  },
  {
    name: 'editcategory',
    path: '/categories/edit/:id',
    component: EditCategory
  },
  {
    name: 'articles',
    path: '/articles',
    component: Articles
  },
  {
    name: 'addarticle',
    path: '/articles/add',
    component: AddArticle
  },
  {
    name: 'editarticle',
    path: '/articles/edit/:id',
    component: EditArticle
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
});

export default router;