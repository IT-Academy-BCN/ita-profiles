import { useState } from 'react'
import type { TLanguage } from '../../../interfaces/interfaces'
import { useAppSelector } from '../../../hooks/ReduxHooks'
import LoadingSpiner from '../../atoms/LoadingSpiner'

const LanguagesCard: React.FC = () => {
  const { studentLanguages } = useAppSelector(state => state.ShowStudentReducer)
  const { languagesData, isLoadingLanguages, isErrorLanguages } = studentLanguages

  console.log('languagesData:', languagesData);


  return (
    <div data-testid="LanguagesCard">
      <h3 className="text-lg font-bold">Idiomas</h3>
      {isLoadingLanguages && <LoadingSpiner />}
      {!isLoadingLanguages && 
        <div className="flex flex-col gap-2">          
          <div className="flex flex-col gap-1">
            {languagesData.map((language) => (
                <ul key={language.language_id} className="flex flex-col">
                  <li className="text-sm font-semibold text-black-2">
                    {language.language_name}
                  </li>
                </ul>
              ))}
          </div>
        </div>}
    </div>
  )
}

export default LanguagesCard
