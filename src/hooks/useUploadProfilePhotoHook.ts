import { useRef, useState } from "react";
import { z } from 'zod';
import { useAppDispatch, useAppSelector } from "./ReduxHooks";
import { updateProfilePhotoThunk } from "../store/thunks/updateProfilePhotoThunk";
import { resetSendingPhoto, setToggleProfileImage } from "../store/slices/student/detailSlice";
import errorFilter from "./error-filter.svg"
import errorUpload from "./error-upload.svg"
import sendPhoto from "./send-photo.svg"

const MAX_MB = 500000
const imageFileSchema = z
  .instanceof(File)
  .refine((file) => file.type === "image/png" || file.type === "image/jpeg", {

    message: "type",

  })
  .refine((file) => file.size <= MAX_MB, {

    message: "size",

  });

const useUploadProfilePhotoHook = () => {
  const fileRef = useRef<HTMLInputElement | null>(null);
  const formRef = useRef<HTMLFormElement | null>(null);
  const { aboutData, toggleProfileImage } = useAppSelector(state => state.ShowStudentReducer.studentDetails)
  const { sendingPhoto, errorSendingPhoto, photoSentSuccessfully } = useAppSelector(state => state.ShowStudentReducer.studentDetails)
  const [newProfilePicture, setNewProfilePicture] = useState<string>(aboutData.photo)
  const dispatch = useAppDispatch()

  const [validationErrors] = useState([
    {
      code: "upload",
      message: "Error al subir la imagen",
      img: errorUpload
    },
    {
      code: "size",
      message: "El archivo debe pesar menos de 5 MB",
      img: errorFilter
    },
    {
      code: "type",
      message: "El archivo debe ser una imagen en formato PNG o JPG",
      img: errorFilter
    },
  ])

  const handlerChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.files && event.target.files.length > 0) {
      const files: File[] = Array.from(event.target.files)
      const validacion = imageFileSchema.safeParse(files[0])



      if (validacion.success) {
        console.log(files[0])
        setNewProfilePicture(() => URL.createObjectURL(files[0]))

      } else {

        setNewProfilePicture(errorFilter)
        console.log(files[0].size)
        const existError = validationErrors.find(err => err.code === validacion.error.errors[0].message)
        console.log(validacion.error.errors[0].message, existError)
        setNewProfilePicture(existError!.img)
      }

    }
    dispatch(resetSendingPhoto())
  }

  const handlerPictureClick = () => fileRef.current?.click()

  const handlerCancel = () => {

    if (formRef.current) {
      formRef.current.reset()

    }
    dispatch(resetSendingPhoto())
    setNewProfilePicture(aboutData.photo)

  }
  const handleKeyDown = (event: React.KeyboardEvent<HTMLDivElement>) => {
    if (event.key === 'Enter' || event.key === ' ') {
      handlerPictureClick();

    }
  }

  const sendNewProfilePicture = async (event: React.ChangeEvent<HTMLFormElement>) => {
    event.preventDefault();

    const files = event.target.photo.files as FileList
    const formData = new FormData()
    formData.append("photo", files[0], files[0].name)
    dispatch(updateProfilePhotoThunk({
      studentId: String(aboutData.id),
      data: formData
    }))

  }

  return {
    fileRef,
    formRef,
    aboutData,
    toggleProfileImage,
    sendingPhoto,
    errorSendingPhoto,
    photoSentSuccessfully,
    newProfilePicture,
    setToggleProfileImage,
    sendPhoto,
    setNewProfilePicture,
    dispatch,
    handlerChange,
    handlerPictureClick,
    handlerCancel,
    handleKeyDown,
    sendNewProfilePicture,
    validationErrors
  }
}
export default useUploadProfilePhotoHook