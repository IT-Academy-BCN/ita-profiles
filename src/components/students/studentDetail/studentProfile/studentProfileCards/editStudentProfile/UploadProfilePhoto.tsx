import { FC } from "react"

import useUploadProfilePicture from "../../../../../../hooks/useUploadProfilePhoto";
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
    } = useUploadProfilePicture();

    return <ModalPortals>
        {toggleProfileImage && (
            <section className="fixed w-80 top-14 left-1/2 -translate-x-1/2 mt-4 xl:left-1/2 xl:translate-x-72 xl:mt-4 flex flex-col justify-center bg-white border border-gray-[#808080] rounded-[12px] z-10">
                <header className='w-full flex justify-end p-2'>
                    <button type="button" onClick={() => dispatch(setToggleProfileImage(false))} title="Cerrar popup">
                        <img src={Close} alt="Cerrar modal" className="h-5" />
                    </button>
                </header>
                <strong className='text-xl font-bold p-4'>Subir foto de perfil</strong>
                <form ref={formRef} name="newProfilePicture" id="newProfilePicture" onSubmit={sendNewProfilePicture} >
                    <div role="button" aria-label="profilepicture" tabIndex={0} onClick={handlerPictureClick} onKeyDown={handleKeyDown} className="cursor-pointer block" >
                        <figure className='p-4'>
                            {sendingPhoto && !photoSentSuccessfully && <img className='object-cover w-full h-[291px] animationSendingPhoto' src={newProfilePicture} alt="Send profile" />}
                            {photoSentSuccessfully && newProfilePicture && <img className='object-cover w-full h-[291px]' src={newProfilePicture} alt="Send succes" />}
                            {!sendingPhoto && <img className='object-cover w-full h-[291px]' src={errorSendingPhoto ? '' : newProfilePicture} alt={`${errorSendingPhoto ? 'errorphoto' : 'userphoto'}`} />}
                            {!sendingPhoto && !newProfilePicture && <img className='object-cover w-full h-[291px]' src={aboutData.photo} alt="User pictures" />}
                            {/* {!sendingPhoto && !photoSentSuccessfully && !newProfilePicture && <img className='object-cover w-full h-[291px]' src={aboutData.photo} alt="User pictures" />} */}
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
            </section>
        )}
    </ModalPortals>
}

export default UploadProfilePhoto
