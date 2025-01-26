import { FC } from "react"
import { createPortal } from "react-dom";
import { Button } from "../atoms/Button";
import svgClose from "../../assets/svg/close.svg"
import { TModal } from "../../../types";

const overlayStyle = "fixed top-0 left-0 w-full h-full bg-[rgba(0,0,0,.5)] flex justify-center items-center";
const contentStyle = "bg-white p-4 rounded-xl relative";
const buttonStyle = "absolute top-3 right-3 bg-none border-none text-xl cursor-pointer"

const Modal: FC<TModal> = ({ children, isOpen, onClose }) => {

  const handleKeyDown = (event: React.KeyboardEvent<HTMLDivElement>) => {
    if (event.key === 'Escape') {
      event.preventDefault();
      onClose();
    }
  };

  if (!isOpen) return null;

  return (
    createPortal(
      <div
        role="button"
        onClick={onClose}
        aria-label="modal-overlay"
        tabIndex={0}
        onKeyDown={handleKeyDown}
        className={overlayStyle}>

        <div role="button" aria-label="modal-content" tabIndex={0} onKeyDown={(e) => {
          handleKeyDown(e);
          e.stopPropagation();
        }} className={contentStyle} onClick={(e) => e.stopPropagation()}>
          <Button type="button" aria-label="modal-close" className={buttonStyle} onClick={onClose}>
            <img src={svgClose} alt="Close" width={21} height={19} aria-label="close modal" />
          </Button>
          {children}
        </div>

      </div>,
      document.body
    )
  )
}

export default Modal