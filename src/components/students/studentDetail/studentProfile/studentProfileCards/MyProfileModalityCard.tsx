import { v4 as uuidv4 } from 'uuid'
import { useDispatch } from 'react-redux'
import remoto from '../../../../../assets/svg/remoto.svg'
import { useAppSelector } from '../../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../../atoms/LoadingSpiner'
import { toggleEditAdditionalInformation } from '../../../../../store/slices/student/languagesSlice'

const MyProfileModalityCard: React.FC = () => {
    const {
        modality: modalityData,
        isLoadingModality,
        isErrorModality,
    } = useAppSelector((state) => state.ShowStudentReducer.studentAdditionalModality)

    const dispatch = useDispatch();

    return (
        <div className="flex flex-col gap-3" data-testid="ModalityCard">
            <div className='flex'>
                <h3 className="font-bold text-lg">Modalidad</h3>
                <button
                    type='button'
                    className='ml-auto'
                    onClick={() => dispatch(toggleEditAdditionalInformation())}
                >
                    <img src={Pencil} alt="edit modality information" />
                </button>
            </div>
            {isLoadingModality && <LoadingSpiner />}
            {isErrorModality && (
                <LoadingSpiner
                    textContent="Upss!!"
                    type="loading-bars"
                    textColor="red"
                />
            )}
            {!isLoadingModality && (
                <div className="flex-col items-center ">
                    {modalityData.map((modality) => (
                        <div key={uuidv4()} className="flex gap-3 py-1">
                            <img src={remoto} className="pr-2" alt="remoto" />
                            <p className="text-sm font-semibold text-black-2">
                                {modality.toString()}
                            </p>
                        </div>
                    ))}
                </div>
            )}
        </div>
    )
}

export default MyProfileModalityCard
