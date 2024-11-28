import { useCallback } from "react";
import { toast } from "react-toastify";
import { defaultOption } from "./notification.config";

export const useNotificationsHook = () => {
  const showNotification = useCallback((message: string) => {
    if (!message) return;
    toast.info(message, defaultOption("default"));
  }, []);
  const showNotificationModal = useCallback((message: string) => {
    if (!message) return;
    toast.info(message, defaultOption({
      autoClose: 3000,
      theme: 'colored',
    }));
  }, []);

  return { showNotification, showNotificationModal };

}
