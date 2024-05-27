import axios from 'axios'
import { useEffect, useState } from 'react'
import { useStudentIdContext } from '../../../context/StudentIdContext'
import type { TLanguage } from '../../../interfaces/interfaces'

const LanguagesCard: React.FC = () => {
  const { studentUUID } = useStudentIdContext()
  const [languages, setLanguages] = useState<TLanguage[]>([])
  const [error, setError] = useState('')

  const endpointLanguages = `/api/v1/students/${studentUUID}/languages`

  useEffect(() => {
    if (studentUUID) {
      axios
        .get(endpointLanguages, {
          headers: {
            'Content-Type': 'application/json',
          },
        })
        .then((response) => {
          setLanguages(response.data.languages)
        })
        .catch((err) => {
          setError(err.message)
        })
    }
  }, [studentUUID, endpointLanguages])

  if (error) {
    return <p>{error}</p>
  }
  return (
    <div className="flex flex-col gap-2" data-testid="LanguagesCard">
      <h3 className="text-lg font-bold">Idiomas</h3>
      <div className="flex flex-col gap-1">
        {languages &&
          languages.map((language) => (
            <ul key={language.language_id} className="flex flex-col">
              <li className="text-sm font-semibold text-black-2">
                {language.language_name}
              </li>
            </ul>
          ))}
      </div>
    </div>
  )
}

export default LanguagesCard
