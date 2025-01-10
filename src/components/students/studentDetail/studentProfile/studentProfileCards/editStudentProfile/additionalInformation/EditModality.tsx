import { FC } from 'react'
import { TModality } from '../../../../../../../../types'

type EditModalityProps = {
    additionalTraining: TModality[]
}
const EditModality: FC<EditModalityProps> = () => {
    return (
        <section className="flex flex-col gap-4 py-4">

            <h2 className="font-bold">
                Modalidad
            </h2>

            <div className="flex justify-between">
                <label htmlFor="Híbrido" className="flex gap-2">
                    <input
                        type="radio"
                        name="level"
                        id="Híbrido"
                        defaultValue="Indiferente"
                    />
                    <span>Indiferente</span>
                </label>
                <label htmlFor="Remoto" className="flex gap-2">
                    <input
                        type="radio"
                        name="level"
                        id="Remoto"
                        defaultValue="Remoto"
                    />
                    <span>Remoto</span>
                </label>
                <label htmlFor="Presencial" className="flex gap-2">
                    <input
                        type="radio"
                        name="level"
                        id="Presencial"
                        defaultValue="Presencial"
                    />
                    <span>Presencial</span>
                </label>
            </div>
        </section>
    )
}

export default EditModality
