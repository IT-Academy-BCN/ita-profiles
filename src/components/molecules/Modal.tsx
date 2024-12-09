import { FC, ReactNode } from "react"
import { Button } from "../atoms/Button";

type TModal = {
  isOpen: boolean,
  onClose: () => void,
  children: ReactNode
}

const overlayStyle = "fixed top-0 left-0 w-full h-full bg-[rgba(0, 0, 0, 0.8)] flex justify-center items-center";
const contentStyle = "bg-white p-4 rounded-md relative";
const buttonStyle = "absolute top-3 right-3 bg-none border-none text-xl cursor-pointer"

const Modal: FC<TModal> = ({ children, isOpen, onClose }) => {

  const handleKeyDown = (event: React.KeyboardEvent<HTMLDivElement>) => {
    if (event.key === 'Escape' || event.key === ' ') {
      event.preventDefault();
      onClose();
    }
  };

  if (!isOpen) return null;

  return (
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
        <Button type="button" aria-label="modal-close" className={buttonStyle} onClick={onClose}>&times;</Button>
        {children}
      </div>

    </div>
  )
}

export default Modal