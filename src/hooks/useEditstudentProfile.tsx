<<<<<<< HEAD
import { useAppDispatch, useAppSelector } from './ReduxHooks'
import { updateDetailThunk } from '../store/thunks/getDetailResourceStudentWithIdThunk'
import { setEditProfileImageIsOpen } from '../store/slices/student/detailSlice'
import { TStudentFormData } from '../../types'
=======
import { useAppDispatch } from './ReduxHooks'
import { updateDetailThunk } from '../store/thunks/getDetailResourceStudentWithIdThunk'
import { setToggleProfileImage } from '../store/slices/student/detailSlice'
import { TStudentFormData } from '../interfaces/interfaces'
>>>>>>> 8ad62a49 (Fix: EditStudentProfile modal behavior and refactor)
import { useCloseWhenClickOutside } from './ModalHooks/useCloseWhenClickOutside'

export const useEditStudentProfile = () => {
    const dispatch = useAppDispatch()
<<<<<<< HEAD

    const { aboutData, editProfileModalIsOpen } = useAppSelector(
        (state) => state.ShowStudentReducer.studentDetails,
    )
    const id = aboutData.id.toString()

    const submitForm = async (
        data: TStudentFormData,
=======
    const submitForm = async (
        data: TStudentFormData,
        id: string,
>>>>>>> 8ad62a49 (Fix: EditStudentProfile modal behavior and refactor)
        handleRefresh: (id: string) => void,
        handleModal: () => void,
    ) => {
        const url = `http://localhost:8000/api/v1/student/${id}/resume/profile`

        try {
            await dispatch(updateDetailThunk({ url, formData: data })).unwrap()
            handleRefresh(id)
            handleModal()
        } catch (error) {
            console.error('Error al actualizar el perfil:', error)
        }
    }

<<<<<<< HEAD
    const toggleProfileImage = () => {
        dispatch(setEditProfileImageIsOpen())
    }
    const defaultValues = {
        name: aboutData.name,
        surname: aboutData.surname,
        subtitle: aboutData.resume.subtitle,
        github_url: aboutData.resume.social_media.github,
        linkedin_url: aboutData.resume.social_media.linkedin,
        about: aboutData.resume.about,
        tags_ids: aboutData.tags.map((item) => item.id),
    }

    return {
        submitForm,
        toggleProfileImage,
        useCloseWhenClickOutside,
        defaultValues,
        aboutData,
        editProfileModalIsOpen,
    }
=======
    const toggleProfileImage = (currentToggleState: boolean) => {
        dispatch(setToggleProfileImage(!currentToggleState))
    }

    return { submitForm, toggleProfileImage, useCloseWhenClickOutside }
>>>>>>> 8ad62a49 (Fix: EditStudentProfile modal behavior and refactor)
}
