import { ChangeEvent, useEffect, useRef, useState } from "react";
import { z, ZodIssue } from 'zod';
import { useAppDispatch, useAppSelector } from "./ReduxHooks";
import { setToggleProfileImage } from "../store/slices/student/detailSlice";
import { updateProfilePhotoThunk } from "../store/thunks/updateProfilePhotoThunk";

const MAX_MB = 500000

const imageFileSchema = z
  .instanceof(File)
  .refine((file) => file.type === "image/png" || file.type === "image/jpeg", { message: "Selecciona el tipo de imagen correcto", })
  .refine((file) => file.size <= MAX_MB, { message: "El peso de la imagen, tiene que ser menos de 5 MB", });


const useUploadProfilePhotoHook = () => {

  const { aboutData, toggleProfileImage } = useAppSelector(state => state.ShowStudentReducer.studentDetails)
  const { isLoadingPhoto, isErrorPhoto, photoSuccessfully } = useAppSelector(state => state.ShowStudentReducer.studentDetails)
  const [changeImage, setChangeImage] = useState<string | null>();
  const [notifications, setNotifications] = useState<ZodIssue[] | [{ code: string, message: string }] | null>(null);
  const [btnDisabled, setBtnDisabled] = useState<boolean>(false)
  const refInput = useRef<HTMLInputElement | null>(null);

  const dispatch = useAppDispatch()

  const onChangeImage = (event: ChangeEvent<HTMLInputElement>) => {
    const file: File = event.currentTarget.files![0];
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
      const file: File = refInput.current.files[0];

      const formData = new FormData();
      formData.append('photo', file, file.name);

      const validateField = imageFileSchema.safeParse(formData.get("photo"))

      if (!validateField.success) {
        setNotifications(validateField.error.errors)
        return
      }

      dispatch(updateProfilePhotoThunk({
        studentId: String(aboutData.id),
        data: formData
      }))
    }
  }

  const handleCancel = () => {
    if (refInput.current) {
      refInput.current.value = ""
      setChangeImage(aboutData.photo)
      setNotifications(null)
      setBtnDisabled(false)
    }
  }

  useEffect(() => {
    if (photoSuccessfully) {
      if (refInput.current) {
        setNotifications([{ code: "custom", message: "Imagen actualizada correctamente." }])
        setTimeout(() => {
          dispatch(setToggleProfileImage(false))
        }, 3000)
      }
    }
    if (isErrorPhoto) {
      setNotifications([{ code: "custom", message: "Ups!! Error al procesar la imagen." }])
    }
  }, [dispatch, isErrorPhoto, photoSuccessfully])

  return {
    aboutData,
    toggleProfileImage,
    isLoadingPhoto,
    isErrorPhoto,
    photoSuccessfully,
    setToggleProfileImage,
    changeImage,
    notifications,
    btnDisabled,
    refInput,
    dispatch,
    handleCancel,
    handleAccept,
    onChangeImage
  }
}
export default useUploadProfilePhotoHook