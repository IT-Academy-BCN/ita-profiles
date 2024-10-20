import { useDispatch } from 'react-redux'
import { useState } from 'react'
import axios from 'axios'
import { useAppSelector } from '../../../../hooks/ReduxHooks'
import { Close } from '../../../../assets/svg'
import { setToggleProfileImage } from '../../../../store/slices/student/detailSlice'
import { Stud1 as defaultPhoto } from '../../../../assets/img'

interface EditStudentProfileProps {
    handleEditProfile: () => void
}

export const EditStudentProfile: React.FC<EditStudentProfileProps> = ({
    handleEditProfile,
}) => {
    const { aboutData, toggleProfileImage } = useAppSelector(
        (state) => state.ShowStudentReducer.studentDetails,
    )
    const dispatch = useDispatch()

    const [formData, setFormData] = useState({
        fullName: aboutData.fullname,
        titular: aboutData.resume.subtitle,
        github: aboutData.resume.social_media.github,
        linkedin: aboutData.resume.social_media.linkedin,
        descripción: aboutData.resume.about,
    })

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>): void => {
        const { name, value } = e.target
        setFormData((prev) => ({ ...prev, [name]: value }))
    }

    const updateProfile = async () => {
        const studentId = aboutData.id
        const url = `http://localhost:8000/api/v1/student/${studentId}/resume/profile`
    //    const newData= {
    //        ...aboutData,
    //        fullname: formData.fullName,
    //        resume: {
    //            subtitle: formData.titular,
    //            social_media: {
    //                github: formData.github,
    //                linkedin: formData.linkedin,
    //            },
    //            about: formData.descripción,
    //        },
    //    }
        const newData = {
            name: 'tomi', // nombre  y apellido es un solo campo en el figma
            surname: formData.fullName, // en el estado llega en un solo campo tambien
            subtitle: formData.titular,
            github_url: formData.github,
            linkedin_url: formData.linkedin,
            about: formData.descripción,
            tags_ids: [1, 2, 3], // lo tengo en otro formato en el estado
        }

        console.log('new Data : ', newData)
        console.log('about Data del estado: ', aboutData)

        try {
            const response = await axios.put(url, newData)
            console.log('Perfil actualizado con éxito:', response.data)
        } catch (error: unknown) {
            if (axios.isAxiosError(error)) {
                console.error(
                    'Error al actualizar el perfil:',
                    error.response?.data,
                )
            } else {
                console.error('Error desconocido:', error)
            }
        }
    }

    const handleSubmit = (event: React.FormEvent<HTMLFormElement>): void => {
        event.preventDefault()
        updateProfile()
    }

    const handleProfileImage = () => {
        dispatch(setToggleProfileImage(!toggleProfileImage))
    }

    return (
        <div className="fixed inset-0 flex justify-center items-center bg-[rgba(0,0,0,0.5)] z-50">
            <div className="w-[396px] h-[816px] mx-0 flex flex-col border border-[rgba(128,128,128,1)] rounded-xl bg-white p-[37px] pt-4 pr-4">
                <div className="flex justify-between">
                    <div />
                    <button
                        type="button"
                        onClick={handleEditProfile}
                        className="cursor-pointer"
                    >
                        <img src={Close} alt="close icon" className="h-5" />
                    </button>
                </div>
                <div className="w-[305px]">
                    <h1 className="text-[26px] w-[162px] h-[34px] my-0 leading-[34px] font-bold align-top  text-[rgba(40,40,40,1)]">
                        Editar datos
                    </h1>

                    <div className="flex items-center justify-between my-[10px] py-[10px]">
                        <div className="w-[86px] h-[77px] border border-[rgba(128,128,128,1)] rounded-2xl">
                            <img
                                src={
                                    aboutData.photo
                                        ? aboutData.photo
                                        : defaultPhoto
                                }
                                alt="Student profile"
                            />
                        </div>
                        <button
                            className="h-[30px] w-[180px] text-[rgba(30,30,30,1)] font-bold border border-[rgba(128,128,128,1)] rounded-lg text-sm "
                            type="button"
                            onClick={handleProfileImage}
                        >
                            Subir nueva imagen
                        </button>
                    </div>

                    <form aria-label="form" onSubmit={handleSubmit}>
                        <div className="w-[376px] h-[500px] my-[10px]">
                            <div className="w-[304px] border-t border-[rgba(217,217,217,1)]" />
                            <div className="w-[340px] h-[445px] my-[10px] py-[10px] overflow-y-scroll overflow-x-hidden">
                                <div className="flex flex-col">
                                    <label
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                        htmlFor="fullName"
                                    >
                                        Nombre y apellidos
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-[305px] h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="fullName"
                                        type="text"
                                        name="fullName"
                                        onChange={handleChange}
                                        value={formData.fullName}
                                    />
                                </div>
                                <div className="flex flex-col">
                                    <label
                                        htmlFor="titular"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Titular
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-[305px] h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="titular"
                                        type="text"
                                        name="titular"
                                        value={formData.titular}
                                        onChange={handleChange}
                                    />
                                </div>
                                <div className="border-b border-[rgba(217,217,217,1)] w-[305px] mt-[5px] mb-[10px] " />
                                <div className="flex flex-col">
                                    <label
                                        htmlFor="github"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Link de perfil de Github
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-[305px] h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px]"
                                        id="github"
                                        type="text"
                                        name="github"
                                        value={formData.github}
                                        onChange={handleChange}
                                    />
                                </div>

                                <div className="flex flex-col">
                                    <label
                                        htmlFor="linkedin"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Link perfil de Linkedin
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-[305px] h-[61px] border rounded-lg border-[rgba(128,128,128,1)] mt-[5px] mb-[10px]"
                                        id="linkedin"
                                        type="text"
                                        name="linkedin"
                                        onChange={handleChange}
                                        value={formData.linkedin}
                                    />
                                </div>
                                <div className="border-b border-[rgba(217,217,217,1)] w-[305px] mt-[5px] mb-[10px] " />
                                <div className="flex flex-col">
                                    <label
                                        htmlFor="description"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Descripción
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-[305px] h-[61px] border rounded-lg border-[rgba(128,128,128,1)] mt-[5px] mb-[10px]"
                                        id="description"
                                        type="text"
                                        name="descripción"
                                        onChange={handleChange}
                                        value={formData.descripción}
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="buttonGroup mx-auto w-[322px] h-[63px] flex justify-between gap-3">
                            <button
                                onClick={handleEditProfile}
                                className="w-1/2 h-[63px] rounded-xl font-bold border border-[rgba(128,128,128,1)]"
                                type="button"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                className="w-1/2  h-[63px] rounded-xl bg-primary font-bold text-white border border-[rgba(128,128,128,1)]"
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
