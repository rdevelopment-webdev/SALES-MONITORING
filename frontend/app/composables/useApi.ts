export const useApi = () => {
  const config = useRuntimeConfig();
  const baseURL = config.public.apiBase as string;

  const apiFetch = $fetch.create({
    baseURL,
    credentials: "include",
    headers: {
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest",
    },
    onResponseError({ response }) {
      if (response.status === 401) {
        navigateTo("/login");
      }
    },
  });

  return { apiFetch };
};
