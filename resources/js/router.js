import { createRouter, createWebHistory } from 'vue-router';
import EmployeeList from './employee/List.vue';
import ProjectList from './project/List.vue';

const routes = [
  {
    path: '/',
    name: 'EmployeeList',
    component: EmployeeList
  },
  {
    path: '/projects',
    name: 'ProjectList',
    component: ProjectList
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;