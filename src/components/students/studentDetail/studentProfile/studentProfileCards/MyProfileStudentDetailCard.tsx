import { useState } from 'react'
import { createPortal } from 'react-dom'
import { ITag } from '../../../../../interfaces/interfaces'
import { useAppDispatch, useAppSelector } from '../../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../../atoms/LoadingSpiner'
import { EditStudentProfile } from './editStudentProfile/EditStudentProfile'
import { ModalPortals } from '../../../../ModalPortals'
import { detailThunk } from '../../../../../store/thunks/getDetailResourceStudentWithIdThunk'

const MyProfileStudentDetailCard: React.FC = () => {
    const [fullDescriptionVisibility, setFullDescriptionVisibility] =
        useState(false)
    const [openEditProfile, setOpenEditProfile] = useState(false)
    const {
        aboutData,
        isLoadingAboutData,
        isErrorAboutData,
        updatedError,
        updatedMessage,
    } = useAppSelector((state) => state.ShowStudentReducer.studentDetails)

    const dispatch = useAppDispatch()

    const toggleDescription = () => {
        setFullDescriptionVisibility(!fullDescriptionVisibility)
    }

    const handleModalEditProfile = () => {
        setOpenEditProfile(!openEditProfile)
    }

    const refreshStudentData = (id: string) => {
        dispatch(detailThunk(id))
    }

    const handleOpenEditSkills = () => {
        setShowEditSkills(true)
    }

    const handleCloseEditSkills = () => {
        setShowEditSkills(false)
    }

    const handleSaveSkills = (updatedSkills: string[]) => {
        const updatedTags = updatedSkills.map((skill) => ({
            id: Math.random(),
            name: skill,
        }))

        dispatch(updateTags(updatedTags))

        handleCloseEditSkills()
    }

    return (
        <div data-testid="StudentDataCard">
            {isLoadingAboutData && <LoadingSpiner />}
            {isErrorAboutData && <LoadingSpiner />}

            {openEditProfile && (
                <ModalPortals>
                    <EditStudentProfile
                        handleModal={handleModalEditProfile}
                        handleRefresh={refreshStudentData}
                    />
                    {toggleProfileImage && <UploadProfilePhoto />}
                </ModalPortals>
            )}

            {!isLoadingAboutData && (
                <div className="flex flex-col gap-4">
                    <div className="flex gap-3">
                        <img
                            src={ProfilePicture}
                            alt="Profile"
                            className="h-20 w-20 flex-none rounded-lg"
                        />
                        <div className="flex w-full">
                            <div className="flex flex-col gap-2 w-full">
                                <div className="flex flex-col">
                                    <div className="flex">
                                        <h2 className="text-xl font-bold">
                                            {`${aboutData.name} ${aboutData.surname}`}
                                        </h2>
                                        <button
                                            className="ml-auto"
                                            type="button"
                                            onClick={handleModalEditProfile}
                                        >
                                            <img
                                                src={Pencil}
                                                alt="edit profile information"
                                            />
                                        </button>
                                    </div>

                                    <p className="text-gray-2">
                                        {aboutData.resume.subtitle}
                                    </p>
                                </div>
                                <div className="flex gap-4">
                                    <a
                                        href={
                                            aboutData.resume.social_media.github
                                        }
                                        className="flex gap-1"
                                    >
                                        <img src={Github} alt="github icon" />
                                        Github
                                    </a>
                                    <a
                                        href={
                                            aboutData.resume.social_media
                                                .linkedin
                                        }
                                        className="flex gap-1"
                                    >
                                        <img
                                            src={Linkedin}
                                            alt="linkedin icon"
                                        />
                                        LinkedIn
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="flex flex-col gap-6">
                        <div className="flex flex-col gap-2">
                            <h3 className="text-lg font-bold">About</h3>
                            <div>
                                <p className="text-sm">
                                    {fullDescriptionVisibility
                                        ? aboutData && aboutData.resume.about
                                        : `${aboutData.resume.about
                                            .split(' ')
                                            .slice(0, 15)
                                            .join(' ')}...`}
                                    {!fullDescriptionVisibility && (
                                        <button
                                            type="button"
                                            onClick={toggleDescription}
                                            className="text-sm text-gray-3"
                                        >
                                            ver más
                                        </button>
                                    )}
                                </p>
                                {fullDescriptionVisibility && (
                                    <p className="text-sm">
                                        <button
                                            type="button"
                                            onClick={toggleDescription}
                                            className="text-sm text-gray-3"
                                        >
                                            ver menos
                                        </button>
                                    </p>
                                )}
                            </div>
                        </div>
                        <span className="h-0.5 w-full bg-gray-4-base" />
                        <div className="flex">
                            <ul className="flex flex-wrap gap-2">
                                {aboutData &&
                                    aboutData.tags.map((tag: ITag) => (
                                        <li
                                            key={tag.id}
                                            className="rounded-md bg-gray-5-background px-2 py-1 text-sm"
                                        >
                                            {tag.name}
                                        </li>
                                    ))}
                            </ul>
                            <button
                                className="ml-auto"
                                type="button"
                                onClick={handleOpenEditSkills}
                            >
                                <img src={Pencil} alt="edit tags" />
                            </button>
                        </div>
                    </div>
                    {!isLoadingAboutData &&
                        aboutData &&
                        showEditSkills &&
                        createPortal(
                            <EditSkills
                                initialSkills={
                                    aboutData?.tags?.map(
                                        (tag: ITag) => tag.name,
                                    ) || []
                                }
                                onClose={handleCloseEditSkills}
                                onSave={handleSaveSkills}
                            />,
                            document.body,
                        )}
                </div>
            )}
        </div>
    )
}

export default MyProfileStudentDetailCard
