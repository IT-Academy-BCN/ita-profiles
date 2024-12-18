import { useDispatch } from 'react-redux'
import { Pencil } from '../../../../../assets/svg'
import { useAppSelector } from '../../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../../atoms/LoadingSpiner'
import { EditAdditionalInformation } from './editStudentProfile/additionalInformation/EditAdditionalInformation'
import { toggleEditAdditionalInformation } from '../../../../../store/slices/student/languagesSlice'
import { ModalPortals } from '../../../../ModalPortals'
import { Button } from '../../../../atoms/Button'

const MyProfileLanguagesCard: React.FC = () => {
    const { studentLanguages } = useAppSelector((state) => state.ShowStudentReducer)
    const { languagesData, isLoadingLanguages, isErrorLanguages } = studentLanguages
    const dispatch = useDispatch()
    return (
        <div data-testid="LanguagesCard">
            <div className='flex mb-4'>
                <h3 className="text-lg font-bold">Idiomas</h3>
                <Button
                    defaultButton={false}
                    className='ml-auto'
                    onClick={() => dispatch(toggleEditAdditionalInformation())}
                >
                    <img src={Pencil} alt="edit languages information" />
                </Button>
            </div>
            {isLoadingLanguages && <LoadingSpiner />}
            {isErrorLanguages && (
                <LoadingSpiner
                    textContent="Upss!!"
                    type="loading-bars"
                    textColor="red"
                />
            )}
            {!isLoadingLanguages && (
                <div className="flex flex-col gap-2">
                    <ModalPortals>
                        <EditAdditionalInformation />
                    </ModalPortals>
                    <div className="flex flex-col gap-1">
                        {languagesData.map((language) => (
                            <ul
                                key={language.id}
                                className="flex flex-col"
                            >
                                <li className="text-sm font-semibold text-black-2">
                                    {language.name} - {language.level}
                                </li>
                            </ul>
                        ))}
                    </div>
                </div>
            )}
        </div>
    )
}

export default MyProfileLanguagesCard
