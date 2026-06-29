<template>
  <component :is="currentPage" />
</template>

<script setup>
import { ref, onMounted } from 'vue'

// Import all your page designs
import Login from './Login.vue'
import LayoutsApp from './layouts/App.vue'
import UsersIndex from './admin/users/Index.vue'
import UsersCreate from './admin/users/create.vue'
import PipIndex from './admin/pip/Index.vue'
import PipCreate from './admin/pip/create.vue'


// Map URL names to components
const pages = {
  'users-create': UsersCreate,
  'users-index': UsersIndex,
  'pip-create': PipCreate,
  'pip-index': PipIndex,
  'login': Login,
  'layouts-app': LayoutsApp,
}

// Default to Login on server, then update on client
const currentPage = ref(Login)

onMounted(() => {
  const params = new URLSearchParams(window.location.search)
  const pageName = params.get('page')
  if (pageName && pages[pageName]) {
    currentPage.value = pages[pageName]
  }
})
</script>