import { FC } from 'react'
import {
    TLanguage,
    TLanguageLevel,
} from '../../../../../../../../types'
import { useDragAndDropLanguagesHook } from '../../../../../../../hooks/useDragAndDropLanguagesHook'

export type TDragAndDropLanguagesProps = {
  dropLanguages: TLanguage[],
  deleteLanguage: (id: string) => void,
  editLanguage: (updatedLanguage: TLanguage) => void,
}

const DragAndDropLanguages: FC<TDragAndDropLanguagesProps> = ({ dropLanguages, deleteLanguage, editLanguage }) => {

  const levels: TLanguageLevel[] = ["Bàsic", "Intermedi", "Avançat", "Natiu"];

  const { updateLanguagesDrop, handleDragStart, handleDragOver, handleDrop } = useDragAndDropLanguagesHook(dropLanguages)

    return (
        <div className='flex flex-col gap-4'>
        <div className='flex flex-col gap-4'>
            {updateLanguagesDrop.map((language, index) => (
                <div
                    key={language.id}
                    draggable
                    onDragStart={() => handleDragStart(index)}
                    onDragOver={handleDragOver}
                    onDrop={() => handleDrop(index)}
                    className="cursor-move pb-4 border-b-2 border-gray-300 border-dashed">

                    <div
                        key={language.id}
                        className="flex flex-col gap-4 mx-8">

                        <div className="flex items-center">
                        <div className="flex items-center">
                            <div className='font-semibold'>
                                {language.name}
                            </div>
                            </div>
                            <button
                                className="pl-2 text-primary font-medium"
                                type="button"
                                onClick={() => deleteLanguage(language.id)}
                            >
                                Eliminar idioma
                            </button>
                        </div>
                        <div className="flex gap-4">
                            {levels.map((level) => (
                                <label key={`level-${level}`}>
                                <label key={`level-${level}`}>
                                    <input
                                        type="radio"
                                        id={`level-${level}`}
                                        name={`level-${level}`}
                                        defaultValue={level}
                                        checked={
                                            language.level === level
                                        }
                                        onChange={() =>
                                            editLanguage({
                                                ...language,
                                                level,
                                            })
                                        }
                                    />
                                    <span className='ml-2'>{level}</span>
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
