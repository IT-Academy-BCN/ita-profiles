import React, { useEffect, useState } from 'react'
import { useForm } from 'react-hook-form'
import { useAppDispatch, useAppSelector } from '../../../../../hooks/ReduxHooks'
import { Close, Plus } from '../../../../../assets/svg'
import { setEditProjectModalIsOpen } from '../../../../../store/slices/student/projectsSlice'
import { TUpdateProject } from '../../../../../interfaces/interfaces'
import { updateProjectsThunk } from '../../../../../store/thunks/updateProjectsThunk'

export const EditStudentProjects = () => {
    const { editProjectModalIsOpen, projectsData, selectedProjectID } =
        useAppSelector((state) => state.ShowStudentReducer.studentProjects)

    const selectedProject = projectsData.find(
        (project) => project.id === selectedProjectID,
    )

    const studentId = useAppSelector(
        (state) => state.ShowStudentReducer.studentDetails.aboutData.id,
    )
    const [newSkill, setNewSkill] = useState('')

    const dispatch = useAppDispatch()

    const handleClose = () => {
        dispatch(setEditProjectModalIsOpen())
    }

    const defaultValues: TUpdateProject = {
        name: selectedProject?.name || '',
        company_name: selectedProject?.company_name || '',
        project_url: selectedProject?.project_url || '',
        github_url: selectedProject?.github_url || '',
        tags: selectedProject?.tags.map((tag) => tag.name) || [],
    }

    const {
        register,
        handleSubmit,
        getValues,
        setValue,
        watch,
        reset,
        formState: { errors, isDirty },
    } = useForm({
        defaultValues,
    })

    const handleAddSkill = () => {
        const currentTags = getValues('tags') || []
        if (newSkill.trim() && !currentTags.includes(newSkill.trim())) {
            setValue('tags', [...currentTags, newSkill.trim()], {
                shouldDirty: true,
            })
            setNewSkill('')
        }
    }

    const handleRemoveTag = (tag: string) => {
        const currentTags = getValues('tags')
        const updatedTags = currentTags.filter((t) => t !== tag)
        setValue('tags', updatedTags, { shouldDirty: true })
    }
    // const token: string = localStorage.getItem('token') || ''
    // console.log(token)
    const url = `http://localhost:8000/api/v1/student/${studentId}/resume/projects/${selectedProjectID}`
    const onSubmit = (data: TUpdateProject) => {
        try {
            dispatch(updateProjectsThunk({ url, formData: data })).unwrap()
            handleClose()
        } catch (error) {
            console.error('Error al actualizar el perfil:', error)
        }
    }

    const isSubmitDisabled = !isDirty

    const tags = watch('tags', [])

    useEffect(() => {
        if (selectedProject) {
            reset({
                name: selectedProject.name,
                company_name: selectedProject.company_name,
                project_url: selectedProject.project_url,
                github_url: selectedProject.github_url,
                tags: selectedProject?.tags.map((tag) => tag.name),
            })
        }
    }, [selectedProject, reset])

    return editProjectModalIsOpen ? (
        <div className="fixed inset-0 flex justify-center items-center bg-[rgba(0,0,0,0.5)] z-10">
            <div className="w-[400px] h-max[90%] md:h-max-[80%] max-h-[800px] m-0 flex flex-col border border-[rgba(128,128,128,1)] rounded-xl bg-white p-4">
                <div className="flex justify-between">
                    <div />
                    <button
                        aria-label="close X student modal"
                        type="button"
                        onClick={handleClose}
                        className="cursor-pointer hover:scale-105"
                    >
                        <img src={Close} alt="close icon" className="h-5" />
                    </button>
                </div>
                <div className="w-full h-full p-4 ">
                    <h1 className="text-2xl my-0 mb-2 font-bold text-[rgba(40,40,40,1)]">
                        Editar Proyecto
                    </h1>
                    <form onSubmit={handleSubmit(onSubmit)}>
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
                                        onChange={(e) =>
                                            setNewSkill(e.target.value)
                                        }
                                        className="bg-gray-5-background rounded-md text-gray-800 py-1 px-2 text-sm outline-none w-24 placeholder:text-gray-500 focus:placeholder-transparent"
                                    />
                                    <button
                                        className="bg-gray-5-background cursor-pointer rounded-md text-gray-800 px-1 text-xl hover:bg-gray-400 outline-none self-center"
                                        onClick={handleAddSkill}
                                        disabled={!newSkill}
                                        type="button"
                                    >
                                        <img src={Plus} alt="plus icon" />
                                    </button>
                                </div>

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
                                    minLength: {
                                        value: 3,
                                        message: 'Mínimo 3 caracteres',
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
                                    minLength: {
                                        value: 3,
                                        message: 'Mínimo 3 caracteres',
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
                                aria-label="cancel student button"
                                onClick={handleClose}
                                className="flex-1 h-[63px] hover:scale-105 rounded-xl font-bold border border-[rgba(128,128,128,1)]"
                                type="button"
                            >
                                Cancelar
                            </button>
                            <button
                                disabled={isSubmitDisabled}
                                type="submit"
                                aria-label="submit form button"
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
