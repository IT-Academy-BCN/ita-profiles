import { useAppDispatch } from './ReduxHooks'
import { updateDetailThunk } from '../store/thunks/getDetailResourceStudentWithIdThunk'
import { setEditProfileImageIsOpen } from '../store/slices/student/detailSlice'
import { TStudentFormData } from '../../types'
import { useCloseWhenClickOutside } from './ModalHooks/useCloseWhenClickOutside'

export const useEditStudentProfile = () => {
    const dispatch = useAppDispatch()
    const submitForm = async (
        data: TStudentFormData,
        id: string,
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

    const toggleProfileImage = (currentToggleState: boolean) => {
        dispatch(setToggleProfileImage(!currentToggleState))
    }

    return { submitForm, toggleProfileImage, useCloseWhenClickOutside }
}
