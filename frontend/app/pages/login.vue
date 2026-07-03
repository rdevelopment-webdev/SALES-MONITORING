<template>
  <div
    class="h-screen w-screen overflow-hidden flex m-0 p-0 box-border select-none"
  >
    <div class="flex flex-row w-full h-full">
      <!-- Left Panel -->
      <div
        class="w-[33%] min-w-[300px] max-w-[420px] h-full bg-[#1F2835] relative flex flex-col items-center text-center px-12 pt-20 overflow-hidden shrink-0"
      >
        <!-- Diagonal stripes -->
        <div
          class="absolute top-11 left-0 w-full h-auto flex flex-col gap-3 scale-[1.17] pointer-events-none z-[1]"
          style="transform: rotate(-10deg)"
        >
          <div
            class="h-9 w-[140%] -left-[20%] relative bg-white opacity-[0.07]"
          ></div>
          <div
            class="h-9 w-[140%] -left-[20%] relative bg-white opacity-[0.07]"
          ></div>
          <div
            class="h-9 w-[140%] -left-[20%] relative bg-white opacity-[0.07]"
          ></div>
          <div
            class="h-9 w-[117%] -left-[20%] relative bg-[#FFB300] opacity-[0.07]"
          ></div>
          <div
            class="h-9 w-[114.5%] -left-[20%] relative bg-[#FFB300] opacity-[0.06]"
          ></div>
          <div
            class="h-9 w-[113.5%] -left-[20%] relative bg-[#FFB300] opacity-[0.06]"
          ></div>
          <div
            class="h-9 w-[140%] -left-[20%] relative bg-white opacity-[0.07]"
          ></div>
          <div
            class="h-9 w-[140%] -left-[20%] relative bg-white opacity-[0.07]"
          ></div>
        </div>

        <!-- Logo & Title -->
        <div class="z-[2] flex flex-col items-center">
          <div
            class="w-[170px] mt-20 h-[170px] bg-white flex items-center justify-center mb-14 shadow-[0_4px_12px_rgba(0,0,0,0.15)] overflow-hidden rounded"
          >
            <img
              src="/Rweb logo.png"
              alt="Web Solutions Logo"
              class="max-w-full max-h-full object-contain block"
            />
          </div>

          <h1
            class="text-white text-[34px] font-extrabold leading-[1.25] italic font-sans"
          >
            Sales & Marketing<br />
            <span class="text-[#F25C11]">Monitoring</span> System
          </h1>
        </div>

        <!-- Hashtag -->
        <div class="z-[2] mt-auto pb-4 text-white text-[12px] tracking-[0.2px]">
          #BuildingBridgesAcrossTheWeb
        </div>
      </div>

      <!-- Right Panel (login form) -->
      <div
        class="flex-1 h-full bg-white flex items-center justify-center overflow-hidden"
      >
        <div
          class="w-[424px] bg-white border-[1.5px] border-gray-400 rounded-[20px] px-8 py-9"
        >
          <h2 class="text-[40px] font-bold text-[#F25C11] mb-[-9px] font-sans">
            Welcome!
          </h2>
          <p class="text-[16px] font-semibold text-[#1F2835] mb-6 font-sans">
            Log in to continue to your dashboard
          </p>

          <!-- Error Message -->
          <div
            v-if="error"
            class="mb-4 p-3 bg-red-50 border border-red-200 rounded-[6px] text-red-600 text-[13px] text-center"
          >
            {{ error }}
          </div>

          <form @submit.prevent="handleLogin">
            <div class="mb-[14px]">
              <label
                for="email"
                class="block text-[14px] text-[#1F2835] mb-[6px] text-left font-bold font-sans"
                >Email address</label
              >
              <div class="relative flex items-center">
                <svg
                  class="absolute left-3 text-[#F52C11] w-[14px] h-[14px]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                  />
                </svg>
                <input
                  v-model="email"
                  type="email"
                  id="email"
                  placeholder="example@company.com"
                  required
                  :disabled="loading"
                  class="w-full h-[38px] pl-[34px] pr-[35px] border border-[#BBBBBB] rounded-[6px] text-[13px] text-[#1F2835] outline-none focus:border-[#F52C11] font-sans disabled:bg-gray-100"
                />
              </div>
            </div>

            <div class="mb-[14px]">
              <label
                for="password"
                class="block text-[14px] text-[#1F2835] mb-[6px] text-left font-bold font-sans"
                >Password</label
              >
              <div class="relative flex items-center">
                <svg
                  class="absolute left-3 text-[#F52C11] w-[14px] h-[14px]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                  />
                </svg>
                <input
                  v-model="password"
                  :type="showPassword ? 'text' : 'password'"
                  id="password"
                  placeholder="Enter your password"
                  required
                  :disabled="loading"
                  class="w-full h-[38px] pl-[34px] pr-[35px] border border-[#BBBBBB] rounded-[6px] text-[13px] text-[#1F2835] outline-none focus:border-[#F52C11] font-sans disabled:bg-gray-100"
                />
                <svg
                  @click="togglePasswordVisibility"
                  class="absolute right-3 text-[#F52C11] w-[14px] h-[14px] cursor-pointer"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    v-if="!showPassword"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    v-if="!showPassword"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                  <path
                    v-if="showPassword"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.9m2.9-2.9A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.574 2.9m-2.9 2.9l-9.9-9.9"
                  />
                  <path v-if="showPassword" d="M4 4l16 16" />
                </svg>
              </div>
            </div>

            <button
              type="submit"
              :disabled="loading"
              class="font-inter w-[172px] h-[38px] bg-[#F52C11] text-white text-[14px] font-bold border-none rounded-lg block mt-[22px] mb-[14px] mx-auto hover:opacity-90 transition-opacity duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ loading ? "Logging in..." : "Login" }}
            </button>

            <div class="text-center">
              <a
                href="#"
                class="text-[14px] font-semibold text-[#F52C11] no-underline hover:underline font-sans"
                >Forgot your password?</a
              >
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: false,
});

const { apiFetch } = useApi();
const email = ref("");
const password = ref("");
const showPassword = ref(false);
const loading = ref(false);
const error = ref("");

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const handleLogin = async () => {
  loading.value = true;
  error.value = "";

  try {
    const response = await apiFetch("/login", {
      method: "POST",
      body: {
        email: email.value.trim(),
        password: password.value,
      },
    });

    const payload = response?.data ?? response;
    const token = payload?.token;
    const user = payload?.user;

    if (!token || !user) {
      throw new Error("Login succeeded but the server did not return a token.");
    }

    localStorage.setItem("token", token);
    localStorage.setItem("user", JSON.stringify(user));

    await navigateTo("/users");
  } catch (err) {
    error.value =
      err?.data?.message ||
      err?.response?._data?.message ||
      err?.statusMessage ||
      err?.message ||
      "Login failed.";
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@700&display=swap");

.font-sans {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}
.font-inter {
  font-family: "Inter", sans-serif;
}
</style>
