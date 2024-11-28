import * as Toastify from "react-toastify";
import { renderHook, act } from "@testing-library/react";
import { OPTIONS } from "../../../hooks/notifications/notification.config";
import { useNotificationsHook } from "../../../hooks/notifications/useNotificationHook";

vi.mock("react-toastify", async () => {
  const actual = await vi.importActual<typeof Toastify>("react-toastify");
  return {
    ...actual,
    toast: {
      info: vi.fn(),
    },
  };
});

describe("useNotificationsHook", () => {

  it("should call toast.info with the correct message and options", () => {
    const { result } = renderHook(() => useNotificationsHook());
    const testMessage = "Este es un mensaje de prueba";

    act(() => {
      result.current.showNotification(testMessage);
    });

    expect(Toastify.toast.info).toHaveBeenCalledWith(
      testMessage,
      expect.objectContaining(OPTIONS)
    );
  });

});
