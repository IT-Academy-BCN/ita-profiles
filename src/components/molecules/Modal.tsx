import { FC } from "react"
import { Button } from "../atoms/Button";
import svgClose from "../../assets/svg/close.svg"
import { TModal } from "../../../types";

const overlayStyle = "fixed top-0 left-0 w-full h-full bg-[rgba(0, 0, 0, 0.8)] flex justify-center items-center";
const contentStyle = "bg-white p-4 rounded-md relative";

const Modal: FC<TModal> = ({ children, isOpen, onClose }) => {

  const handleKeyDown = (event: React.KeyboardEvent<HTMLDivElement>) => {
    if (event.key === 'Escape') {
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

      <div 
        role="button" 
        aria-label="modal-content" 
        tabIndex={0} 
        onKeyDown={(e) => {
          handleKeyDown(e);
          e.stopPropagation();
        }} 
        className={contentStyle} 
        onClick={(e) => e.stopPropagation()}
      >
        <Button aria-label="modal-close" defaultButton={false} close onClick={onClose}>
          <img src={svgClose} alt="Close" aria-label="close window" />
        </Button>
        {children}
      </div>

    </div>
  )
}

export default Modal