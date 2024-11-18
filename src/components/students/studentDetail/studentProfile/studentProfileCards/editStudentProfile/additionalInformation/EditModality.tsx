import { FC } from "react";
import { TModality } from "../../../../../../../interfaces/interfaces";

type EditModalityProps = {
  additionalTraining: TModality[]
}
const EditModality: FC<EditModalityProps> = () => {

  return (
    <section className="p-1 relative">
      <h3>Modalidad</h3>
      <div className="p-1">
        <label htmlFor="Indiferente">
          Indiferente
          <input type="radio" name="level" id="Indiferente" defaultValue="Indiferente" />
        </label>
        <label htmlFor="Remoto">
          Remoto
          <input type="radio" name="level" id="Remoto" defaultValue="Remoto" />
        </label>
        <label htmlFor="Presencial">
          Presencial
          <input type="radio" name="level" id="Presencial" defaultValue="Presencial" />
        </label>
      </div>
    </section>
  );
}

export default EditModality;
