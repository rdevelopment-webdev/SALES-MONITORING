export const useUserApi = () => {
  const { apiFetch } = useApi();

  const fetchUsers = async () => {
    const data = await apiFetch("/users");
    return { data };
  };

  const fetchRoles = async () => {
    const data = await apiFetch("/roles");
    return { data };
  };

  const fetchUser = async (id: number | string) => {
    const data = await apiFetch(`/users/${id}`);
    return { data };
  };

  const updateUser = (id: number | string, body: Record<string, unknown>) => {
    return apiFetch(`/users/${id}`, {
      method: "PUT",
      body,
    });
  };

  const archiveUser = (id: number) => {
    return apiFetch(`/users/${id}`, {
      method: "DELETE",
    });
  };

  const archiveUsers = (ids: number[]) => {
    return apiFetch("/users/archive", {
      method: "POST",
      body: { ids },
    });
  };

  const fetchArchivedUsers = async () => {
    const data = await apiFetch("/users/archived");
    return { data };
  };

  const restoreUser = (id: number) => {
    return apiFetch(`/users/${id}/restore`, {
      method: "POST",
    });
  };

  const deleteUser = (id: number) => {
    return apiFetch(`/users/${id}/force-delete`, {
      method: "DELETE",
    });
  };

  return {
    fetchUsers,
    fetchRoles,
    fetchUser,
    updateUser,
    archiveUser,
    archiveUsers,
    fetchArchivedUsers,
    restoreUser,
    deleteUser,
  };
};
