import React from 'react'
import { useAppSelector } from '../../../../../hooks/ReduxHooks'

export const EditStudentProjects = () => {
    const { projectsData, editProjectModalIsOpen } = useAppSelector(
        (state) => state.ShowStudentReducer.studentProjects,
    )

    return editProjectModalIsOpen && projectsData ? (
        <div className="fixed inset-0 flex justify-center items-center bg-[rgba(0,0,0,0.5)] z-10">
            <div className="bg-slate-100 rounded-2xl p-4">
                <h1>Hola</h1>
            </div>
        </div>
    ) : null
}
