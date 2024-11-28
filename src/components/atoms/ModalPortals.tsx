import { ReactNode } from 'react'
import { createPortal } from 'react-dom'

export const ModalPortals = ({ children }: { children: ReactNode }) => {
    return createPortal(children, document.body)
}
