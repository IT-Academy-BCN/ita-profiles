import { useForm } from 'react-hook-form'
import { useRef } from 'react'
import { Close } from '../../../../../../assets/svg'
import { Stud1 as defaultPhoto } from '../../../../../../assets/img'
import { useEditStudentProfile } from '../../../../../../hooks/useEditstudentProfile'

interface EditStudentProfileProps {
    handleModal: () => void
    handleRefresh: (id: string) => void
}

export const EditStudentProfile: React.FC<EditStudentProfileProps> = ({
    handleModal,
    handleRefresh,
}) => {
    const {
        submitForm,
        toggleProfileImage,
        useCloseWhenClickOutside,
        defaultValues,
        editProfileModalIsOpen,
        aboutData,
    } = useEditStudentProfile()

    const modalRef = useRef<HTMLDivElement>(null)
    useCloseWhenClickOutside(modalRef, handleModal)

    const {
        register,
        handleSubmit,
        formState: { errors, isDirty },
    } = useForm({
        defaultValues,
    })
    const isSubmitDisabled = !isDirty
    return (
        editProfileModalIsOpen && (
            <div className="fixed inset-0 flex justify-center items-center bg-[rgba(0,0,0,0.5)] z-10">
                <div
                    ref={modalRef}
                    className="w-[400px] h-[90%] md:h-[80%] max-h-[800px] m-0 flex flex-col border border-[rgba(128,128,128,1)] rounded-xl bg-white p-[37px] pb-4 pt-4 pr-4"
                >
                    <div className="flex justify-between">
                        <div />
                        <button
                            aria-label="close X student modal"
                            type="button"
                            onClick={handleModal}
                            className="cursor-pointer"
                        >
                            <img src={Close} alt="close icon" className="h-5" />
                        </button>
                    </div>
                    <div className="w-full h-full ">
                        <div className="flex flex-col h-[20%] justify-evenly">
                            <h1 className="text-2xl my-0 mb-2 font-bold text-[rgba(40,40,40,1)]">
                                Editar datos
                            </h1>
                            <div className="flex  justify-between pr-4 mb-2">
                                <div className="w-[86px] h-[77px] border border-[rgba(128,128,128,1)] rounded-2xl mb-2">
                                    <img
                                        className="w-full h-full object-cover rounded-2xl"
                                        src={
                                            aboutData.photo
                                                ? aboutData.photo
                                                : defaultPhoto
                                        }
                                        alt="Student profile"
                                    />
                                </div>
                                <button
                                    aria-label="Open upload image modal"
                                    className="h-[30px] w-[180px] self-center text-sm text-[rgba(30,30,30,1)] font-bold border border-[rgba(128,128,128,1)] rounded-lg  "
                                    type="button"
                                    onClick={() => toggleProfileImage()}
                                >
                                    Subir nueva imagen
                                </button>
                            </div>
                        </div>
                        <form
                            aria-label="edit student form"
                            className="flex flex-col w-full h-[80%] pt-4"
                            onSubmit={handleSubmit((data) =>
                                submitForm(data, handleRefresh, handleModal),
                            )}
                        >
                            <div className="flex flex-col flex-grow w-full overflow-y-auto pr-4">
                                <div className="w-[304px] border-t border-[rgba(217,217,217,1)]" />
                                <div className="flex flex-col">
                                    <label
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                        htmlFor="name"
                                    >
                                        Nombre
                                    </label>
                                    <input
                                        {...register('name', {
                                            required:
                                                'Error: Este campo es requerido !',
                                            minLength: {
                                                value: 3,
                                                message: 'Mínimo 3 caracteres',
                                            },
                                        })}
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="name"
                                        type="text"
                                        name="name"
                                    />
                                    {errors.name ? (
                                        <p className="text-center font-bold text-xs text-red-500 py-1">
                                            {errors.name?.message}
                                        </p>
                                    ) : (
                                        ''
                                    )}
                                </div>
                                <div className="flex flex-col">
                                    <label
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                        htmlFor="surname"
                                    >
                                        Apellidos
                                    </label>
                                    <input
                                        {...register('surname', {
                                            required:
                                                'Error: Este campo es requerido !',
                                            minLength: {
                                                value: 3,
                                                message: 'Mínimo 3 caracteres',
                                            },
                                        })}
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="surname"
                                        type="text"
                                        name="surname"
                                    />
                                    {errors.surname ? (
                                        <p className="text-center font-bold text-xs text-red-500 py-1">
                                            {errors.surname.message}
                                        </p>
                                    ) : (
                                        ''
                                    )}
                                </div>
                                <div className="flex flex-col">
                                    <label
                                        htmlFor="subtitle"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Titular
                                    </label>
                                    <input
                                        {...register('subtitle', {
                                            required:
                                                'Error: Este campo es requerido !',
                                            minLength: {
                                                value: 3,
                                                message: 'Mínimo 3 caracteres',
                                            },
                                        })}
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                        id="subtitle"
                                        type="text"
                                        name="subtitle"
                                    />
                                    {errors.subtitle ? (
                                        <p className="text-center font-bold text-xs text-red-500 py-1">
                                            {errors.subtitle.message}
                                        </p>
                                    ) : (
                                        ''
                                    )}
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
                                        {...register('github_url', {
                                            required:
                                                'Error: Este campo es requerido !',
                                            pattern: {
                                                value: /^(https?:\/\/)?(www\.)?github\.com\/.+$/,
                                                message:
                                                    'Formato de url inválido. Ej. https://github.com/ora00 ',
                                            },
                                        })}
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px]"
                                        id="github_url"
                                        type="text"
                                        name="github_url"
                                    />
                                    {errors.github_url ? (
                                        <p className="text-center font-bold text-xs text-red-500 py-1">
                                            {errors.github_url.message}
                                        </p>
                                    ) : (
                                        ''
                                    )}
                                </div>

                                <div className="flex flex-col">
                                    <label
                                        htmlFor="linkedin_url"
                                        className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                    >
                                        Link perfil de Linkedin
                                    </label>
                                    <input
                                        {...register('linkedin_url', {
                                            required:
                                                'Error: Este campo es requerido !',
                                            pattern: {
                                                value: /^(https?:\/\/)?(www\.)?linkedin\.com\/.+$/,
                                                message:
                                                    'Formato de url inválido. Ej. https://linkedin.com/ora00  ',
                                            },
                                        })}
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)] mt-[5px] mb-[10px]"
                                        id="linkedin_url"
                                        type="text"
                                        name="linkedin_url"
                                    />
                                    {errors.linkedin_url ? (
                                        <p className="text-center font-bold text-xs text-red-500 py-1">
                                            {errors.linkedin_url.message}
                                        </p>
                                    ) : (
                                        ''
                                    )}
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
                                        {...register('about', {
                                            required:
                                                'Error: Este campo es requerido !',
                                            minLength: {
                                                value: 3,
                                                message: 'Mínimo 3 caracteres',
                                            },
                                        })}
                                        className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)] font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)] mt-[5px] mb-[10px]"
                                        id="about"
                                        type="text"
                                        name="about"
                                    />
                                    {errors.about ? (
                                        <p className="text-center font-bold text-xs text-red-500 py-1">
                                            {errors.about.message}
                                        </p>
                                    ) : (
                                        ''
                                    )}
                                </div>
                            </div>
                            <div className="flex w-full mt-4 mb-8 mr-8 gap-3 ">
                                <button
                                    aria-label="cancel student button"
                                    onClick={handleModal}
                                    className="flex-1 h-[63px] rounded-xl font-bold border border-[rgba(128,128,128,1)]"
                                    type="button"
                                >
                                    Cancelar
                                </button>
                                <button
                                    disabled={isSubmitDisabled}
                                    type="submit"
                                    aria-label="submit form button"
                                    className="flex-1 h-[63px] rounded-xl bg-primary font-bold text-white border mr-4 border-[rgba(128,128,128,1)]"
                                >
                                    Aceptar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        )
    )
}
