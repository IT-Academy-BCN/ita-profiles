/* eslint-disable react/button-has-type */
import { useEffect, useState } from 'react'
import { Github, Linkedin, Pencil } from '../../../assets/svg'
import { Stud1 as ProfilePicture } from '../../../assets/img'
import { TAbout, ITag } from '../../../interfaces/interfaces'
import { useStudentIdContext } from '../../../context/StudentIdContext'
import { fetchAboutData } from '../../../api/FetchStudentsAbout'
import EditProfileModal from './EditProfileModal'

const StudentDataCard: React.FC = () => {
    const [aboutData, setAboutData] = useState<TAbout[]>([])
    const { studentUUID, openEditModal, isModalOpen, editStudentData } =
        useStudentIdContext()
    const [showFullDescription, setShowFullDescription] = useState(false)
    const [isLoggedIn] = useState(true) // Simulate logged in status
    const toggleDescription = () => {
        setShowFullDescription(!showFullDescription)
    }

    useEffect(() => {
        const getStudentData = async () => {
            try {
                if (studentUUID) {
                    const studentAbout = await fetchAboutData(studentUUID)
                    setAboutData(studentAbout)
                }
            } catch (error) {
                throw new Error('Failed to obtain student data')
            }
        }

        if (studentUUID) {
            getStudentData()
        }
    }, [studentUUID])

    return (
        <div data-testid="StudentDataCard">
            {aboutData.map((studentData) => (
                <div key={studentData.id} className="flex flex-col gap-4">
                    <div className="flex gap-3">
                        <img
                            src={ProfilePicture}
                            alt="Profile"
                            className="h-20 w-20 flex-none rounded-lg"
                        />
                        <div className="flex flex-1 justify-between">
                            <div className="flex flex-col gap-2">
                                <div className="flex flex-col">
                                    <h2 className="text-xl font-bold">
                                        {studentData.fullname}
                                    </h2>
                                    <p className="text-gray-2">
                                        {studentData.subtitle}
                                    </p>
                                </div>
                                <div className="flex gap-4">
                                    <a
                                        href={
                                            studentData.social_media.github.url
                                        }
                                        className="flex gap-1"
                                    >
                                        <img src={Github} alt="github icon" />
                                        Github
                                    </a>
                                    <a
                                        href={
                                            studentData.social_media.linkedin
                                                .url
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
                            {isLoggedIn && (
                                <button
                                    onClick={() => openEditModal(studentData)}
                                    className="ps-1 "
                                >
                                    <img src={Pencil} alt="pencil icon" />
                                </button>
                            )}
                        </div>
                    </div>
                    <div className="flex flex-col gap-6">
                        <div className="flex flex-col gap-2">
                            <h3 className="text-lg font-bold">About</h3>
                            <div>
                                <p className="text-sm">
                                    {showFullDescription
                                        ? studentData.about
                                        : `${studentData.about
                                              .split(' ')
                                              .slice(0, 15)
                                              .join(' ')}...`}
                                    {!showFullDescription && (
                                        <button
                                            type="button"
                                            onClick={toggleDescription}
                                            className="text-sm text-gray-3"
                                        >
                                            ver más
                                        </button>
                                    )}
                                </p>
                                {showFullDescription && (
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
                        <ul className="flex flex-wrap gap-2">
                            {studentData.tags.map((tag: ITag) => (
                                <li
                                    key={tag.id}
                                    className="rounded-md bg-gray-5-background px-2 py-1 text-sm"
                                >
                                    {tag.name}
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
            ))}
            {isModalOpen && editStudentData && (
                <EditProfileModal studentData={editStudentData} />
            )}
        </div>
    )
}

export default StudentDataCard
