import { useForm } from 'react-hook-form'
import { MutableRefObject, useEffect, useState } from 'react'
import { TUpdateProject } from '../interfaces/interfaces'
import { setEditProjectModalIsOpen } from '../store/slices/student/projectsSlice'
import { useAppDispatch, useAppSelector } from './ReduxHooks'
import { updateProjectsThunk } from '../store/thunks/updateProjectsThunk'
import { useCloseWhenClickOutside } from './ModalHooks/useCloseWhenClickOutside'
import { projectsThunk } from '../store/thunks/getDetailResourceStudentWithIdThunk'

export const useEditStudentProjects = (modalRef: MutableRefObject<null>) => {
    const { editProjectModalIsOpen, projectsData, selectedProjectID } =
        useAppSelector((state) => state.ShowStudentReducer.studentProjects)

    const selectedProject = projectsData.find(
        (project) => project.id === selectedProjectID,
    )
    const [newSkill, setNewSkill] = useState('')
    const [newSkillError, setNewSkillError] = useState('')

    const studentId = useAppSelector(
        (state) => state.ShowStudentReducer.studentDetails.aboutData.id,
    )
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

    const url = `http://localhost:8000/api/v1/student/${studentId}/resume/projects/${selectedProjectID}`

    const form = useForm({
        defaultValues,
    })

    const handleAddSkill = () => {
        const currentTags = form.getValues('tags') || []
        if (newSkill.trim() && !currentTags.includes(newSkill.trim())) {
            form.setValue('tags', [...currentTags, newSkill.trim()], {
                shouldDirty: true,
            })
            setNewSkill('')
        }
    }

    const handleRemoveTag = (tag: string) => {
        const currentTags = form.getValues('tags')
        const updatedTags = currentTags.filter((t) => t !== tag)
        form.setValue('tags', updatedTags, { shouldDirty: true })
    }

    const refreshFatherComponent = () => {
        dispatch(projectsThunk(studentId))
    }

    const onSubmit = async (data: TUpdateProject) => {
        try {
            await dispatch(
                updateProjectsThunk({
                    url,
                    formData: data,
                    options: {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                'token',
                            )}`,
                            Accept: 'application/json',
                        },
                    },
                }),
            ).unwrap()
            refreshFatherComponent()
            handleClose()
        } catch (error) {
            console.error('Error al actualizar el perfil:', error)
        }
    }

    const isSubmitDisabled = !form.formState.isDirty
    const tags = form.watch('tags', [])

    useEffect(() => {
        if (selectedProject) {
            form.reset({
                name: selectedProject.name,
                company_name: selectedProject.company_name,
                project_url: selectedProject.project_url,
                github_url: selectedProject.github_url,
                tags: selectedProject?.tags.map((tag) => tag.name),
            })
        }
    }, [selectedProject, form.reset])

    useCloseWhenClickOutside(modalRef, handleClose, editProjectModalIsOpen)

    const validateNewSkill = (value: string) => {
        const currentTags = form.getValues('tags') || []
        if (value.length > 0 && value.length < 2) {
            setNewSkillError('El skill debe tener al menos 2 letras.')
        } else if (currentTags.includes(value.trim())) {
            setNewSkillError('El tag ya existe.')
        } else {
            setNewSkillError('')
        }
    }

    const handleNewSkillChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { value } = e.target
        setNewSkill(value)
        validateNewSkill(value)
    }

    return {
        editProjectModalIsOpen,
        handleClose,
        form,
        handleAddSkill,
        isSubmitDisabled,
        tags,
        handleRemoveTag,
        onSubmit,
        newSkill,
        newSkillError,
        handleNewSkillChange,
    }
}
