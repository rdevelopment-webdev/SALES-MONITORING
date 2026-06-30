export const useAuth = () => {
  const config = useRuntimeConfig();
  const baseURL = config.public.apiBase as string;

  const login = async (email: string, password: string) => {
    await $fetch("/sanctum/csrf-cookie", {
      baseURL,
      credentials: "include",
    });

    const response = await $fetch("/login", {
      baseURL,
      method: "POST",
      body: { email, password },
      credentials: "include",
    });

    const payload = response?.data ?? response;
    const token = payload?.token ?? response?.token;
    const user = payload?.user ?? response?.user;

    if (token) {
      localStorage.setItem("token", token);
    }

    if (user) {
      localStorage.setItem("user", JSON.stringify(user));
    }

    await refreshNuxtData("user");
    return navigateTo("/admin/layouts/app");
  };

  const logout = async () => {
    const { apiFetch } = useApi();
    await apiFetch("/logout", { method: "POST" });
    await refreshNuxtData("user");
    return navigateTo("/login");
  };

  const fetchUser = () => {
    const { apiFetch } = useApi();
    return useAsyncData("user", () => apiFetch("/api/user"));
  };

  return { login, logout, fetchUser };
};
