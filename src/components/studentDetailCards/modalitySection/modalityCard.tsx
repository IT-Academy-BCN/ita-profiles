import { useEffect, useState } from 'react'
import { v4 as uuidv4 } from 'uuid'
import remoto from '../../../assets/svg/remoto.svg'
import { useStudentIdContext } from '../../../context/StudentIdContext'
import type { TModality } from '../../../interfaces/interfaces'
import { fetchModalityData } from '../../../api/FetchStudentModality'

const ModalityCard: React.FC = () => {
  const { studentUUID } = useStudentIdContext()
  const [modalityData, setModalityData] = useState<TModality>({ modality: [] })

  useEffect(() => {
    const fetchModality = async () => {
      if (studentUUID) {
        const data = await fetchModalityData(studentUUID)
        setModalityData(data)
      }
    }

    fetchModality()
  }, [studentUUID])

  return (
    <div className="flex flex-col gap-3" data-testid="ModalityCard">
      <h3 className="font-bold text-lg">Modalidad</h3>
      <div className="flex-col items-center ">
        {modalityData.modality.map((modality) => (
          <div key={uuidv4()} className="flex gap-3 py-1">
            <img src={remoto} className="pr-2" alt="remoto" />
            <p className="text-sm font-semibold text-black-2">{modality}</p>
          </div>
        ))}
      </div>
    </div>
  )
}

export default ModalityCard
