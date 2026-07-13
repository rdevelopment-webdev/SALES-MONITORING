// ✅ Fixed auth.ts
import type { RouteLocationNormalized } from "vue-router";

export default defineNuxtRouteMiddleware(
  (to: RouteLocationNormalized, from: RouteLocationNormalized) => {
    if (process.client) {
      const { read } = useBrowserStorage();
      const token = read("token");
      if (!token && to.path !== "/login") {
        return navigateTo("/login");
      }
    }
  }
);
