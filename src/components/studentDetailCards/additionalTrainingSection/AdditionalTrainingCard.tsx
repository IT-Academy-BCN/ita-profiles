import { useEffect, useState } from 'react'
import { useStudentIdContext } from '../../../context/StudentIdContext'
import { TAdditionalTraining } from '../../../interfaces/interfaces'
import { FetchAdditionalTraining } from '../../../api/FetchAdditionalTraining'

const AdditionalTrainingCard = () => {
  const { studentUUID } = useStudentIdContext()
  const [additionalTraining, setAdditionalTraining] = useState<TAdditionalTraining[] | null>()

  useEffect(() => {
    const getStudentTraining = async () => {
      try {
        const studentTraining = await FetchAdditionalTraining(studentUUID)
        setAdditionalTraining(studentTraining)
      } catch (error) {
        // eslint-disable-next-line no-console
        console.log(error)
      }
    }
    if (studentUUID) {
      getStudentTraining()
    }
  }, [studentUUID])

  return (
    <div data-testid="AdditionalTrainingCard">
      <h3 className="text-lg font-bold text-black-3">Otra formación</h3>
      <div className="flex flex-col pt-3">
        {additionalTraining?.map((training, index) => (
          <div key={training.uuid} className="flex flex-col ">
            <h4 className=" font-bold">{training.course_name}</h4>
            <div className="flex flex-col ">
              <p className="text-sm font-semibold text-black-2">
                {training.study_center}
              </p>
              <p className="text-sm font-semibold text-black-2">
                {`${training.course_beginning_year}-${training.course_ending_year}`}{' '}
                · {training.duration_hrs} horas
              </p>
              {index !== additionalTraining.length - 1 && (
                <span className="h-px w-full bg-gray-4-base md:bg-gray-5-background my-3" />
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  )
}
export default AdditionalTrainingCard
