import { FC } from "react"
import useUploadProfilePhotoHook from "../../../../../../hooks/useUploadProfilePhotoHook";
import { ModalPortals } from "../../../../../ModalPortals";
import { Close } from "../../../../../../assets/svg";

const UploadProfilePhoto: FC = () => {

  const {
    aboutData,
    formRef,
    fileRef,
    newProfilePicture,
    sendingPhoto,
    errorSendingPhoto,
    photoSentSuccessfully,
    toggleProfileImage,
    dispatch,
    handlerCancel,
    handlerChange,
    setToggleProfileImage,
    handleKeyDown,
    sendNewProfilePicture,
    handlerPictureClick
  } = useUploadProfilePhotoHook();

  return <ModalPortals>
    {toggleProfileImage && (
      <section className="fixed flex items-center justify-center top-0 left-0 w-full h-full z-10 bg-[rgba(0,0,0,.3)]">
        <article className="w-80 flex flex-col justify-center bg-white border border-gray-[#808080] rounded-[12px] z-10">
          <header className='w-full flex justify-end pt-4 pr-4'>
            <button type="button" onClick={() => dispatch(setToggleProfileImage(false))} title="Cerrar popup">
              <img src={Close} alt="Cerrar modal" className="h-5" />
            </button>
          </header>
          <strong className='text-xl font-bold p-4'>Subir foto de perfil</strong>
          <form ref={formRef} name="newProfilePicture" id="newProfilePicture" onSubmit={sendNewProfilePicture} >
            <div role="button" aria-label="profilepicture" tabIndex={0} onClick={handlerPictureClick} onKeyDown={handleKeyDown} className="cursor-pointer block p-4" >
              <figure className='bg-stone-800  overflow-hidden'>
                {sendingPhoto && !photoSentSuccessfully && <img className='text-white object-cover w-full h-[291px] animationSendingPhoto' src={newProfilePicture} alt="Send profile" />}
                {photoSentSuccessfully && newProfilePicture && <img className='text-white object-cover w-full h-[291px]' src={newProfilePicture} alt="Student profile" />}
                {!sendingPhoto && <img className='text-white object-cover w-full h-[291px]' src={errorSendingPhoto ? '' : newProfilePicture} alt={`${errorSendingPhoto ? 'Error upload' : 'Student profile'}`} />}
                {!sendingPhoto && !newProfilePicture && <img className='text-white object-cover w-full h-[291px]' src={aboutData.photo} alt="Student profile" />}
              </figure>
              <label htmlFor="photo" className="hidden" >
                Subir foto
                <input ref={fileRef} className="hidden" id="photo" type="file" name="photo" onChange={handlerChange} />
              </label>
            </div>
            <footer className='flex gap-4 p-4 justify-between'>
              <button type="button" onClick={handlerCancel} className="w-1/2 h-[63px] rounded-xl font-bold border border-[rgba(128,128,128,1)]">Cancel</button>
              <button type="submit" className="w-1/2  h-[63px] rounded-xl bg-primary font-bold text-white border border-[rgba(128,128,128,1)]">
                Aceptar
              </button>
            </footer>
          </form>
        </article>
      </section>
    )}
  </ModalPortals>
}

export default UploadProfilePhoto
