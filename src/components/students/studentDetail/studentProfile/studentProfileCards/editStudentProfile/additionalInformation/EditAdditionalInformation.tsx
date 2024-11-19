import { FC, ChangeEvent, useRef } from "react"
import axios from "axios";
import { useDispatch } from "react-redux";
import { useAppDispatch, useAppSelector } from "../../../../../../../hooks/ReduxHooks"
import { useUpdateLanguageHook } from "../../../../../../../hooks/useUpdateLanguageHook";
import { resetUpdateLanguages, setLanguagesData } from "../../../../../../../store/slices/student/languagesSlice";
import { TLanguage } from "../../../../../../../interfaces/interfaces";
import EditModality from "./EditModality"
import DragAndDropLanguages from "./DragAndDropLanguages"
import useEditAdditionalInformationHook from "../../../../../../../hooks/useEditAdditionalInformationHook";
import { updateProfileLanguagesThunk } from "../../../../../../../store/thunks/updateProfileLanguagesThunk";

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
  const dispacth = useDispatch();
  const { languagesData, isOpenEditAdditionalInformation, notification, isLoadingUpdateLanguages, isErrorUpdateLanguages } = useAppSelector(state => state.ShowStudentReducer.studentLanguages)

  const { refBtnModal, handleFocusOnMouseEnter, handleCloseModalKeyDown, handleCloseModal } = useEditAdditionalInformationHook()
  const { refBtnModal, handleFocusOnMouseEnter, handleCloseModalKeyDown, handleCloseModal } = useEditAdditionalInformationHook()

  const { updateLanguages, availableLanguages, deleteLanguage, editLanguage } = useUpdateLanguageHook(languagesData)

    const { modality } = useAppSelector(
        (state) => state.ShowStudentReducer.studentAdditionalModality,
    )

    const refInput = useRef<HTMLInputElement>(null)
    const refDialog = useRef<HTMLDialogElement>(null)

  const onInputLanguage = (event: ChangeEvent<HTMLInputElement>) => {
    // TODDO: Implemetar 
    globalThis.alert(JSON.stringify({ language: event.target.value, lenguaje: event.target.id }, null, 4));
  }
  const handlerSelect = () => {
    if (refDialog.current) {
      console.log(refDialog.current.open = !refDialog.current.open)
    }
  }

  const dispatchThunk = useAppDispatch();
  const saveChanges = async () => {
    // const msg = await fetchChanges(updateLanguages)
    dispatchThunk(updateProfileLanguagesThunk(updateLanguages))
    dispacth(setLanguagesData(updateLanguages))

    setTimeout(() => {
      dispacth(resetUpdateLanguages())
      // dispacth(toggleEditAdditionalInformation())
    }, 6000)

  }

    if (isOpenEditAdditionalInformation) {
        return (
            <div className="fixed w-full h-full flex items-center justify-center top-0 left-0 bg-[rgba(0,0,0,.7)]">
                <button
                    aria-label="ref-modal"
                    type="button"
                    ref={refBtnModal}
                    onMouseEnter={handleFocusOnMouseEnter}
                    onKeyUp={handleCloseModalKeyDown}
                    onKeyDown={handleCloseModalKeyDown}
                    onClick={handleCloseModal}
                    className="fixed flex w-full h-[100vh] top-0 left-0 z-20 cursor-default"
                />

                <div className="flex flex-col  bg-white rounded-xl z-20">
                    <div className="flex justify-between mx-4 mt-4 mb-2">
                        <div />
                        <button
                            type="button"
                            onClick={handleCloseModal}
                        >
                            <img src={Close} alt="close icon" />
                        </button>
                    </div>


                    <div className='flex flex-col gap-8 pb-8'>

                        <div className="flex justify-between items-center mx-8 relative">
                            <h1 className="text-2xl my-0 font-bold text-[rgba(40,40,40,1)]">
                                Editar información adicional
                            </h1>
                            {isErrorUpdateLanguages && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
                            {isLoadingUpdateLanguages && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
                            {notification.message !== null && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification.message}</h3>}
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

        <article className="flex flex-col gap-4 justify-around p-4 max-w-[376px] bg-stone-200 select-none z-20">

          <header className="flex justify-between items-center relative">
            <h2 className="py-0 px-4">Editar información adicional </h2>
            {isErrorUpdateLanguages && <h3 className="py-0 px-4 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
            {isLoadingUpdateLanguages && <h3 className="py-0 px-4 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
            {notification !== null && <h3 className="py-0 px-4 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification.message}</h3>}
            <button className="text-red-500" onClick={handleCloseModal} type="button">X</button>
          </header>

          {/* Eliminar antes del PR */}
          {/* <section className="flex flex-col">
            <code className="flex flex-col bg-stone-500 text-white"><strong className="bg-stone-900 p-4 text-white">Lenguajes que vienen de la API</strong> <div className="flex flex-col p-4 bg-stone-900 text-yellow-500">{JSON.stringify(languagesData, null, 4)}</div></code>
            <code className="flex flex-col bg-stone-500 text-white"><strong className="bg-stone-500 p-4 text-white">Lenguajes actualizados para enviar</strong><div className="flex flex-col p-4 bg-stone-500 text-yellow-200">{JSON.stringify(updateLanguages, null, 4)}</div></code>
          </section> */}

          <header className="flex justify-between items-center relative">
            <h2 className="p-4">Idiomas</h2>
            <button className="text-red-500" type="button" onClick={handlerSelect}>X</button>
            <dialog ref={refDialog} className="absolute overflow-hidden h-72 w-full top-12 z-20 ">
              <form className="absolute flex flex-col h-60 w-full overflow-y-scroll z-11 bg-stone-200" style={{
                scrollbarWidth: "thin",
                scrollbarColor: "orange #000",
                overflow: "auto"
              }}>
                {availableLanguages.map((language, index) => (

                  <label key={language.name} htmlFor={language.es_name} data-label={index} className="w-full p-4 hover:bg-stone-400">
                    <span className="text-stone-500">{language.name}</span>
                    <input ref={refInput} data-input={index} onInput={onInputLanguage} type="radio" className="hidden" id={language.es_name} name="language" defaultValue={language.name} />
                  </label>

                ))}

              </form>
              <div className="absolute flex justify-around bottom-0 w-full z-12 bg-stone-400 p-4">
                <label htmlFor="Basic">
                  Bàsic
                  <input type="radio" name="lang" id="Basic" />
                </label>
                <label htmlFor="Intermedi">
                  Intermedi
                  <input type="radio" name="lang" id="Intermedi" />
                </label>
                <label htmlFor="Avancat">
                  Avançat
                  <input type="radio" name="lang" id="Avancat" />
                </label>
                <label htmlFor="Natiu">
                  Natiu
                  <input type="radio" name="lang" id="Natiu" />
                </label>
              </div>
            </dialog>
          </header>

          <DragAndDropLanguages
            dropLanguages={updateLanguages}
            deleteLanguage={deleteLanguage}
            editLanguage={editLanguage} />

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