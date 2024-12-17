import target from '../../../../assets/img/target.png'
import folder from '../../../../assets/img/folder.png'
import { useAppSelector } from '../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../atoms/LoadingSpiner'

const CollaborationCard: React.FC = () => {
    const { studentCollaborations } = useAppSelector((state) => state.ShowStudentReducer)
    const { collaborationsData, isLoadingCollaborations, isErrorCollaborations } = studentCollaborations
    const [resourcesCard, challengesCard] = collaborationsData

    return (
        <div className="flex flex-col gap-4" data-testid="CollaborationCard">
            <h3 className="text-lg font-bold text-black-3">Colaboración</h3>
            <div className="flex flex-col gap-4 md:flex-row">
                {isLoadingCollaborations && <LoadingSpiner />}
                {isErrorCollaborations && (
                    <LoadingSpiner
                        textContent="Upss!!"
                        type="loading-bars"
                        textColor="red"
                    />
                )}
                {!isLoadingCollaborations && (
                    <>
                        {/* <ResourcesCard /> */}
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

                        {/* <ChallengesCard /> */}
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

export default CollaborationCard
