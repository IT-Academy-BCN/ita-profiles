import React, { useContext } from 'react'
import { SmallScreenContext } from '../../context/SmallScreenContext'
import type { TSmallScreenContext } from '../../interfaces/interfaces'
import ProjectsCard from '../studentDetailCards/projectsSection/ProjectsCard'
import CollaborationCard from '../studentDetailCards/collaborationSection/CollaborationCard'
import BootcampCard from '../studentDetailCards/bootcampSection/BootcampCard'
import ModalityCard from '../studentDetailCards/modalitySection/modalityCard'
import StudentDataCard from '../studentDetailCards/studentDataSection/StudentDataCard'
import LanguagesCard from '../studentDetailCards/languagesSection/LanguagesCard'
import OtherEducationCard from '../studentDetailCards/otherEducationSection/OtherEducationCard'


const StudentProfileDetail: React.FC = () => {

  const { isMobile }: TSmallScreenContext = useContext(SmallScreenContext)

  return (
    <div
      className={`flex flex-col gap-6 items-end pt-12 ${isMobile ? 'modal-box rounded-2xl p-2 pb-10 pl-6' : 'h-full'}
        }`}
    >
      <div className={`overflow-auto w-full ${isMobile ? 'pr-4' : 'pr-12'}`}>
        <div className="flex flex-col gap-9">
          <h3 className="hidden text-2xl font-bold md:block">Mi Perfil</h3>
          <StudentDataCard />
          <span className="h-0.5 w-full bg-gray-4-base"/>
          <ProjectsCard />
          <span className="h-0.5 w-full bg-gray-4-base"/>
          <CollaborationCard />
          <span className="h-0.5 w-full bg-gray-4-base"/>
          <BootcampCard />
          <span className="h-0.5 w-full bg-gray-4-base"/>
          <OtherEducationCard />
          <span className="h-0.5 w-full bg-gray-4-base"/>
          <LanguagesCard />
          <span className="h-0.5 w-full bg-gray-4-base"/>
          <ModalityCard />
        </div>
      </div>
    </div>
  )
}

export default StudentProfileDetail
