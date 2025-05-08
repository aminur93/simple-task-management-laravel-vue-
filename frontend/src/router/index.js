import { createWebHistory, createRouter } from "vue-router";
import AuthRouter from "@/router/auth/AuthRouter";
import AdminRouter from "@/router/admin/AdminRouter";

const routes = [...AuthRouter, ...AdminRouter];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
