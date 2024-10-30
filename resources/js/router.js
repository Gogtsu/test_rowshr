import { createRouter, createWebHistory } from 'vue-router';
import EmployeeList from './employee/List.vue';
import EmployeeListOptimized from './employee-optimized/List.vue';
import ProjectList from './project/List.vue';
import ProjectListOptimized from './project-optimized/List.vue';

const routes = [
  {
    path: '/',
    name: 'EmployeeList',
    component: EmployeeList
  },
  {
    path: '/employees-optimized',
    name: 'EmployeeListOptimized',
    component: EmployeeListOptimized
  },
  {
    path: '/projects',
    name: 'ProjectList',
    component: ProjectList
  },
  {
    path: '/projects-optimized',
    name: 'ProjectListOptimized',
    component: ProjectListOptimized
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;