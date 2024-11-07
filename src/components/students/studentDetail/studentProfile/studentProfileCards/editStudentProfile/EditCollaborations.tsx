import { useForm } from 'react-hook-form'
import { useAppDispatch, useAppSelector } from '../../../../../../hooks/ReduxHooks'
import { Close } from '../../../../../../assets/svg'
import { TEditCollaborationsFormData } from '../../../../../../interfaces/interfaces'
import { updateCollaborationsThunk } from '../../../../../../store/thunks/updateStudentProfileThunk'

interface EditCollaborationsProps {
    handleModal: () => void
    handleRefresh: (id: string) => void
}

export const EditCollaborations: React.FC<EditCollaborationsProps> = ({ handleModal, handleRefresh }) => {

    const { id } = useAppSelector((state) => state.ShowStudentReducer.studentDetails.aboutData)
    const { collaborationsData } = useAppSelector((state) => state.ShowStudentReducer.studentCollaborations)
    const url = `http://localhost:8000/api/v1/student/${id}/resume/collaborations`

    const dispatch = useAppDispatch()

    const { register, handleSubmit } = useForm({
        defaultValues: {
            wikiCollaborations: collaborationsData[0].quantity,
            completedChallenges: collaborationsData[1].quantity
        }
    })

    const updateCollaborations = ((data: TEditCollaborationsFormData): void => {
        const formatedData = {collaborations: [data.wikiCollaborations, data.completedChallenges]}
        dispatch(updateCollaborationsThunk({ url, formData: formatedData }))
            .unwrap()
            .then(() => {
                handleRefresh(id.toString())
                handleModal()
            })
            .catch((error) => {
                console.error('Error al editar las colaboraciones:', error)
            })
    })

    return (
        <div className="fixed inset-0 flex justify-center items-center bg-[rgba(0,0,0,0.5)] z-10">
            <div className="w-[396px] flex flex-col rounded-xl bg-white p-[37px] pt-4 pr-4">
                <div className="flex justify-between">
                    <div />
                    <button
                        type="button"
                        onClick={handleModal}
                        className="cursor-pointer"
                    >
                        <img src={Close} alt="close icon" className="h-5" />
                    </button>
                </div>
                <div className="mr-8">
                    <h1 className="text-[26px] my-0 leading-[34px] font-bold">
                        Editar colaboraciones
                    </h1>


                    <form 
                        aria-label="form" 
                        onSubmit={ handleSubmit((data) => updateCollaborations(data) )}>
                        <div className="mt-6 mb-12 flex flex-col gap-8">
                                <div className="flex flex-col">
                                    <h2 className='font-bold mb-4'>
                                        Recursos subidos a wiki
                                    </h2>
                                    <label
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                        htmlFor=""
                                    >
                                        Número de recursos
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px]"
                                        id="wikiCollaborations"
                                        type="text"
                                        {...register("wikiCollaborations")}
                                    />
                                </div>
                                <div className="flex flex-col">
                                    <h2 className='font-bold mb-4'>
                                        Retos completados
                                    </h2>
                                    <label
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                        htmlFor=""
                                    >
                                        Número de retos
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px]"
                                        type="text"
                                        id="completedChallenges"
                                        {...register("completedChallenges")}
                                    />
                                </div>
                        </div>
                        <div className="buttonGroup mx-auto w-[322px] h-[63px] flex justify-between gap-3">
                            <button
                                className="w-1/2 h-[63px] rounded-xl font-bold border border-[rgba(128,128,128,1)]"
                                type="button"
                                onClick={handleModal}
                            >
                                Cancelar
                            </button>


                            <button
                                className="w-1/2  h-[63px] rounded-xl bg-primary font-bold text-white border border-[rgba(128,128,128,1)]"
                                type="submit"
                            >
                                Aceptar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    )
}
