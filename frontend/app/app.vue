<template>
  <component :is="currentPage" />
</template>

<script setup>
import { computed } from "vue";

// Import all your page designs
import Login from "./Login.vue";
import LayoutsApp from "./layouts/app.vue";
import UsersIndex from "./admin/users/Index.vue";
import UsersCreate from "./admin/users/create.vue";
import PipIndex from "./admin/PIP/Index.vue";
import PipCreate from "./admin/PIP/create.vue";

// Map URL names to components
const pages = {
  "users-create": UsersCreate,
  "users-index": UsersIndex,
  "pip-create": PipCreate,
  "pip-index": PipIndex,
  login: Login,
  "layouts-app": LayoutsApp,
};

const route = useRoute();

const pathPages = {
  "/": Login,
  "/login": Login,
  "/admin/layouts/app": LayoutsApp,
  "/admin/users": UsersIndex,
  "/admin/users/create": UsersCreate,
  "/admin/pip": PipIndex,
  "/admin/pip/create": PipCreate,
};

const currentPage = computed(() => {
  const pageName = route.query.page;
  if (typeof pageName === "string" && pages[pageName]) {
    return pages[pageName];
  }

  return pathPages[route.path] || Login;
});
</script>
