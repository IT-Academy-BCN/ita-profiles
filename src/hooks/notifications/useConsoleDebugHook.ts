import { useCallback } from "react";
import { toast } from "react-toastify";
import { defaultOption } from "./notification.config";
import { TConsoleLog } from "./notification.types";


export const useConsoleDebugHook = () => {
  const consoleLogDebug = useCallback((message: TConsoleLog) => {
    if (typeof message === "string") {
      toast.info(message, defaultOption({
        position: "top-center",
      }));
    } else if (Object.keys(message).length > 0) {
      toast.info(JSON.stringify(message), defaultOption({
        position: "top-center",
      }));
    }
  }, []);

  const consoleErrorDebug = useCallback((message: TConsoleLog) => {
    if (typeof message === "string") {
      toast.warning(message, defaultOption({
        position: "top-center",
      }));
    } else if (Object.keys(message).length > 0) {
      toast.warning(JSON.stringify(message), defaultOption({
        position: "top-center",
      }));
    }
  }, []);

  return { consoleLogDebug, consoleErrorDebug };
}
