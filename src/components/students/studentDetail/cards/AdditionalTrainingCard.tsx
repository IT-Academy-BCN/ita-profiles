import { useAppSelector } from '../../../../hooks/ReduxHooks'
import { TAdditionalTraining } from '../../../../../types'
import LoadingSpiner from '../../../atoms/LoadingSpiner'

const AdditionalTrainingCard = () => {
  const {
    additionalTraining,
    isLoadingAdditionalTraining,
    isErrorAdditionalTraining,
  } = useAppSelector((state) => state.ShowStudentReducer.studentAdditionalTraining)

  return (
    <div data-testid="AdditionalTrainingCard">
      <h3 className="text-lg font-bold text-black-3">Otra formación</h3>
      {isLoadingAdditionalTraining && <LoadingSpiner />}
      {isErrorAdditionalTraining && <LoadingSpiner />}
      {additionalTraining && (
        <div className="flex flex-col pt-3">
          {additionalTraining?.map(
            (training: TAdditionalTraining, index) => (
              <div key={training.id} className="flex flex-col">
                <h4 className=" font-bold">
                    {training.course_name}
                </h4>
                <div className="flex flex-col ">
                  <p className="text-sm font-semibold text-black-2">
                    {training.study_center}
                  </p>
                  <p className="text-sm font-semibold text-black-2">
                    {`${training.course_beginning_year}-${training.course_ending_year}`}{' '}
                    · {training.duration_hrs} horas
                  </p>
                  {index !== additionalTraining.length - 1 && (
                    <span className="h-px w-full bg-gray-4-base md:bg-gray-5-background my-3"/>
                  )}
                </div>
              </div>
            )
          )}
      </div>
      )}
    </div>
  )
}
export default AdditionalTrainingCard
