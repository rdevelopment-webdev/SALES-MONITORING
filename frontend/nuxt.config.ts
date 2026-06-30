import { defineNuxtConfig } from "nuxt/config";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  future: {
    compatibilityVersion: 4,
  },
  devtools: { enabled: true },

  modules: ["@nuxtjs/tailwindcss", "@sidebase/nuxt-auth"],

  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || "http://localhost:8000",
    },
  },

  auth: {
    baseURL: process.env.NUXT_PUBLIC_API_BASE || "http://localhost:8000",
    provider: {
      type: "local",
      endpoints: {
        signIn: { path: "/login", method: "post" },
        signOut: { path: "/logout", method: "post" },
        getSession: { path: "/user", method: "get" },
      },
    },
  },

  tailwindcss: {
    config: {
      content: [
        "./app/**/*.{vue,js,ts}",
        "./components/**/*.{vue,js,ts}",
        "./app.vue",
      ],
    },
  },

  app: {
    head: {
      link: [
        {
          rel: "stylesheet",
          href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css",
        },
      ],
    },
  },
});
