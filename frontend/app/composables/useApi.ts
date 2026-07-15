export const useApi = () => {
  const config = useRuntimeConfig();
  const configuredBase = (config.public.apiBase as string).replace(/\/$/, "");
  const baseURL = configuredBase.endsWith("/api")
    ? configuredBase
    : `${configuredBase}/api`;

  const apiFetch = $fetch.create({
    baseURL,
    credentials: "include",
    onRequest({ options }) {
      // localStorage only exists in the browser — this composable can be
      // invoked during SSR (e.g. via useAsyncData), so guard it rather than
      // letting the request crash the server render.
      const token = import.meta.client ? localStorage.getItem("token") : null;
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
