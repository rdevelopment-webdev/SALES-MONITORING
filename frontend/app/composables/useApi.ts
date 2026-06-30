export const useApi = () => {
  const config = useRuntimeConfig();
  const baseURL = config.public.apiBase as string;

  const apiFetch = $fetch.create({
    baseURL,
    credentials: "include",
    onRequest({ options }) {
      const token = localStorage.getItem("token");
      options.headers = {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
        ...(options.headers || {}),
      };
    },
    onResponseError({ response }) {
      if (response.status === 401) {
        navigateTo("/login");
      }
    },
  });

  return { apiFetch };
};
