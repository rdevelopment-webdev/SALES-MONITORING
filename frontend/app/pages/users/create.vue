<template>
  <div class="user-management">
    <!-- Header -->
    <header class="header">
      <h1 class="header-title">User Management</h1>
      <div class="header-actions">
        <button class="icon-btn notification-btn">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
          </svg>
          <span class="notification-badge">3</span>
        </button>
        <button class="icon-btn settings-btn">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path
              d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.1a2 2 0 0 1-1-1.72v-.51a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"
            />
            <circle cx="12" cy="12" r="3" />
          </svg>
        </button>
      </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Page Header -->
      <div class="page-header">
        <button class="back-btn" @click="goBack">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="m15 18-6-6 6-6" />
          </svg>
        </button>
        <div class="page-header-text">
          <h2 class="page-title">Create New User</h2>
          <p class="page-subtitle">
            Add a new user to the system with roles and permissions
          </p>
        </div>
      </div>

      <!-- Form Card -->
      <div class="form-card">
        <form @submit.prevent="handleSubmit">
          <!-- Form Fields -->
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">
                Full Name <span class="required">*</span>
              </label>
              <input
                v-model="form.fullName"
                type="text"
                class="form-input"
                placeholder="John Doe"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">
                Email <span class="required">*</span>
              </label>
              <input
                v-model="form.email"
                type="email"
                class="form-input"
                placeholder="john@example.com"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">
                Role <span class="required">*</span>
              </label>
              <div class="select-wrapper">
                <select v-model="form.role" class="form-select" required>
                  <option value="" disabled>Select a role</option>
                  <option value="admin">Administrator</option>
                  <option value="manager">Manager</option>
                  <option value="editor">Editor</option>
                  <option value="viewer">Viewer</option>
                </select>
                <svg
                  class="select-arrow"
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">
                Password <span class="required">*</span>
              </label>
              <div class="input-wrapper">
                <input
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  class="form-input"
                  placeholder="••••••••"
                  required
                />
                <button
                  type="button"
                  class="toggle-password"
                  @click="showPassword = !showPassword"
                >
                  <svg
                    v-if="!showPassword"
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                    <circle cx="12" cy="12" r="3" />
                  </svg>
                  <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                    <path
                      d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"
                    />
                    <path
                      d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7c.78 0 1.53-.09 2.24-.26"
                    />
                    <path d="M2 2l20 20" />
                  </svg>
                </button>
              </div>
            </div>

            <div class="form-group full-width">
              <label class="form-label">
                Confirm Password <span class="required">*</span>
              </label>
              <div class="input-wrapper">
                <input
                  v-model="form.confirmPassword"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  class="form-input"
                  placeholder="••••••••"
                  required
                />
                <button
                  type="button"
                  class="toggle-password"
                  @click="showConfirmPassword = !showConfirmPassword"
                >
                  <svg
                    v-if="!showConfirmPassword"
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                    <circle cx="12" cy="12" r="3" />
                  </svg>
                  <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                    <path
                      d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"
                    />
                    <path
                      d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7c.78 0 1.53-.09 2.24-.26"
                    />
                    <path d="M2 2l20 20" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Divider -->
          <hr class="divider" />

          <!-- Role Permissions -->
          <div class="permissions-section">
            <h3 class="permissions-title">Role Permissions</h3>
            <p class="permissions-subtitle">
              Select which pages this role can access:
            </p>

            <div class="permissions-grid">
              <label
                v-for="permission in permissions"
                :key="permission.id"
                class="permission-item"
              >
                <input
                  v-model="form.permissions"
                  type="checkbox"
                  :value="permission.id"
                  class="permission-checkbox"
                />
                <span class="checkbox-custom"></span>
                <span class="permission-name">{{ permission.name }}</span>
                <span class="permission-desc"
                  >— {{ permission.description }}</span
                >
              </label>
            </div>

            <!-- Info Alert -->
            <div class="info-alert">
              <svg
                class="info-icon"
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <circle cx="12" cy="12" r="10" />
                <path d="M12 16v-4" />
                <path d="M12 8h.01" />
              </svg>
              <span
                >No permissions selected. User will have limited access.</span
              >
            </div>
          </div>

          <!-- Form Actions -->
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" @click="goBack">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              :disabled="isSubmitting"
            >
              {{ isSubmitting ? "Creating..." : "Create User" }}
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";

