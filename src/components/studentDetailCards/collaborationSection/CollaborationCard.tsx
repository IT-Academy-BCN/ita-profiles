import { useEffect, useState } from 'react'
import { useStudentIdContext } from '../../../context/StudentIdContext'
import { TCollaboration } from '../../../interfaces/interfaces'
import { FetchStudentsCollaboration } from '../../../api/FetchStudentCollaboration'
import target from '../../../assets/img/target.png'
import folder from '../../../assets/img/folder.png'

const CollaborationCard: React.FC = () => {
  const { studentUUID } = useStudentIdContext()
  const [collaborationData, setCollaborationData] = useState<TCollaboration[]>()

  useEffect(() => {
    const fetchCollaboration = async () => {
      if (studentUUID) {
        const data = await FetchStudentsCollaboration(studentUUID)
        setCollaborationData(data)
      }
    }    
    fetchCollaboration()
  }, [studentUUID])

  return (
    <div className="flex flex-col gap-4" data-testid="CollaborationCard">
    <h3 className="text-lg font-bold text-black-3">Colaboración</h3>
    <div className="flex flex-col gap-4 md:flex-row">

      {/* <ResourcesCard /> */}
      <div className="flex w-2/3 md:w-1/2 items-start justify-between rounded-md bg-ita-wiki p-3 pl-7 pt-3">
        <div className="flex flex-col">
          {collaborationData === undefined ? (
            <p className="py-2 text-l text-white">-loading-</p>
          ):(
            <p className="text-2xl text-white">{collaborationData[0].collaboration_quantity}</p>
          )}          
          <p className="text-md text-white">Recursos subidos</p>
          <p className="mt-2 text-sm font-light text-white">ita-wiki</p>
        </div>
        <div className="w-9 -mt-1">
          <img src={folder} alt="folder" className="h-full" />
        </div>
      </div>

      {/* <ChallengesCard /> */}
      <div className="flex w-2/3 md:w-1/2 items-start justify-between rounded-md bg-ita-challenges p-3 pl-7 pt-3">
        <div className="flex flex-col ">
        {collaborationData === undefined ? (
            <p className="py-2 text-l text-white">-loading-</p>
          ):(
            <p className="text-2xl text-white">{collaborationData[1].collaboration_quantity}</p>
          )}     
          <p className="text-md text-white">Retos completados</p>
          <p className="mt-2 text-sm font-light text-white">ita-challenges</p>
        </div>
        <div className="w-10 -mt-2">
          <img src={target} alt="folder" className="w-full" />
        </div>
      </div>

    </div>
  </div>
  )
  
}

export default CollaborationCard
