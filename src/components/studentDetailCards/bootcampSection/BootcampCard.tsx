import { useEffect, useState } from 'react'
import medal from '../../../assets/img/medal-dynamic-color.png'
import { useStudentIdContext } from '../../../context/StudentIdContext'
import type { TBootcamp } from '../../../interfaces/interfaces'
import { fetchBootcampData } from '../../../api/FetchStudentBootcamp'

const BootcampCard: React.FC = () => {
  const { studentUUID } = useStudentIdContext()

  const [bootcampData, setBootcampData] = useState<TBootcamp[]>([])

  useEffect(() => {
    const fetchBootcamp = async () => {
      if (studentUUID) {
        const data = await fetchBootcampData(studentUUID)
        setBootcampData(data.bootcamps)
      }
    }
    fetchBootcamp()
  }, [studentUUID])

  return (
    <div className="flex flex-col gap-4" data-testid="BootcampCard">
      <h3 className="text-lg font-bold">Datos del bootcamp</h3>

      {bootcampData.length === 0 ? (
        <div className="flex flex-col gap-1 rounded-md bg-gray-5-background p-5 shadow-[0_4px_0_0_rgba(0,0,0,0.25)]">
          <p className="text- font-medium text-black-3">
            - Bootcamp no terminado -
          </p>
        </div>
      ) : (
        bootcampData.map((bootcamp) => (
          <div className="flex flex-col gap-1 rounded-md bg-gray-5-background p-5 shadow-[0_4px_0_0_rgba(0,0,0,0.25)]">
            <div className="flex items-center" key={bootcamp.bootcamp_id}>
              <img src={medal} alt="Medal" className="w-16 pe-1" />
              <div className="flex flex-col gap-1">
                <p className="text-base font-semibold leading-tight text-black-3">
                  {bootcamp.bootcamp_name}
                </p>
                <p className="text-sm font-medium text-black-2">
                  Finalizado: {bootcamp.bootcamp_end_date}
                </p>
              </div>
            </div>
          </div>
        ))
      )}
    </div>
  )
}
export default BootcampCard
