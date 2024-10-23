import { useRef, useState } from "react";
import { useAppDispatch, useAppSelector } from "./ReduxHooks";
import { updateProfilePhotoThunk } from "../store/thunks/updateProfilePhotoThunk";
import { resetSendingPhoto, setToggleProfileImage } from "../store/slices/student/detailSlice";

const useUploadProfilePhotoHook = () => {
  const fileRef = useRef<HTMLInputElement | null>(null);
  const formRef = useRef<HTMLFormElement | null>(null);
  const { aboutData, toggleProfileImage } = useAppSelector(state => state.ShowStudentReducer.studentDetails)
  const { sendingPhoto, errorSendingPhoto, photoSentSuccessfully } = useAppSelector(state => state.ShowStudentReducer.studentDetails)
  const [newProfilePicture, setNewProfilePicture] = useState<string>(aboutData.photo)
  const dispatch = useAppDispatch()

  const handlerChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.files && event.target.files.length > 0) {
      const files: File[] = Array.from(event.target.files)
      setNewProfilePicture(() => URL.createObjectURL(files[0]))
    } else {
      setNewProfilePicture(aboutData.photo)
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
    setNewProfilePicture,
    dispatch,
    handlerChange,
    handlerPictureClick,
    handlerCancel,
    handleKeyDown,
    sendNewProfilePicture
  }
}
export default useUploadProfilePhotoHook