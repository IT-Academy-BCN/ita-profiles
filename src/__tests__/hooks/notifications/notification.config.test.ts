import { describe, it, expect } from "vitest";
import { defaultOption, OPTIONS } from "../../../hooks/notifications/notification.config";
import { DefaultOptions } from "../../../hooks/notifications/notification.types";

describe("defaultOption", () => {
  it("should return the default options when it receives the string 'default'", () => {
    const result = defaultOption("default");
    expect(result).toEqual(OPTIONS);
  });

  it("You must combine the default options with a valid options object", () => {
    const payload: Partial<DefaultOptions> = {
      autoClose: 5000,
      theme: "dark",
    };
    const result = defaultOption(payload);
    expect(result).toEqual({
      ...OPTIONS,
      autoClose: 5000,
      theme: "dark",
    });
  });

  it("should throw an error if the payload is undefined", () => {

    expect(() => defaultOption(undefined as never)).toThrow("Se espera un objeto válido");
  });

  it("should throw an error if the payload is a string other than 'default'", () => {
    expect(() => defaultOption("invalidString")).toThrow(
      "Se esperaba un objeto o un string, de opciones válido"
    );
  });

  it("should return default options if payload is an empty object", () => {
    const result = defaultOption({});
    expect(result).toEqual(OPTIONS);
  });

  it("must correctly handle invalid values ​​in the payload object", () => {
    const payload = { position: undefined } as Partial<DefaultOptions>;
    const result = defaultOption(payload);
    expect(result).toEqual({
      ...OPTIONS,
      position: undefined,
    });
  });

  it("must not modify the original OPTIONS object", () => {
    const payload: Partial<DefaultOptions> = { autoClose: 3000 };
    const result = defaultOption(payload);
    expect(result).not.toBe(OPTIONS);
    expect(OPTIONS.autoClose).toBe(false);
  });
});
