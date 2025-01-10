import { FC, ChangeEvent, useRef } from 'react'
import { useDispatch } from 'react-redux'
import { useAppDispatch, useAppSelector } from '../../../../../../../hooks/ReduxHooks'
import { useUpdateLanguageHook } from '../../../../../../../hooks/useUpdateLanguageHook'
import {
    resetUpdateLanguages,
    setLanguagesData
} from '../../../../../../../store/slices/student/languagesSlice'
import { TLanguage } from '../../../../../../../../types'
import EditModality from './EditModality'
import DragAndDropLanguages from './DragAndDropLanguages'
import useEditAdditionalInformationHook from '../../../../../../../hooks/useEditAdditionalInformationHook'
import { updateProfileLanguagesThunk } from '../../../../../../../store/thunks/updateProfileLanguagesThunk'
import { callUpdateStudent } from '../../../../../../../api/student/callUpdateStudent'
import Modal from '../../../../../../molecules/Modal'

export const fetchChanges = async (langs: TLanguage[]): Promise<string> => {
    type DataFetch = {
        name: string
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
    const { languagesData, isOpenEditAdditionalInformation, notification, isErrorUpdateLanguages, isLoadingUpdateLanguages } = useAppSelector(
        (state) => state.ShowStudentReducer.studentLanguages,
    )
    const {
        handleCloseModal,
    } = useEditAdditionalInformationHook()
    const {
        updateLanguages,
        availableLanguages,
        deleteLanguage,
        editLanguage
    } = useUpdateLanguageHook(languagesData)
    const { modality } = useAppSelector(
        (state) => state.ShowStudentReducer.studentAdditionalModality,
    )
    const refInput = useRef<HTMLInputElement>(null)
    const refDialog = useRef<HTMLDialogElement>(null)
    const onInputLanguage = (event: ChangeEvent<HTMLInputElement>) => {
        globalThis.alert(
            JSON.stringify(
                { language: event.target.value, lenguaje: event.target.id },
                null,
                4,
            ),
        )
    }
    const handlerSelect = () => {
        if (refDialog.current) {
            // console.log((refDialog.current.open = !refDialog.current.open))
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
            <Modal isOpen={isOpenEditAdditionalInformation} onClose={handleCloseModal}>
                <div className="flex justify-between items-center">
                    <h1 className="text-xl my-0 font-bold text-[rgba(40,40,40,1)]">
                        Editar información adicional
                    </h1>
                    {isErrorUpdateLanguages && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
                    {isLoadingUpdateLanguages && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification !== null && notification.message}</h3>}
                    {notification.message !== null && <h3 className="py-0 text-red-500 text-sm absolute top-full left-0 w-full h-auto animate-pulse text-[.7em]">{notification.message}</h3>}
                </div>
                <div className="flex justify-between items-center py-4">
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
                        className="top-32 left-0 z-20 h-80 w-full bg-stone-50 rounded-xl overflow-hidden">
                        <form className="flex flex-col h-full overflow-y-auto z-11 p-2">
                            {availableLanguages.map((language, index) => (
                                <label
                                    key={language.name}
                                    htmlFor={language.es_name}
                                    data-label={index}
                                    className="w-full p-4 hover:font-semibold text-gray-900 border-b-2 border-gray-100">
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
                <EditModality additionalTraining={modality} />
                <div className="flex gap-4 justify-between">
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
            </Modal>
        )
    }

    return null
}