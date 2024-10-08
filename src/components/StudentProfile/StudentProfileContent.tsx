import React from 'react'
import ProjectsCard from '../studentDetailCards/projectsSection/ProjectsCard'
import CollaborationCard from '../studentDetailCards/collaborationSection/CollaborationCard'
import BootcampCard from '../studentDetailCards/bootcampSection/BootcampCard'
import ModalityCard from '../studentDetailCards/modalitySection/modalityCard'
import StudentDataCard from '../studentDetailCards/studentDetailSection/StudentDetailCard'
import LanguagesCard from '../studentDetailCards/languagesSection/LanguagesCard'
import AdditionalTrainingCard from '../studentDetailCards/additionalTrainingSection/AdditionalTrainingCard'
import { useStudentDetailHook } from '../../hooks/useStudentDetailHook'

const StudentProfileContent: React.FC = () => {
  const { isMobile } = useStudentDetailHook('user')

  return (
    <div
      className={`flex flex-col gap-6 items-center xl:items-end pt-12 ${isMobile ? 'modal-box rounded-2xl pb-10 pl-6' : 'h-full w-full'}
        }`}
    >
      <div className={`overflow-auto ${isMobile ? 'w-full' : 'w-3/4'}`}>
        <div className="flex flex-col gap-9">
          <h3 className="hidden text-2xl font-bold md:block">Mi Perfil</h3>
          <StudentDataCard />
          <span className="h-0.5 w-full bg-gray-4-base" />
          <ProjectsCard />
          <span className="h-0.5 w-full bg-gray-4-base" />
          <CollaborationCard />
          <span className="h-0.5 w-full bg-gray-4-base" />
          <BootcampCard />
          <span className="h-0.5 w-full bg-gray-4-base" />
          <AdditionalTrainingCard />
          <span className="h-0.5 w-full bg-gray-4-base" />
          <LanguagesCard />
          <span className="h-0.5 w-full bg-gray-4-base" />
          <ModalityCard />
        </div>
      </div>
    </div>
  )
}

export default StudentProfileContent
