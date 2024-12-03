import { FC, ReactNode } from "react"
import styleModal from "./css/modal.module.css";

type TModal = {
  isOpen: boolean,
  onClose: () => void,
  children: ReactNode
}

const Modal: FC<TModal> = ({ children, isOpen, onClose }) => {

  const handleKeyDown = (event: React.KeyboardEvent<HTMLDivElement>) => {
    if (event.key === 'Enter' || event.key === ' ') {
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
      className={styleModal.overlay}>

      <div role="button" aria-label="modal-content" tabIndex={0} onKeyDown={(e) => {
        handleKeyDown(e);
        e.stopPropagation();
      }} className={styleModal.content} onClick={(e) => e.stopPropagation()}>
        <button type="button" aria-label="modal-close" className={styleModal.close} onClick={onClose}>&times;</button>
        {children}
      </div>

    </div>
  )
}

export default Modal