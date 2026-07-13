export function useBrowserStorage() {
  const getStorage = () => {
    try {
      if (typeof window === "undefined") return null;
      if (typeof window.localStorage === "undefined") return null;
      return window.localStorage;
    } catch {
      return null;
    }
  };

  const read = (key: string) => {
    const storage = getStorage();
    if (!storage) return null;

    try {
      return storage.getItem(key);
    } catch {
      return null;
    }
  };

  const write = (key: string, value: string) => {
    const storage = getStorage();
    if (!storage) return false;

    try {
      storage.setItem(key, value);
      return true;
    } catch {
      return false;
    }
  };

  const remove = (key: string) => {
    const storage = getStorage();
    if (!storage) return false;

    try {
      storage.removeItem(key);
      return true;
    } catch {
      return false;
    }
  };

  return { read, write, remove };
}