// Form state
const form = reactive({
  fullName: "",
  email: "",
  role: "",
  password: "",
  confirmPassword: "",
  permissions: [],
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);
const isSubmitting = ref(false);

// Permissions data
const permissions = [
  {
    id: "dashboard",
    name: "Dashboard",
    description: "Access to dashboard and analytics",
  },
  {
    id: "users",
    name: "Users Management",
    description: "Manage users and their roles",
  },
  {
    id: "roles",
    name: "Roles Management",
    description: "Create and manage roles",
  },
  {
    id: "reports",
    name: "Reports",
    description: "Access to reports and data export",
  },
  {
    id: "settings",
    name: "Settings",
    description: "Access to system settings",
  },
  {
    id: "products",
    name: "Products",
    description: "Manage products and inventory",
  },
  { id: "orders", name: "Orders", description: "View and manage orders" },
  {
    id: "customers",
    name: "Customers",
    description: "Manage customer information",
  },
  {
    id: "permissions",
    name: "Permissions",
    description: "Manage permissions and access",
  },
  { id: "audit", name: "Audit Logs", description: "View system audit logs" },
];

// Methods
const goBack = () => {
  // Navigate back or emit event
  console.log("Go back");
};

const handleSubmit = async () => {
  // Validate passwords match
  if (form.password !== form.confirmPassword) {
    alert("Passwords do not match!");
    return;
  }

  isSubmitting.value = true;

  try {
    // Simulate API call
    await new Promise((resolve) => setTimeout(resolve, 1500));
    console.log("User created:", form);
    alert("User created successfully!");
    // Reset form or redirect
  } catch (error) {
    console.error("Error creating user:", error);
    alert("Failed to create user");
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
/* Base */
.user-management {
  min-height: 100vh;
  background-color: #f3f4f6;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    "Helvetica Neue", Arial, sans-serif;
}

/* Header */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 32px;
  background-color: #ffffff;
  border-bottom: 1px solid #e5e7eb;
}

.header-title {
  font-size: 20px;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.header-actions {
  display: flex;
  gap: 12px;
  align-items: center;
}

.icon-btn {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border: none;
  background: transparent;
  cursor: pointer;
  border-radius: 8px;
  color: #6b7280;
  transition: background-color 0.2s;
}

.icon-btn:hover {
  background-color: #f3f4f6;
}

.notification-badge {
  position: absolute;
  top: 2px;
  right: 2px;
  background-color: #dc2626;
  color: #ffffff;
  font-size: 11px;
  font-weight: 600;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Main Content */
.main-content {
  padding: 24px 32px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Page Header */
.page-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
}

.back-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  background-color: #ffffff;
  cursor: pointer;
  color: #374151;
  transition: background-color 0.2s;
}

.back-btn:hover {
  background-color: #f9fafb;
}

.page-title {
  font-size: 22px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 4px 0;
}

.page-subtitle {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
}

/* Form Card */
.form-card {
  background-color: #ffffff;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  padding: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* Form Grid */
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-label {
  font-size: 14px;
  font-weight: 500;
  color: #111827;
}

.required {
  color: #dc2626;
}

.form-input,
.form-select {
  width: 100%;
  padding: 10px 14px;
  font-size: 14px;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  background-color: #ffffff;
  color: #111827;
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
  box-sizing: border-box;
}

.form-input:focus,
.form-select:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input::placeholder {
  color: #9ca3af;
}

.select-wrapper {
  position: relative;
}

.form-select {
  appearance: none;
  cursor: pointer;
}

.select-arrow {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
  color: #6b7280;
}

.input-wrapper {
  position: relative;
}

.input-wrapper .form-input {
  padding-right: 44px;
}

.toggle-password {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: #6b7280;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px;
}

.toggle-password:hover {
  color: #374151;
}

/* Divider */
.divider {
  border: none;
  border-top: 1px solid #e5e7eb;
  margin: 28px 0;
}

/* Permissions Section */
.permissions-section {
  margin-bottom: 28px;
}

.permissions-title {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin: 0 0 4px 0;
}

.permissions-subtitle {
  font-size: 14px;
  color: #6b7280;
  margin: 0 0 16px 0;
}

.permissions-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.permission-item {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  padding: 4px 0;
}

.permission-checkbox {
  display: none;
}

.checkbox-custom {
  width: 18px;
  height: 18px;
  border: 2px solid #d1d5db;
  border-radius: 4px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.permission-checkbox:checked + .checkbox-custom {
  background-color: #dc2626;
  border-color: #dc2626;
}

.permission-checkbox:checked + .checkbox-custom::after {
  content: "";
  width: 5px;
  height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
  margin-bottom: 2px;
}

.permission-name {
  font-size: 14px;
  font-weight: 500;
  color: #111827;
}

.permission-desc {
  font-size: 14px;
  color: #6b7280;
}

/* Info Alert */
.info-alert {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 16px;
  background-color: #eff6ff;
  border: 1px solid #bfdbfe;
  border-radius: 8px;
  margin-top: 20px;
  font-size: 14px;
  color: #1d4ed8;
}

.info-icon {
  flex-shrink: 0;
  color: #3b82f6;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 28px;
}

.btn {
  padding: 10px 24px;
  font-size: 14px;
  font-weight: 500;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
}

.btn-secondary {
  background-color: #ffffff;
  color: #374151;
  border: 1px solid #d1d5db;
}

.btn-secondary:hover {
  background-color: #f9fafb;
}

.btn-primary {
  background-color: #dc2626;
  color: #ffffff;
}

.btn-primary:hover:not(:disabled) {
  background-color: #b91c1c;
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
  .form-grid,
  .permissions-grid {
    grid-template-columns: 1fr;
  }

  .main-content {
    padding: 16px;
  }

  .form-card {
    padding: 20px;
  }
}
</style>
