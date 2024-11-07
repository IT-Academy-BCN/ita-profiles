import { useState } from 'react'
import target from '../../../../../assets/img/target.png'
import folder from '../../../../../assets/img/folder.png'
import { Pencil } from '../../../../../assets/svg'
import { useAppDispatch, useAppSelector } from '../../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../../atoms/LoadingSpiner'
import { ModalPortals } from '../../../../ModalPortals'
import { EditCollaborations } from './editStudentProfile/EditCollaborations'
import { collaborationThunk } from '../../../../../store/thunks/getDetailResourceStudentWithIdThunk'

const MyProfileCollaborationCard: React.FC = () => {
    const { studentCollaborations } = useAppSelector((state) => state.ShowStudentReducer)
    const {collaborationsData, isLoadingCollaborations, isErrorCollaborations} = studentCollaborations
    const [resourcesCard, challengesCard] = collaborationsData
    const [openEditCollaborations, setOpenEditCollaborations] = useState(false)

    const handleEditCollaborationsModal = () => {
        setOpenEditCollaborations(!openEditCollaborations)
    }

    const dispatch = useAppDispatch()

    const refreshCollaborationsData = (id: string) => {
        dispatch(collaborationThunk(id))
    }

    return (
        <div className="flex flex-col gap-4" data-testid="CollaborationCard">
            <div className='flex'>
                <h3 className="text-lg font-bold text-black-3">Colaboración</h3>
                <button
                    type='button' 
                    className='ml-auto'
                    onClick={handleEditCollaborationsModal}
                    >
                        <img src={Pencil} alt="edit collaboration information" />
                </button>
            </div>            
            <div className="flex flex-col gap-4 md:flex-row">
                {isLoadingCollaborations && <LoadingSpiner />}
                {isErrorCollaborations && (
                    <LoadingSpiner
                        textContent="Error"
                        type="loading-bars"
                        textColor="red"
                    />
                )}
                {openEditCollaborations && (
                <ModalPortals>
                    <EditCollaborations
                        handleModal={handleEditCollaborationsModal}
                        handleRefresh={refreshCollaborationsData}
                    />
                </ModalPortals>
            )}
                {!isLoadingCollaborations && (
                    <>
                        {/* RESOURCES CARD */}
                        <div className="flex w-2/3 md:w-1/2 items-start justify-between rounded-md bg-ita-wiki p-3 pl-7 pt-3">
                            <div className="flex flex-col">
                                {resourcesCard === undefined ? (
                                    <p className="py-2 text-l text-white">
                                        -loading-
                                    </p>
                                ) : (
                                    <p className="text-2xl text-white">
                                        {resourcesCard.quantity}
                                    </p>
                                )}
                                <p className="text-md text-white">
                                    Recursos subidos
                                </p>
                                <p className="mt-2 text-sm font-light text-white">
                                    ita-wiki
                                </p>
                            </div>
                            <div className="w-9 -mt-1">
                                <img
                                    src={folder}
                                    alt="folder"
                                    className="h-full"
                                />
                            </div>
                        </div>

                        {/* CHALLENGES CARD */}
                        <div className="flex w-2/3 md:w-1/2 items-start justify-between rounded-md bg-ita-challenges p-3 pl-7 pt-3">
                            <div className="flex flex-col ">
                                {challengesCard === undefined ? (
                                    <p className="py-2 text-l text-white">
                                        -loading-
                                    </p>
                                ) : (
                                    <p className="text-2xl text-white">
                                        {challengesCard.quantity}
                                    </p>
                                )}
                                <p className="text-md text-white">
                                    Retos completados
                                </p>
                                <p className="mt-2 text-sm font-light text-white">
                                    ita-challenges
                                </p>
                            </div>
                            <div className="w-10 -mt-2">
                                <img
                                    src={target}
                                    alt="folder"
                                    className="w-full"
                                />
                            </div>
                        </div>
                    </>
                )}
            </div>
        </div>
    )
}

export default MyProfileCollaborationCard