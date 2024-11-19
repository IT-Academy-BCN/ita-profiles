import { ChangeEvent, useEffect, useRef, useState } from 'react'
import { z, ZodIssue } from 'zod'
import { useAppDispatch, useAppSelector } from './ReduxHooks'
import {
    resetSendingPhoto,
    setEditProfileImageIsOpen,
} from '../store/slices/student/detailSlice'
import { updateProfilePhotoThunk } from '../store/thunks/updateProfilePhotoThunk'
import { detailThunk } from '../store/thunks/getDetailResourceStudentWithIdThunk'

const MAX_MB = 500000

const imageFileSchema = z
    .instanceof(File)
    .refine((file) => file.type === 'image/png' || file.type === 'image/jpeg', {
        message: 'Selecciona el tipo de imagen correcto',
    })
    .refine((file) => file.size <= MAX_MB, {
        message: 'El peso de la imagen, tiene que ser menos de 5 MB',
    })

const useUploadProfilePhotoHook = () => {
    const { aboutData, editProfileImageIsOpen } = useAppSelector(
        (state) => state.ShowStudentReducer.studentDetails,
    )
    const { isLoadingPhoto, isErrorPhoto, photoSuccessfully } = useAppSelector(
        (state) => state.ShowStudentReducer.studentDetails,
    )
    const [changeImage, setChangeImage] = useState<string | null>()
    const [notifications, setNotifications] = useState<
        ZodIssue[] | [{ code: string; message: string }] | null
    >(null)
    const [btnDisabled, setBtnDisabled] = useState<boolean>(false)
    const refInput = useRef<HTMLInputElement | null>(null)

    const dispatch = useAppDispatch()

    const onChangeImage = (event: ChangeEvent<HTMLInputElement>) => {
        const file: File = event.currentTarget.files![0]
        const validateField = imageFileSchema.safeParse(file)

        if (!validateField.success) {
            console.log(validateField.error.errors)
            setNotifications(validateField.error.errors)
            setChangeImage(URL.createObjectURL(file))
            setBtnDisabled(true)
            return
        }

        setNotifications([])
        setBtnDisabled(false)
        setChangeImage(URL.createObjectURL(file))
    }

    const handleAccept = () => {
        if (refInput.current && refInput.current.files) {
            const file: File = refInput.current.files[0]
            const formData = new FormData()
            formData.append('photo', file, file.name)

            const validateField = imageFileSchema.safeParse(
                formData.get('photo'),
            )

            if (!validateField.success) {
                setNotifications(validateField.error.errors)
                return
            }

            dispatch(
                updateProfilePhotoThunk({
                    studentId: String(aboutData.id),
                    data: formData,
                }),
            )
        }
    }

    const handleCancel = () => {
        if (refInput.current) {
            refInput.current.value = ''
            setChangeImage(aboutData.photo)
            setNotifications(null)
            setBtnDisabled(false)
        }
    }

    useEffect(() => {
        if (isLoadingPhoto) {
            setNotifications([
                { code: 'custom', message: 'Enviando imagen ...' },
            ])
        }
        if (isErrorPhoto) {
            setNotifications([{ code: 'custom', message: 'Validation Error' }])
        }
        if (photoSuccessfully) {
            setNotifications([
                { code: 'custom', message: 'Foto actualizada exitosamente' },
            ])
            dispatch(detailThunk(String(aboutData.id)))

            setTimeout(() => {
                dispatch(resetSendingPhoto())
                dispatch(setEditProfileImageIsOpen())
            }, 3000)
        }
    }, [
        aboutData.id,
        aboutData.photo,
        dispatch,
        isErrorPhoto,
        isLoadingPhoto,
        photoSuccessfully,
        editProfileImageIsOpen,
    ])

    return {
        aboutData,
        editProfileImageIsOpen,
        isLoadingPhoto,
        isErrorPhoto,
        photoSuccessfully,
        setEditProfileImageIsOpen,
        changeImage,
        notifications,
        btnDisabled,
        refInput,
        dispatch,
        handleCancel,
        handleAccept,
        onChangeImage,
        resetSendingPhoto,
    }
}
export default useUploadProfilePhotoHook
