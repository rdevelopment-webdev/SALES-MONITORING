<template></template>

<script setup>
definePageMeta({
  layout: false,
});

if (process.client) {
  const token = localStorage.getItem("token");
  await navigateTo(token ? "/users" : "/login");
}
</script>
