import { RefObject, useCallback, useEffect } from 'react'

export const useCloseWhenClickOutside = (
    modalRef: RefObject<HTMLElement>,
    handleModal: () => void,
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

    useEffect(() => {
        document.addEventListener('mousedown', handleClickOutside)
        return () => {
            document.removeEventListener('mousedown', handleClickOutside)
        }
    }, [handleModal, handleClickOutside])
    
}
