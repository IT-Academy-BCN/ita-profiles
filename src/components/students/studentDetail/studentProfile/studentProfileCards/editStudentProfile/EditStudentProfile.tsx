import { useDispatch } from 'react-redux'
import { useState } from 'react'
import { useAppSelector } from '../../../../../../hooks/ReduxHooks'
import { Close } from '../../../../../../assets/svg'
import { setToggleProfileImage } from '../../../../../../store/slices/student/detailSlice'
import { Stud1 as defaultPhoto } from '../../../../../../assets/img'
import { updateStudentProfile } from '../../../../../../api/student/updateStudentProfile'

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
        // TODO : [BE] Arreglar el student name y surname en back asì podemos acceder aqui al dato
        name: aboutData.fullname,
        surname: '',
        subtitle: aboutData.resume.subtitle,
        github_url: aboutData.resume.social_media.github,
        linkedin_url: aboutData.resume.social_media.linkedin,
        about: aboutData.resume.about,
        tags_ids: aboutData.tags.map((item) => item.id),
    })
    const id: string = String(aboutData.id)

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>): void => {
        const { name, value } = e.target
        setFormData((prev) => ({ ...prev, [name]: value }))
    }

    const handleSubmit = (event: React.FormEvent<HTMLFormElement>): void => {
        event.preventDefault()
        updateStudentProfile({ id, formData })
        handleEditProfile()
    }

    const handleProfileImage = () => {
        dispatch(setToggleProfileImage(!toggleProfileImage))
    }

    return (
        <div className="fixed inset-0 flex justify-center items-center bg-[rgba(0,0,0,0.5)] z-10">
            {/* {toggleProfileImage && (
                <ModalPortals>
                    <TU COMPONENTE />
                </ModalPortals>
            )} */}
            <div className="w-[396px] h-[90%] m-0 flex flex-col border border-[rgba(128,128,128,1)] rounded-xl bg-white p-[37px] pb-4 pt-4 pr-4">
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

                <div className="w-full h-full ">
                    <div className="flex flex-col h-[25%] justify-evenly">
                        <div className="flex">
                            <h1 className="text-[26px] w-[162px] h-[34px] my-0 leading-[34px] font-bold text-[rgba(40,40,40,1)]">
                                Editar datos
                            </h1>
                        </div>
                        <div className="flex justify-between pr-4">
                            <div className="w-[86px] h-[77px] border border-[rgba(128,128,128,1)] rounded-2xl ">
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
                                className="h-[30px] w-[180px] self-center text-sm  text-[rgba(30,30,30,1)] font-bold border border-[rgba(128,128,128,1)] rounded-lg  "
                                type="button"
                                onClick={handleProfileImage}
                            >
                                Subir nueva imagen
                            </button>
                        </div>
                    </div>
                    <div className="flex flex-col justify-between h-[75%] m-0 p-0">
                        <form
                            aria-label="form"
                            className="h-full"
                            onSubmit={handleSubmit}
                        >
                            <div className="flex flex-col w-full  h-[80%] overflow-y-auto pr-4">
                                <div className="w-[304px] border-t border-[rgba(217,217,217,1)]" />
                                <div className="flex flex-col">
                                    <label
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                        htmlFor="name"
                                    >
                                        Nombre
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="name"
                                        type="text"
                                        name="name"
                                        onChange={handleChange}
                                        value={formData.name}
                                    />
                                </div>
                                <div className="flex flex-col">
                                    <label
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                        htmlFor="surname"
                                    >
                                        Apellidos
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="surname"
                                        type="text"
                                        name="surname"
                                        onChange={handleChange}
                                        value={formData.surname}
                                    />
                                </div>
                                <div className="flex flex-col">
                                    <label
                                        htmlFor="subtitle"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Titular
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="subtitle"
                                        type="text"
                                        name="subtitle"
                                        value={formData.subtitle}
                                        onChange={handleChange}
                                    />
                                </div>
                                <div className="border-b border-[rgba(217,217,217,1)] w-full mt-[5px] mb-[10px] " />
                                <div className="flex flex-col">
                                    <label
                                        htmlFor="github_url"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Link de perfil de Github
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px]"
                                        id="github_url"
                                        type="text"
                                        name="github_url"
                                        value={formData.github_url}
                                        onChange={handleChange}
                                    />
                                </div>

                                <div className="flex flex-col">
                                    <label
                                        htmlFor="linkedin_url"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Link perfil de Linkedin
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)] mt-[5px] mb-[10px]"
                                        id="linkedin_url"
                                        type="text"
                                        name="linkedin_url"
                                        onChange={handleChange}
                                        value={formData.linkedin_url}
                                    />
                                </div>
                                <div className="border-b border-[rgba(217,217,217,1)] w-full mt-[5px] mb-[10px] " />
                                <div className="flex flex-col">
                                    <label
                                        htmlFor="about"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Descripción
                                    </label>
                                    <input
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)] mt-[5px] mb-[10px]"
                                        id="about"
                                        type="text"
                                        name="about"
                                        onChange={handleChange}
                                        value={formData.about}
                                    />
                                </div>
                            </div>
                            <div className=" buttonGroup mx-auto w-[full] h-[20%] items-center flex justify-between gap-3">
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
        </div>
    )
}
