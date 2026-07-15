// Resolves the CURRENTLY LOGGED-IN user's canView / canEdit / canAdd
// permissions for a given page, read directly from that user's saved
// user_page_permissions rows.
//
// There is no role-level fallback: a page with no saved row for this user
// means the user has no access to it (fails closed) — the same model
// edit.vue and create.vue use when saving permissions for other users.
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
  // localStorage doesn't exist during SSR.
  if (!import.meta.client) return null;

  try {
    const stored = localStorage.getItem("user");
    return stored ? JSON.parse(stored) : null;
  } catch (error) {
    console.error("usePermissions: error reading logged-in user:", error);
    return null;
  }
}

// The user object cached at login doesn't always include a numeric id
// (it currently only has full_name/email/role/role_id/permissions), but it
// DOES already embed a can_view flag per page — the same data that drives
// the sidebar's module list. We can resolve canView from that immediately,
// with no id and no network round trip required.
function getEmbeddedCanView(storedUser, pageSlug) {
  const embeddedPermissions = Array.isArray(storedUser?.permissions)
    ? storedUser.permissions
    : [];

  const match = embeddedPermissions.find(
    (permission) =>
      normalizeSlug(permission.page_name) === normalizeSlug(pageSlug) ||
      normalizeSlug(permission.permission_name) === normalizeSlug(pageSlug)
  );

  return Boolean(match?.can_view);
}

export function usePermissions(pageSlug) {
  const { apiFetch } = useApi();

  const isLoading = ref(true);
  const error = ref(null);

  // Fail closed: no access is granted until the check completes successfully.
  const canView = ref(false);
  const canEdit = ref(false);
  const canAdd = ref(false);

  // canEdit/canAdd need this user's numeric id to query user_page_permissions.
  // If it's not cached on the stored user object, fall back to the
  // authenticated /me endpoint (Bearer token is already attached by apiFetch).
  async function resolveCurrentUserId(storedUser) {
    const idFromStorage =
      storedUser?.id || storedUser?._id || storedUser?.user_id || null;
    if (idFromStorage) return idFromStorage;

    try {
      const meResponse = await apiFetch("/me");
      const me =
        meResponse?.data?.user ||
        meResponse?.user ||
        meResponse?.data ||
        meResponse;
      return me?.id || me?._id || me?.user_id || null;
    } catch (meError) {
      console.error(
        "usePermissions: unable to resolve current user id via /me.",
        meError
      );
      return null;
    }
  }

  async function load() {
    // Auth state (the stored user, the token used for /me) lives in
    // localStorage, which only exists in the browser. During SSR there's no
    // reliable way to resolve any of this, so skip the check server-side —
    // isLoading stays at its initial `true`, so the page renders "Checking
    // permissions..." instead of flashing a false "access denied". The
    // client re-runs this composable's setup from scratch on hydration and
    // performs the real check then.
    if (!import.meta.client) return;

    isLoading.value = true;
    error.value = null;

    try {
      const storedUser = getStoredUser();

      // Quick path: resolve canView from the login-time snapshot right away
      // so the page can render without waiting on a network round trip.
      canView.value = getEmbeddedCanView(storedUser, pageSlug);

      const userId = await resolveCurrentUserId(storedUser);

      if (!userId) {
        // No id available anywhere — can't look up edit/add, so those fail
        // closed, but keep whatever canView we already resolved above.
        canEdit.value = false;
        canAdd.value = false;
        return;
      }

      const [pagesResponse, userPermissionsResponse] = await Promise.all([
        apiFetch("/pages"),
        apiFetch(`/user_page_permissions?user_id=${userId}`),
      ]);

      const pages = unwrapData(pagesResponse);
      const userPermissions = unwrapData(userPermissionsResponse);

      const page = pages.find(
        (p) => normalizeSlug(p.page_name) === normalizeSlug(pageSlug)
      );

      if (!page) {
        console.warn(`usePermissions: page "${pageSlug}" was not found.`);
        canEdit.value = false;
        canAdd.value = false;
        return;
      }

      const savedPermission = userPermissions.find(
        (permission) =>
          Number(permission.user_id) === Number(userId) &&
          Number(permission.page_id) === Number(page.id)
      );

      // This live lookup is authoritative — it supersedes the cached
      // login-time snapshot used for the quick path above.
      canView.value = Boolean(savedPermission?.can_view);
      canEdit.value = Boolean(savedPermission?.can_edit);
      canAdd.value = Boolean(savedPermission?.can_create);
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
