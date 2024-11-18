import { ChangeEvent, FC, useRef } from "react";
import { TLanguage } from "../../../../../../../interfaces/interfaces";
import DragAndDropLanguages from "./DragAndDropLanguages";
import { useUpdateLanguageHook } from "../../../../../../../hooks/useUpdateLanguageHook";

type TEditLanguageProps = {
  studentLanguages: TLanguage[]
}
const EditLanguage: FC<TEditLanguageProps> = ({ studentLanguages }) => {
  const { availableLanguages } = useUpdateLanguageHook(studentLanguages)
  const refInput = useRef<HTMLInputElement>(null);
  // const [selectOptionValue, setSelectOptionValue] = useState<string>();

  const refDialog = useRef<HTMLDialogElement>(null);
  const onInputLanguage = (event: ChangeEvent<HTMLInputElement>) => {
    console.log(event)
  }

  const handlerSelect = () => {
    if (refDialog.current) {
      console.log(refDialog.current.open = !refDialog.current.open)
    }
  }

  return (
    <section className="p-1 relative bg-stone-50">
      <header className="flex justify-between items-center relative">
        <h2 className="p-4">Idiomas</h2>
        <button type="button" onClick={handlerSelect}>X</button>
        <dialog ref={refDialog} className="absolute overflow-hidden h-72 w-full top-4 z-10 ">
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
      <DragAndDropLanguages dropLanguages={studentLanguages} />
    </section>
  )
}

export default EditLanguage;
