import { FC } from 'react';
import { TDragAndDropLanguagesProps, TLanguageLevel } from '../../../../../../../interfaces/interfaces';
import { useUpdateLanguageHook } from '../../../../../../../hooks/useUpdateLanguageHook';
import { useDragAndDropLanguagesHook } from '../../../../../../../hooks/useDragAndDropLanguagesHook';


const DragAndDropLanguages: FC<TDragAndDropLanguagesProps> = ({ dropLanguages }) => {

  const levels: TLanguageLevel[] = ["Bàsic", "Intermedi", "Avançat", "Natiu"];
  const { languages, deleteLanguage, editLanguage } = useUpdateLanguageHook(dropLanguages)
  const { handleDragStart, handleDragOver, handleDrop } = useDragAndDropLanguagesHook(languages)

  return (
    <div style={{ display: "flex", flexDirection: "column", gap: "1rem" }}>
      <div>
        <div>
          {languages.map((language, index) => (
            <div
              key={language.id}
              draggable
              onDragStart={() => handleDragStart(index)}
              onDragOver={handleDragOver}
              onDrop={() => handleDrop(index)}
              className='p-2 m-[5px 0] cursor-move border-2 border-gray-900'
            >
              <div key={language.id} className="p-1 flex flex-col gap-4">
                <div className="p-1 flex flex-col gap-4">
                  <div className="p-1 flex flex-col gap-4">
                    <div>{language.name}</div>
                    <div>{language.level}</div>
                    <button className="bg-red-400 py-2 px-4" type="button" onClick={() => deleteLanguage(language.id)}>Eliminar idioma</button>
                  </div>

                </div>
                <div className="p-1 flex justify-around">
                  {levels.map((level, lindex) => (
                    <label id={`level-${language.id}-${lindex}`} key={`level-${language.id}-${level}`}>
                      <strong>{level}</strong>
                      <input
                        type="radio"
                        id={`level-${language.id}`}
                        name={`level-${language.id}`}
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
      </div >
    </div >
  );
};

export default DragAndDropLanguages;
