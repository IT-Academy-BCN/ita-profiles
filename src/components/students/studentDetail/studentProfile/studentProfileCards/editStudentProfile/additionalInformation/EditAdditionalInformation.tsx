import { FC } from "react"
import { useDispatch } from "react-redux"
import { useAppSelector } from "../../../../../../../hooks/ReduxHooks"
import EditLanguage from "./EditLanguages"
import EditModality from "./EditModality"
import { toggleEditAdditionalInformation } from "../../../../../../../store/slices/student/languagesSlice"

export const EditAdditionalInformation: FC = () => {

  const { languagesData, isOpenEditAdditionalInformation } = useAppSelector(state => state.ShowStudentReducer.studentLanguages)
  const { modality } = useAppSelector(state => state.ShowStudentReducer.studentAdditionalModality)
  const dispatch = useDispatch();
  return (
    isOpenEditAdditionalInformation && <section className="flex flex-col gap-4 justify-around p-4 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] w-[500px] bg-stone-200 shadow-xl">
      <header className="flex justify-between items-center">
        <h2 className="p-4">Editar información adicional</h2>
        <button onClick={() => dispatch(toggleEditAdditionalInformation())} type="button">X</button>
      </header>
      <EditLanguage studentLanguages={languagesData} />
      <EditModality additionalTraining={modality} />
      <footer className="p-1 flex justify-between">
        <button type="button" className="bg-blue-400 py-2 px-4">Cancelar</button>
        <button type="button" className="bg-red-400 py-2 px-4">Aceptar</button>
      </footer>
    </section>

  )
}