import { RefObject, useCallback, useEffect } from 'react'

export const useCloseWhenClickOutside = (
    modalRef: RefObject<HTMLElement>,
    handleModal: () => void,
    isModalOpen: boolean,
) => {
    const handleClickOutside = useCallback(
        (event: MouseEvent) => {
            if (
                modalRef.current &&
                event.target instanceof Node &&
                !modalRef.current.contains(event.target)
            ) {
                handleModal()
            }
        },
        [handleModal, modalRef],
    )

    const handleKeyDown = useCallback(
        (event: KeyboardEvent) => {
            if (event.key === 'Escape' && isModalOpen) {
                handleModal()
            }
        },
        [handleModal, isModalOpen],
    )
    useEffect(() => {
        if (isModalOpen) {
            document.addEventListener('mousedown', handleClickOutside)
            document.addEventListener('keydown', handleKeyDown)

            return () => {
                document.removeEventListener('mousedown', handleClickOutside)
                document.removeEventListener('keydown', handleKeyDown)
            }
        }
    }, [isModalOpen, handleClickOutside, handleKeyDown])
}
