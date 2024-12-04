import { FC, ReactNode } from "react"

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
      className="fixed top-0 left-0 w-full h-full bg-[rgba(0, 0, 0, 0.8)] flex justify-center items-center">

      <div role="button" aria-label="modal-content" tabIndex={0} onKeyDown={(e) => {
        handleKeyDown(e);
        e.stopPropagation();
      }} className="bg-white p-4 rounded-md relative" onClick={(e) => e.stopPropagation()}>
        <button type="button" aria-label="modal-close" className="absolute top-3 right-3 bg-none border-none text-xl cursor-pointer" onClick={onClose}>&times;</button>
        {children}
      </div>

    </div>
  )
}

export default Modal