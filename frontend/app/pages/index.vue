<template></template>

<script setup>
definePageMeta({
  layout: false,
});

if (process.client) {
  const { read } = useBrowserStorage();
  const token = read("token");
  await navigateTo(token ? "/users" : "/login");
}
</script>
