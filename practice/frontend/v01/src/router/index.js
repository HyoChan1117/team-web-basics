// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";

const routes = [
  { path: "/students", component: () => import("../components/StudentTable.vue") },
  { path: "/students/create", component: () => import("../pages/StudentCreatePage.vue") },
  { path: "/students/:std_id", component: () => import("../pages/StudentDetailPage.vue") },
  { path: "/students/:std_id/edit", component: () => import("../pages/StudentEditPage.vue") },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
