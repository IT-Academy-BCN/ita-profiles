import { FC } from 'react';
import { TLanguage, TLanguageLevel } from '../../../../../../../interfaces/interfaces';
// import { useUpdateLanguageHook } from '../../../../../../../hooks/useUpdateLanguageHook';
import { useDragAndDropLanguagesHook } from '../../../../../../../hooks/useDragAndDropLanguagesHook';

export type TDragAndDropLanguagesProps = {
  dropLanguages: TLanguage[],
  deleteLanguage: (id: string) => void,
  editLanguage: (updatedLanguage: TLanguage) => void,
}

const DragAndDropLanguages: FC<TDragAndDropLanguagesProps> = ({ dropLanguages, deleteLanguage, editLanguage }) => {

  const levels: TLanguageLevel[] = ["Bàsic", "Intermedi", "Avançat", "Natiu"];

  const { updateLanguagesDrop, handleDragStart, handleDragOver, handleDrop } = useDragAndDropLanguagesHook(dropLanguages)

  return (
    <div style={{ display: "flex", flexDirection: "column", gap: "1rem" }}>
      <div>
        <div>

          {updateLanguagesDrop.map((language, index) => (
            <div
              key={language.id}
              draggable
              onDragStart={() => handleDragStart(index)}
              onDragOver={handleDragOver}
              onDrop={() => handleDrop(index)}
              className='p-2 m-[5px 0] cursor-move border-2 border-gray-900'
            >
              <div key={language.id} className="p-1 flex flex-col gap-4">
                <div className="p-1 flex items-center">
                  <div>
                    <div>{language.name}</div>
                  </div>
                  <button className="py-1 px-2 text-sm" type="button" onClick={() => deleteLanguage(language.id)}>Eliminar idioma</button>
                </div>
                <div className="p-1">
                  {levels.map((level) => (
                    <label key={`level-${level}`}>
                      <strong>{level}</strong>
                      <input
                        type="radio"
                        id={`level-${level}`}
                        name={`level-${level}`}
                        defaultValue={level}
                        checked={language.level === level}
                        onChange={() => editLanguage({ ...language, level })}
                      />
                    </label>
                  ))}
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default DragAndDropLanguages;
