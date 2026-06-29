// ✅ Fixed auth.ts
import type { RouteLocationNormalized } from "vue-router";

export default defineNuxtRouteMiddleware(
  (to: RouteLocationNormalized, from: RouteLocationNormalized) => {
    if (process.client) {
      const token = localStorage.getItem("token");
      if (!token && to.path !== "/login") {
        return navigateTo("/login");
      }
    }
  }
);
