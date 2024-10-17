import React from 'react'
import MyProfileStudentDetailCard from './studentProfileCards/MyProfileStudentDetailCard'
import MyProfileProjectsCard from './studentProfileCards/MyProfileProjectsCard'
import MyProfileCollaborationCard from './studentProfileCards/MyProfileCollaborationCard'
import MyProfileBootcampCard from './studentProfileCards/MyProfileBootcampCard'
import AdditionalTrainingCard from '../cards/AdditionalTrainingCard'
import MyProfileLanguagesCard from './studentProfileCards/MyProfileLanguagesCard'
import MyProfileModalityCard from './studentProfileCards/MyProfileModalityCard'
import { useStudentDetailHook } from '../../../../hooks/useStudentDetailHook'

const StudentProfileContent: React.FC = () => {
    const { isMobile } = useStudentDetailHook('user')

    return (
        <div
            className={`flex flex-col gap-6 items-center xl:items-end pt-12 ${
                isMobile ? 'modal-box rounded-2xl pb-10 pl-6' : 'h-full w-full'
            }
        }`}
        >
            <div className={`overflow-auto ${isMobile ? 'w-full' : 'w-3/4'}`}>
                <div className="flex flex-col gap-9">
                    <h3 className="hidden text-2xl font-bold md:block">
                        Mi Perfil
                    </h3>
                    {<MyProfileStudentDetailCard />}
                    <span className="h-0.5 w-full bg-gray-4-base" />
                    <MyProfileProjectsCard />
                    <span className="h-0.5 w-full bg-gray-4-base" />
                    <MyProfileCollaborationCard />
                    <span className="h-0.5 w-full bg-gray-4-base" />
                    <MyProfileBootcampCard />
                    <AdditionalTrainingCard />
                    <span className="h-0.5 w-full bg-gray-4-base" />
                    <MyProfileLanguagesCard />
                    <span className="h-0.5 w-full bg-gray-4-base" />
                    <MyProfileModalityCard />
                </div>
            </div>
        </div>
    )
}

export default StudentProfileContent
