import { FC, ReactNode } from "react"
import styleModal from "./css/modal.module.css";

type TModal = {
  isOpen: boolean,
  onClose: () => void,
  children: ReactNode
}

const Modal: FC<TModal> = ({ children, isOpen, onClose }) => {
  if (!isOpen) return null;
  return (
    <section role="dialog" onClick={onClose} className={styleModal.overlay}>
      <article className={styleModal.content} onClick={(e) => e.stopPropagation()}>
        <button className={styleModal.close} onClick={onClose}>&times;</button>
        {children}
      </article>
    </section>
  )
}

export default Modal