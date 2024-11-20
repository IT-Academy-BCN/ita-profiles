import { FC, ChangeEvent, useRef } from 'react'
import { useDispatch } from 'react-redux'
import { useAppDispatch, useAppSelector } from '../../../../../../../hooks/ReduxHooks'
import { useUpdateLanguageHook } from '../../../../../../../hooks/useUpdateLanguageHook'
import {
    resetUpdateLanguages,
    setLanguagesData
} from '../../../../../../../store/slices/student/languagesSlice'
import { TLanguage } from '../../../../../../../interfaces/interfaces'
import EditModality from './EditModality'
import DragAndDropLanguages from './DragAndDropLanguages'
import useEditAdditionalInformationHook from '../../../../../../../hooks/useEditAdditionalInformationHook'
import { Close } from '../../../../../../../assets/svg'
import { updateProfileLanguagesThunk } from '../../../../../../../store/thunks/updateProfileLanguagesThunk'
import { callUpdateStudent } from '../../../../../../../api/student/callUpdateStudent'


export const fetchChanges = async (langs: TLanguage[]): Promise<string> => {

  type DataFetch = {
    name: string,
    level: string
  }

  type DataFetch = {
    name: string,
    level: string
  }

    const data: DataFetch = {
        name: langs[0].name,
        level: langs[0].level,
    }
    const peticion = {
        url: `http://127.0.0.1:8000/api/v1/student/${localStorage.getItem(
                'studentID',
            )}/resume/languages`,
        formData: data
    }

    const query = await callUpdateStudent(peticion)
    return query
}

export const EditAdditionalInformation: FC = () => {
    const dispacth = useDispatch()
    const dispatchThunk = useAppDispatch()
    const { languagesData, isOpenEditAdditionalInformation, notification, isErrorUpdateLanguages, isLoadingUpdateLanguages} = useAppSelector(
        (state) => state.ShowStudentReducer.studentLanguages,
    )

  const { refBtnModal, handleFocusOnMouseEnter, handleCloseModalKeyDown, handleCloseModal } = useEditAdditionalInformationHook()
  const { refBtnModal, handleFocusOnMouseEnter, handleCloseModalKeyDown, handleCloseModal } = useEditAdditionalInformationHook()

    const {
        updateLanguages,
        availableLanguages,
        deleteLanguage,
        editLanguage,
        
    } = useUpdateLanguageHook(languagesData)

  // TODDO: Refactor
  const { modality } = useAppSelector(state => state.ShowStudentReducer.studentAdditionalModality)

  const refInput = useRef<HTMLInputElement>(null);
  // const [selectOptionValue, setSelectOptionValue] = useState<string>();
  const refDialog = useRef<HTMLDialogElement>(null);


  const onInputLanguage = (event: ChangeEvent<HTMLInputElement>) => {
    // TODDO: Implemetar 
    globalThis.alert(JSON.stringify({ language: event.target.value, lenguaje: event.target.id }, null, 4));
  }
  const handlerSelect = () => {
    if (refDialog.current) {
      console.log(refDialog.current.open = !refDialog.current.open)
    }
  }

    const saveChanges = async () => {

        dispatchThunk(updateProfileLanguagesThunk(updateLanguages))
        dispacth(setLanguagesData(updateLanguages))

        setTimeout(() => {
            dispacth(resetUpdateLanguages())
         
          }, 6000)
    }

  if (isOpenEditAdditionalInformation) {
    return (

      <section className="fixed w-full h-full flex items-center justify-center top-0 left-0 bg-[rgba(0,0,0,.7)]">

        <button aria-label="ref-modal"
          type="button"
          ref={refBtnModal}
          onMouseEnter={handleFocusOnMouseEnter}
          onKeyUp={handleCloseModalKeyDown}
          onKeyDown={handleCloseModalKeyDown}
          onClick={handleCloseModal}
          className="fixed flex w-full h-[100vh] top-0 left-0 z-20 cursor-default" >
          <strong className="text-red-500 absolute top-28 right-28 z-20">X</strong>
        </button>

        <article className="flex flex-col gap-4 justify-around p-4 max-w-[376px] bg-stone-200 select-none z-20">

                        <div className="flex justify-between items-center mx-8 relative">
                            <h1 className="text-2xl my-0 font-bold text-[rgba(40,40,40,1)]">
                                Editar información adicional
                            </h1>
                            {isErrorUpdateLanguages && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
                            {isLoadingUpdateLanguages && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
                            {notification.message !== null  && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification.message}</h3>}
                        </div>
                        
                        <div>
                            <div className="flex justify-between items-center mx-8 relative">
                                <h2 className="font-bold">
                                    Idiomas
                                </h2>

                                <button
                                    className="font-semibold text-xl"
                                    type="button"
                                    onClick={handlerSelect}
                                >
                                    +
                                </button>
                                
                                <dialog
                                    ref={refDialog}
                                    className="top-8 left-40 z-20 h-80 w-2/3 bg-stone-200 rounded-xl overflow-hidden">
                                        
                                    <form className="flex flex-col h-full overflow-y-auto z-11 p-2">
                                        {availableLanguages.map((language, index) => (
                                            <label
                                                key={language.name}
                                                htmlFor={language.es_name}
                                                data-label={index}
                                                className="w-full p-4 hover:font-semibold text-gray-900">
                                                <span>
                                                    {language.name}
                                                </span>
                                                <input
                                                    ref={refInput}
                                                    data-input={index}
                                                    onInput={onInputLanguage}
                                                    type="radio"
                                                    className="hidden"
                                                    id={language.es_name}
                                                    name="language"
                                                    defaultValue={language.name}
                                                />
                                            </label>
                                        ))}
                                    </form>

                                    <div className="absolute flex justify-around bottom-0 w-full z-12 bg-white p-4">
                                        <label htmlFor="Basic">
                                            Bàsic
                                            <input
                                                type="radio"
                                                name="lang"
                                                id="Basic"
                                            />
                                        </label>
                                        <label htmlFor="Intermedi">
                                            Intermedi
                                            <input
                                                type="radio"
                                                name="lang"
                                                id="Intermedi"
                                            />
                                        </label>
                                        <label htmlFor="Avancat">
                                            Avançat
                                            <input
                                                type="radio"
                                                name="lang"
                                                id="Avancat"
                                            />
                                        </label>
                                        <label htmlFor="Natiu">
                                            Natiu
                                            <input
                                                type="radio"
                                                name="lang"
                                                id="Natiu"
                                            />
                                        </label>
                                    </div>
                                </dialog>                                
                            </div>
                            <div className='my-4 border-b-2 border-gray-300 border-dashed'>
                                        <span className="hidden">border-dashed</span>
                            </div>
                            <DragAndDropLanguages
                                dropLanguages={updateLanguages}
                                deleteLanguage={deleteLanguage}
                                editLanguage={editLanguage}
                            />
                        </div>

                        <div className='mx-8'>
                            <EditModality additionalTraining={modality} />
                        </div>

                        <div className="flex gap-4 justify-between mx-8">
                            <button
                                type="button"
                                className="flex-1 h-[63px] rounded-xl font-bold border border-[rgba(128,128,128,1)] text-[rgba(128,128,128,1)]"
                                onClick={handleCloseModal}>
                                Cancelar
                            </button>
                            <button
                                type="button"
                                onClick={saveChanges}
                                className="flex-1 h-[63px] rounded-xl bg-primary font-bold text-white"
                            >
                                Aceptar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        )
    }

  return null
}