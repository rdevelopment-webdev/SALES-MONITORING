// Resolves the CURRENTLY LOGGED-IN user's effective canView / canEdit / canAdd
// permissions for a given page.
//
// Effective permission = that user's role defaults (role_page_permissions)
// with any per-user override (user_page_permissions) layered on top — the
// same logic already used on /users/edit and /users/create when configuring
// OTHER users' access (see applyEffectivePermissions in edit.vue).
//
// Usage:
//   const { canView, canEdit, canAdd, ready } = usePermissions("user-management");
//   await ready; // optional: wait for the initial check to resolve
import { ref } from "vue";

function normalizeSlug(value) {
  return String(value || "")
    .toLowerCase()
    .replace(/[-_\s]+/g, "");
}

function unwrapData(response) {
  return Array.isArray(response) ? response : response?.data || [];
}

function getStoredUser() {
  try {
    const stored = localStorage.getItem("user");
    return stored ? JSON.parse(stored) : null;
  } catch (error) {
    console.error("usePermissions: error reading logged-in user:", error);
    return null;
  }
}

export function usePermissions(pageSlug) {
  const { apiFetch } = useApi();
  const { fetchUser } = useUserApi();

  const isLoading = ref(true);
  const error = ref(null);

  // Fail closed: no access is granted until the check completes successfully.
  const canView = ref(false);
  const canEdit = ref(false);
  const canAdd = ref(false);

  async function load() {
    isLoading.value = true;
    error.value = null;

    try {
      const storedUser = getStoredUser();
      const userId =
        storedUser?.id || storedUser?._id || storedUser?.user_id || null;

      if (!userId) {
        canView.value = false;
        canEdit.value = false;
        canAdd.value = false;
        return;
      }

      // Reuse the role already on the stored user if present, otherwise
      // fetch the full record so we have a role_id to look up.
      let roleId = storedUser?.role_id || storedUser?.role?.id || null;
      if (!roleId) {
        const userResponse = await fetchUser(userId);
        const fullUser = userResponse?.data || userResponse;
        roleId = fullUser?.role_id || fullUser?.role?.id || null;
      }

      const [pagesResponse, rolePermissionsResponse] = await Promise.all([
        apiFetch("/pages"),
        apiFetch("/role_page_permissions"),
      ]);

      const pages = unwrapData(pagesResponse);
      const rolePermissions = unwrapData(rolePermissionsResponse);

      const page = pages.find(
        (p) => normalizeSlug(p.page_name) === normalizeSlug(pageSlug)
      );

      if (!page) {
        console.warn(`usePermissions: page "${pageSlug}" was not found.`);
        canView.value = false;
        canEdit.value = false;
        canAdd.value = false;
        return;
      }

      const roleDefault = rolePermissions.find(
        (permission) =>
          Number(permission.role_id) === Number(roleId) &&
          Number(permission.page_id) === Number(page.id)
      );

      let effective = {
        view: Boolean(roleDefault?.can_view),
        edit: Boolean(roleDefault?.can_edit),
        add: Boolean(roleDefault?.can_create),
      };

      // Per-user overrides win over the role default when present. If this
      // endpoint fails we just fall back to the role defaults above, same
      // as the graceful-degradation behavior already used in edit.vue.
      try {
        const overridesResponse = await apiFetch(
          `/user_page_permissions?user_id=${userId}`
        );
        const overrides = unwrapData(overridesResponse);
        const override = overrides.find(
          (permission) => Number(permission.page_id) === Number(page.id)
        );

        if (override) {
          effective = {
            view: override.can_view ?? effective.view,
            edit: override.can_edit ?? effective.edit,
            add: override.can_create ?? effective.add,
          };
        }
      } catch (overrideError) {
        console.error(
          "usePermissions: unable to load permission overrides, falling back to role defaults.",
          overrideError
        );
      }

      canView.value = effective.view;
      canEdit.value = effective.edit;
      canAdd.value = effective.add;
    } catch (loadError) {
      console.error(
        "usePermissions: unable to resolve permissions.",
        loadError
      );
      error.value = loadError;
      canView.value = false;
      canEdit.value = false;
      canAdd.value = false;
    } finally {
      isLoading.value = false;
    }
  }

  const ready = load();

  return {
    isLoading,
    error,
    canView,
    canEdit,
    canAdd,
    ready,
    reload: load,
  };
}
