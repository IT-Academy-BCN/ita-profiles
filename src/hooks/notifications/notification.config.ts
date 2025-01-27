import { Bounce } from "react-toastify";
import { DefaultOptions } from "./notification.types";

export const OPTIONS: DefaultOptions = {
  position: "top-center",
  autoClose: false,
  hideProgressBar: false,
  closeOnClick: true,
  pauseOnHover: true,
  draggable: false,
  progress: undefined,
  theme: "light",
  transition: Bounce,
}

export const defaultOption = (payload: Partial<DefaultOptions> | string): DefaultOptions => {

  if (typeof payload === "undefined") {
    throw new Error("Se espera un objeto válido")
  }

  if (typeof payload === "object") {
    return {
      ...OPTIONS,
      ...payload
    }
  }

  if (typeof payload === "string" && payload !== "default") {
    throw new Error("Se esperaba un objeto o un string, de opciones válido")
  }

  return {
    ...OPTIONS,
  }

}
