import { useRef } from 'react'
import { Close, Plus } from '../../../../../assets/svg'
import { useEditStudentProjects } from '../../../../../hooks/useEditStudentProjects'

export const EditStudentProjects = () => {
    const modalRef = useRef(null)
    const {
        editProjectModalIsOpen,
        handleClose,
        form,
        handleAddSkill,
        onSubmit,
        handleRemoveTag,
        newSkill,
        isSubmitDisabled,
        tags,
        newSkillError,
        handleNewSkillChange,
    } = useEditStudentProjects(modalRef)

    const { register, handleSubmit, formState } = form
    const { errors } = formState

    return editProjectModalIsOpen ? (
        <div className="fixed inset-0 flex justify-center items-center bg-[rgba(0,0,0,0.5)] z-10">
            <div className="w-[400px] h-max[90%] md:h-max-[80%] max-h-[800px] m-0 flex flex-col border border-[rgba(128,128,128,1)] rounded-xl bg-white p-4">
                <div className="flex justify-between">
                    <div />
                    <button
                        aria-label="close X project modal"
                        type="button"
                        onClick={handleClose}
                        className="cursor-pointer hover:scale-105"
                    >
                        <img src={Close} alt="close icon" className="h-5" />
                    </button>
                </div>
                <div className="w-full h-full p-4 ">
                    <h1 className="text-2xl my-0 mb-2 font-bold text-[rgba(40,40,40,1)]">
                        Editar proyecto
                    </h1>
                    <form
                        ref={modalRef}
                        onSubmit={handleSubmit(onSubmit)}
                        aria-label="edit project modal"
                    >
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
                                htmlFor="company_name"
                            >
                                Empresa
                            </label>
                            <input
                                {...register('company_name', {
                                    required:
                                        'Error: Este campo es requerido !',
                                    minLength: {
                                        value: 3,
                                        message: 'Mínimo 3 caracteres',
                                    },
                                })}
                                className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                id="company_name"
                                type="text"
                                name="company_name"
                            />
                            {errors.company_name ? (
                                <p className="text-center font-bold text-xs text-red-500 py-1">
                                    {errors.company_name?.message}
                                </p>
                            ) : (
                                ''
                            )}
                        </div>
                        <div className="flex flex-col">
                            <label
                                className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                htmlFor="skills"
                            >
                                Skills
                            </label>

                            <div className="flex my-4 gap-2 flex-wrap">
                                <div className="flex items-center justify-center rounded-md px-2 py-1 text-sm bg-gray-5-background focus-within:border-2 focus-within:border-black">
                                    <input
                                        type="text"
                                        value={newSkill}
                                        placeholder="Nuevo skill"
                                        onChange={handleNewSkillChange}
                                        className="bg-gray-5-background rounded-md text-gray-800 py-1 px-2 text-sm outline-none w-24 placeholder:text-gray-500 focus:placeholder-transparent"
                                    />
                                    <button
                                        className="bg-gray-5-background cursor-pointer rounded-md text-gray-800 px-1 text-xl hover:bg-gray-400 outline-none self-center"
                                        onClick={handleAddSkill}
                                        disabled={!newSkill || !!newSkillError}
                                        type="button"
                                    >
                                        <img src={Plus} alt="plus icon" />
                                    </button>
                                </div>
                                {newSkillError && (
                                    <p className="text-center block w-full font-bold text-xs text-red-500 py-1">
                                        {newSkillError}
                                    </p>
                                )}
                                {tags?.map((tag) => (
                                    <div
                                        key={tag}
                                        className="flex items-center justify-center rounded-md px-2 py-1 text-sm bg-gray-5-background"
                                    >
                                        <span className="flex items-center text-gray-800 px-2">
                                            {tag}
                                        </span>
                                        <button
                                            className="bg-gray-5-background cursor-pointer p-2 rounded-md text-gray-800 px-1 text-xl hover:bg-gray-400 outline-none self-center"
                                            onClick={() => handleRemoveTag(tag)}
                                            type="button"
                                        >
                                            <img
                                                src={Close}
                                                alt="close icon"
                                                className="h-3"
                                            />
                                        </button>
                                    </div>
                                ))}
                            </div>
                            {errors.tags ? (
                                <p className="text-center font-bold text-xs text-red-500 py-1">
                                    {errors.tags?.message}
                                </p>
                            ) : (
                                ''
                            )}
                        </div>
                        <div className="flex flex-col">
                            <label
                                className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                htmlFor="github_url"
                            >
                                Link de GitHub
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
                                className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                id="github_url"
                                type="text"
                                name="github_url"
                            />
                            {errors.github_url ? (
                                <p className="text-center font-bold text-xs text-red-500 py-1">
                                    {errors.github_url?.message}
                                </p>
                            ) : (
                                ''
                            )}
                        </div>
                        <div className="flex flex-col">
                            <label
                                className="text-[12px] leading-[19px] font-medium text-[rgba(128,128,128,1)] "
                                htmlFor="project_url"
                            >
                                Link demo
                            </label>
                            <input
                                {...register('project_url', {
                                    required:
                                        'Error: Este campo es requerido !',
                                    pattern: {
                                        value: /^(https?:\/\/)?([\w.-]+)\.([a-z]{2,})(\/[\w./?%&=-]*)?$/,
                                        message:
                                            'Formato de url inválido. Ej: https://barcelonaactiva.com',
                                    },
                                })}
                                className="text-[16px] leading-[19px] text-[rgba(30,30,30,1)]  font-medium p-4 w-full h-[61px] border rounded-lg border-[rgba(128,128,128,1)]  mt-[5px] mb-[10px] "
                                id="project_url"
                                type="text"
                                name="project_url"
                            />
                            {errors.project_url ? (
                                <p className="text-center font-bold text-xs text-red-500 py-1">
                                    {errors.project_url?.message}
                                </p>
                            ) : (
                                ''
                            )}
                        </div>
                        <div className="flex w-full my-4 gap-3">
                            <button
                                aria-label="cancel edit project button"
                                onClick={handleClose}
                                className="flex-1 h-[63px] hover:scale-105 rounded-xl font-bold border border-[rgba(128,128,128,1)]"
                                type="button"
                            >
                                Cancelar
                            </button>
                            <button
                                disabled={isSubmitDisabled}
                                type="submit"
                                aria-label="submit edit project button"
                                className="flex-1 h-[63px] hover:scale-105 disabled:opacity-75 disabled:scale-100 rounded-xl bg-primary font-bold text-white border border-[rgba(128,128,128,1)]"
                            >
                                Aceptar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    ) : null
}
