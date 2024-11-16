import { FC } from 'react'
import useUploadProfilePhotoHook from '../../../../../../hooks/useUploadProfilePhotoHook'
import { Close } from '../../../../../../assets/svg'

const UploadProfilePhoto: FC = () => {
    const {
        aboutData,
        isLoadingPhoto,
        refInput,
        setEditProfileImageIsOpen,
        changeImage,
        notifications,
        btnDisabled,
        dispatch,
        handleCancel,
        handleAccept,
        onChangeImage,
        editProfileImageIsOpen,
    } = useUploadProfilePhotoHook()

    return (
        editProfileImageIsOpen && (
            <section className="fixed flex items-center justify-center top-0 left-0 w-full h-full z-10 bg-[rgba(0,0,0,.7)]">
                <article className="w-80 flex flex-col justify-center bg-white border border-gray-[#808080] rounded-[12px] z-10">
                    <header className="w-full flex justify-end pt-4 pr-4">
                        <button
                            aria-label="Cerrar modal imagen"
                            type="button"
                            onClick={() =>
                                dispatch(setEditProfileImageIsOpen())
                            }
                        >
                            <img
                                src={Close}
                                alt="Cerrar modal"
                                className="h-5"
                            />
                        </button>
                    </header>

                    <strong
                        className="text-xl font-bold p-4"
                        title="Tipos de imágenes soportados ( png, jpeg, jpg )."
                    >
                        Subir foto de perfil
                    </strong>

                    <label
                        htmlFor="photo"
                        title="Selecciona una imagen"
                        className="relative p-4 cursor-pointer"
                    >
                        {notifications &&
                            notifications.length > 0 &&
                            notifications.map((noti) => (
                                <small
                                    className="left-0 w-full absolute -top-6 animate-pulse text-[.7em] p-4 text-[#B91879]"
                                    key={noti.message}
                                >
                                    {noti.message}
                                </small>
                            ))}
                        <picture className="flex flex-col items-center justify-center w-full h-72 overflow-hidden rounded-xl ">
                            <img
                                src={
                                    !changeImage ? aboutData.photo : changeImage
                                }
                                alt="Avatar"
                                className={`w-full h-full bg-stone-950 text-stone-400 ${
                                    isLoadingPhoto &&
                                    'animate-pulse flex space-x-4'
                                }`}
                            />
                        </picture>
                        <input
                            ref={refInput}
                            type="file"
                            id="photo"
                            name="photo"
                            className="hidden"
                            onChange={onChangeImage}
                        />
                    </label>

                    <footer className="flex gap-4 p-4 justify-between">
                        <button
                            type="button"
                            onClick={handleCancel}
                            aria-label="Cancel upload photo"
                            className="w-1/2 h-[63px] rounded-xl font-bold border border-[rgba(128,128,128,1)]"
                        >
                            Cancelar
                        </button>
                        <button
                            disabled={btnDisabled}
                            type="button"
                            aria-label="Aceptar photo"
                            className={`w-1/2  h-[63px] rounded-xl 
            ${btnDisabled ? 'bg-stone-300 cursor-not-allowed' : 'bg-primary'} 
            font-bold text-white border border-[rgba(128,128,128,1)]`}
                            onClick={handleAccept}
                        >
                            Aceptar
                        </button>
                    </footer>
                </article>
            </section>
        )
    )
}

export default UploadProfilePhoto
