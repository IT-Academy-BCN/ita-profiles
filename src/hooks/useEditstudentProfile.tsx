import { useAppDispatch, useAppSelector } from './ReduxHooks'
import { updateDetailThunk } from '../store/thunks/getDetailResourceStudentWithIdThunk'
import { setEditProfileImageIsOpen } from '../store/slices/student/detailSlice'
import { TStudentFormData } from '../../types'
import { useCloseWhenClickOutside } from './ModalHooks/useCloseWhenClickOutside'

export const useEditStudentProfile = () => {
    const dispatch = useAppDispatch()

    const { aboutData, editProfileModalIsOpen } = useAppSelector(
        (state) => state.ShowStudentReducer.studentDetails,
    )
    const id = aboutData.id.toString()

    const submitForm = async (
        data: TStudentFormData,
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
}
