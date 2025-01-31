import { useAppSelector } from '../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../atoms/LoadingSpiner'

const LanguagesCard: React.FC = () => {
    const { studentLanguages } = useAppSelector((state) => state.ShowStudentReducer)
    const { languagesData, isLoadingLanguages, isErrorLanguages } = studentLanguages

    return (
        <div data-testid="LanguagesCard">
            <h3 className="text-lg font-bold mb-4">Idiomas</h3>
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

export default LanguagesCard
