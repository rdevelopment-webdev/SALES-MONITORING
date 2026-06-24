// nuxt.config.ts
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  
  modules: ['@nuxtjs/tailwindcss'],

  // Tell Tailwind to scan your app directory for classes
  tailwindcss: {
    config: {
      content: [
        './app/**/*.{vue,js,ts}',
        './components/**/*.{vue,js,ts}',
        './app.vue'
      ]
    }
  },

  app: {
    head: {
      link: [
        { 
          rel: 'stylesheet', 
          href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' 
        }
      ]
    }
  }
})