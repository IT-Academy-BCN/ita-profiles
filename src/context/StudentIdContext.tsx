import { createContext, useContext, useMemo, useState } from 'react'
import { TchildrenProps, TAbout } from '../interfaces/interfaces'

type TSelectedStudentContext = {
    // this can be null bc when the page loads, no student is selected.
    studentUUID: string | null
    setStudentUUID: (id: string | null) => void
    openEditModal: (editStudentData: TAbout) => void
    closeEditModal: () => void
    isModalOpen: boolean
    setEditStudentData: (data: TAbout) => void
    editStudentData: TAbout | null
}
// this context receives a state as argument:
// studentUUID which is the one that will store the uuid
// setStudentUUID which is the function that will get us the uuid
export const SelectedStudentIdContext = createContext<TSelectedStudentContext>({
    studentUUID: null,
    setStudentUUID: () => {},
    openEditModal: () => {},
    closeEditModal: () => {},
    isModalOpen: false,
    setEditStudentData: () => {},
    editStudentData: null,
})
// The provider ===>
export const SelectedStudentProvider = ({ children }: TchildrenProps) => {
    const [studentUUID, setStudentUUID] = useState<string | null>(null)
    const [isModalOpen, setIsModalOpen] = useState(false)
    const [editStudentData, setEditStudentData] = useState<TAbout | null>(null)

    const openEditModal = (studentData: TAbout) => {
        setEditStudentData(studentData)
        setIsModalOpen(true)
    }
    const closeEditModal = () => {
        setIsModalOpen(false)
    }

    const contextValue = useMemo(
        () => ({
            studentUUID,
            setStudentUUID,
            openEditModal,
            closeEditModal,
            setIsModalOpen,
            isModalOpen,
            setEditStudentData,
            editStudentData,
        }),
        [studentUUID, editStudentData, isModalOpen],
    )

    return (
        <SelectedStudentIdContext.Provider value={contextValue}>
            {children}
        </SelectedStudentIdContext.Provider>
    )
}

// hook to use context
export const useStudentIdContext = () => {
    const context = useContext(SelectedStudentIdContext)
    if (!context) {
        throw new Error(
            'SelectedStudentIdContext has to be used inside a SelectedStudentProvider',
        )
    }
    return context
}
