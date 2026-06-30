export const useAuth = () => {
  const config = useRuntimeConfig();
  const baseURL = config.public.apiBase as string;

  const login = async (email: string, password: string) => {
    await $fetch("/sanctum/csrf-cookie", {
      baseURL,
      credentials: "include",
    });

    await $fetch("/login", {
      baseURL,
      method: "POST",
      body: { email, password },
      credentials: "include",
    });

    await refreshNuxtData("user");
    return navigateTo("/dashboard");
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
