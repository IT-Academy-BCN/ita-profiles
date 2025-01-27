import { renderHook, act } from "@testing-library/react";
import * as Toastify from "react-toastify";
import { useToastConsoleErrorListenerHook } from "../../../hooks/notifications/useToastConsoleErrorListenerHook";

vi.mock("react-toastify", async () => {
    const actual = await vi.importActual<typeof Toastify>("react-toastify");
    return {
        ...actual,
        toast: {
            info: vi.fn(),
            error: vi.fn(),
        },
    };
});

describe("useToastConsoleErrorListenerHook", () => {
    let originalConsoleLog: typeof console.log;
    let originalConsoleError: typeof console.error;

    beforeEach(() => {
        originalConsoleLog = globalThis.console.log;
        originalConsoleError = globalThis.console.error;

        globalThis.console.log = vi.fn();
        globalThis.console.error = vi.fn();
    });

    afterEach(() => {
        globalThis.console.log = originalConsoleLog;
        globalThis.console.error = originalConsoleError;
        vi.restoreAllMocks();
    });

    it("should intercept console.log and call toast.info", () => {
        const { result } = renderHook(() => useToastConsoleErrorListenerHook());

        act(() => {
            result.current.consoleLogDevelper();
        });

        console.log("Mensaje de prueba");

        expect(Toastify.toast.info).toHaveBeenCalledWith(
            "Mensaje de prueba",
            expect.any(Object)
        );
    });

    it("should intercept console.error and call toast.error", () => {
        const { result } = renderHook(() => useToastConsoleErrorListenerHook());

        act(() => {
            result.current.consoleLogDevelper();
        });

        console.error("Error de prueba");

        expect(Toastify.toast.error).toHaveBeenCalledWith(
            "Error de prueba",
            expect.any(Object)
        );
    });

});
