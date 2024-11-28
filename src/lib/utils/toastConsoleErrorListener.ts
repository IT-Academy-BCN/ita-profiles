/* eslint-disable func-names */
import { toast } from 'react-toastify'

const toastConsoleErrorListener = (): void => {
    const toastConsoleError = globalThis.console.error

    globalThis.console.error = function (message, ...params): void {
        // Display the error message in a toast notification
        toast.error(message, {
            className: 'toast-error',
            autoClose: 2000,
            closeButton: false,
            bodyClassName: 'toast-body',
            progressClassName: 'toast-progress',
            position: 'bottom-left',
            draggable: false,
            pauseOnHover: true,
        })
        // Call the original function console.error
        toastConsoleError.apply(console, [message, params])
    }
}

export default toastConsoleErrorListener
