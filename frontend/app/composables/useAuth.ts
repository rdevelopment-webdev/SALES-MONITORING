export const useAuth = () => {
  const config = useRuntimeConfig();
  const baseURL = `${config.public.apiBase as string}/api`;
  const { write, remove } = useBrowserStorage();

  const login = async (email: string, password: string) => {
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
      write("token", token);
    }

    if (user) {
      write("user", JSON.stringify(user));
    }

    await refreshNuxtData("user");
    return navigateTo("/users");
  };

  const logout = async () => {
    const { apiFetch } = useApi();
    await apiFetch("/logout", { method: "POST" });
    remove("token");
    remove("user");
    await refreshNuxtData("user");
    return navigateTo("/login");
  };

  const fetchUser = () => {
    const { apiFetch } = useApi();
    return useAsyncData("user", () => apiFetch("/me"));
  };

  return { login, logout, fetchUser };
};
