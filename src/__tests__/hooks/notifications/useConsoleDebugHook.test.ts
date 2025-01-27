import { renderHook, act } from "@testing-library/react";
import * as Toastify from "react-toastify";
import { useConsoleDebugHook } from "../../../hooks/notifications/useConsoleDebugHook";

vi.mock("react-toastify", async () => {
  const actual = await vi.importActual<typeof Toastify>("react-toastify");
  return {
    ...actual,
    toast: {
      info: vi.fn(),
      warning: vi.fn(),
    },
  };
});

describe("useConsoleDebugHook", () => {
  it("I should call toast.info with a text message", () => {
    const { result } = renderHook(() => useConsoleDebugHook());

    const testMessage = "Mensaje de información";

    act(() => {
      result.current.consoleLogDebug(testMessage);
    });

    expect(Toastify.toast.info).toHaveBeenCalledWith(
      testMessage,
      expect.any(Object)
    );
  });

  it("should call toast.info with an object message", () => {
    const { result } = renderHook(() => useConsoleDebugHook());

    const testMessage = { key: "value" };

    act(() => {
      result.current.consoleLogDebug(testMessage);
    });

    expect(Toastify.toast.info).toHaveBeenCalledWith(
      JSON.stringify(testMessage),
      expect.any(Object)
    );
  });

  it("should call toast.warning with a text message", () => {
    const { result } = renderHook(() => useConsoleDebugHook());

    const testMessage = "Mensaje de advertencia";

    act(() => {
      result.current.consoleErrorDebug(testMessage);
    });

    expect(Toastify.toast.warning).toHaveBeenCalledWith(
      testMessage,
      expect.any(Object)
    );
  });

  it("should call toast.warning with an object message", () => {
    const { result } = renderHook(() => useConsoleDebugHook());

    const testMessage = { error: "algo salió mal" };

    act(() => {
      result.current.consoleErrorDebug(testMessage);
    });

    expect(Toastify.toast.warning).toHaveBeenCalledWith(
      JSON.stringify(testMessage),
      expect.any(Object)
    );
  });

});
