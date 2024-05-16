import { useState } from 'react'
import { Lock, ArrowDown, BurgerMenu } from '../../assets/svg'
import LoginPopup from '../login_&_register/LoginPopup'
import RegisterPopup from '../login_&_register/RegisterPopup'

const UserNavbar: React.FC = () => {
  const [isRestrictedPopupOpen, setIsRestrictedPopupOpen] = useState(false)
  const [isRegisterPopupOpen, setIsRegisterPopupOpen] = useState(false)
  const [isLoginPopupOpen, setIsLoginPopupOpen] = useState(false)

  const handleOpenRestrictedPopup = () => {
    setIsRestrictedPopupOpen(true)
  }

  const handleCloseRestrictedPopup = () => {
    setIsRestrictedPopupOpen(false)
  }

  const handleOpenRegisterPopup = () => {
    setIsRegisterPopupOpen(true)
    setIsRestrictedPopupOpen(false)
  }

  const handleCloseRegisterPopup = () => {
    setIsRegisterPopupOpen(false)
  }

  const handleOpenLoginPopup = () => {
    setIsLoginPopupOpen(true)
    setIsRegisterPopupOpen(false)
  }

  const handleCloseLoginPopup = () => {
    setIsLoginPopupOpen(false)
  }

  return (
    <div className="flex w-full items-center justify-between md:justify-end">
      <div className="md:hidden">
        <img
          src={BurgerMenu}
          alt="burger menu"
          className="w-8 cursor-pointer"
        />
      </div>
      <div className="flex cursor-pointer items-center gap-4">
        <div className="p-.5 dropdown relative rounded-lg  bg-white px-3 py-2 font-medium">
          <div
            tabIndex={0}
            role="button"
            className="flex items-center gap-1 text-gray"
          >
            ES
            <img src={ArrowDown} alt="Vector" />
          </div>
          <ul className="menu dropdown-content absolute left-0 top-12 z-[1] rounded-lg bg-base-100 shadow">
            <li className="text-gray">Español</li>
            <li className="text-gray">English</li>
          </ul>
        </div>
        <button
          type="button"
          className="rounded-lg bg-white px-3 py-2 font-medium text-gray"
          onClick={handleOpenRestrictedPopup}
        >
          Login/registro
        </button>
      </div>

      {isRestrictedPopupOpen && (
        <div className="fixed left-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black bg-opacity-50">
          <div className="relative flex w-72 flex-col items-center rounded-lg bg-white p-4">
            <button
              type="button"
              className="absolute right-2 top-2 h-8 w-8 cursor-pointer rounded-lg border-none bg-transparent"
              onClick={handleCloseRestrictedPopup}
            >
              ✕
            </button>
            <img src={Lock} alt="Lock" className="mb-4 h-24 w-24" />
            <h2 className="mb-2 text-lg font-bold">Acceso restringido</h2>
            <p className="mb-6 ">Entra o regístrate para acceder al perfil</p>
            <div className="w-full">
              <button
                type="button"
                className="mb-2 h-12 w-full rounded-lg bg-primary text-lg text-white"
                onClick={handleOpenRegisterPopup}
              >
                Soy candidato/a
              </button>
              <button
                type="button"
                className="h-12 w-full rounded-lg bg-primary text-lg text-white"
                onClick={handleOpenLoginPopup}
              >
                ¿Tienes cuenta?
              </button>
            </div>
          </div>
        </div>
      )}
      {isRegisterPopupOpen && (
        <div className="fixed left-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black bg-opacity-50">
          <RegisterPopup
            onClose={handleCloseRegisterPopup}
            onOpenLoginPopup={handleOpenLoginPopup}
          />
        </div>
      )}
      {isLoginPopupOpen && (
        <div className="fixed left-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black bg-opacity-50">
          {isLoginPopupOpen && <LoginPopup onClose={handleCloseLoginPopup} />}
        </div>
      )}
    </div>
  )
}

export default UserNavbar
