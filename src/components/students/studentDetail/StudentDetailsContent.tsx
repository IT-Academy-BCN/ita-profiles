import React from 'react'
import { Close } from '../../../assets/svg'
import ProjectsCard from './cards/ProjectsCard'
import CollaborationCard from './cards/CollaborationCard'
import BootcampCard from './cards/BootcampCard'
import ModalityCard from './cards/ModalityCard'
import StudentDetailCard from './cards/StudentDetailCard'
import LanguagesCard from './cards/LanguagesCard'
import AdditionalTrainingCard from './cards/AdditionalTrainingCard'
import { useStudentDetailHook } from '../../../hooks/useStudentDetailHook'

type TStudentDetailsContent = {
    handleIsPanelOpen: () => void
}

const StudentDetailsContent: React.FC<TStudentDetailsContent> = ({
    handleIsPanelOpen,
}) => {
    const { isMobile } = useStudentDetailHook()

    return (
        <div className={`flex flex-col gap-6 ${ isMobile ? 'modal-box rounded-2xl p-2 pb-10 pl-6' : 'h-full'}`}>
            <div className="flex items-center justify-end p-3 md:justify-between">
                <h3 className="hidden text-2xl font-bold md:block">
                    Detalle Perfil
                </h3>
                <button
                    type="button"
                    className="cursor-pointer"
                    onClick={handleIsPanelOpen}
                >
                    <img src={Close} alt="close icon" className="h-5" />
                </button>
            </div>

            <div className='overflow-y-auto'>
                <div className="flex flex-col gap-10">
                    <StudentDetailCard />
                    <ProjectsCard />
                    <CollaborationCard />
                    <BootcampCard />
                    <AdditionalTrainingCard />
                    <LanguagesCard />
                    <ModalityCard />
                </div>
            </div>
        </div>
    )
}

export default StudentDetailsContent
