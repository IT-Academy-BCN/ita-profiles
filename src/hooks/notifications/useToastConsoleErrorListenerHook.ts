import { useCallback } from "react";
import { toast } from "react-toastify";
import { useConsoleDebugHook } from "./useConsoleDebugHook";
import { useNotificationsHook } from "./useNotificationHook";
import { defaultOption } from "./notification.config";

export const useToastConsoleErrorListenerHook = () => {
    const consoleLogDevelper = useCallback(() => {

        const toastConsoleLog = globalThis.console.log;
        const toastConsoleError = globalThis.console.error;

        globalThis.console.log = (message, ...params): void => {
            toast.info(message, defaultOption({
                autoClose: 3000
            }));
            toastConsoleLog.apply(console, [message, params])
        }

        globalThis.console.error = (message, ...params): void => {
            toast.error(message, defaultOption({
                autoClose: 3000
            }));
            toastConsoleError.apply(console, [message, params])
        }

    }, [])

    return { consoleLogDevelper, ...useConsoleDebugHook(), ...useNotificationsHook() }
}
