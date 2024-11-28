import { Link } from 'react-router-dom'
import { useState } from 'react'
import { Lock, ArrowDown, BurgerMenu, Settings, UserIcon } from '../../assets/icons'
import LoginPopup from './Login'
import RegisterPopup from './RegisterPopup'
import { useLogin } from '../../context/LoginContext'

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
    setIsLoginPopupOpen(false)
    setIsRestrictedPopupOpen(false)
  }

  const handleCloseRegisterPopup = () => {
    setIsRegisterPopupOpen(false)
  }

  const handleOpenLoginPopup = () => {
    setIsLoginPopupOpen(true)
    setIsRegisterPopupOpen(false)
    setIsRestrictedPopupOpen(false)
  }

  const handleCloseLoginPopup = () => {
    setIsLoginPopupOpen(false)
  }

  const { isLoggedIn, logout } = useLogin();
  const handleButtonClick = () => {
    if (isLoggedIn) {
      logout();
    } else {
      handleOpenRestrictedPopup();
    }
  };

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
            className="flex items-center gap-1 text-gray-3"
          >
            ES
            <img src={ArrowDown} alt="Vector" />
          </div>
          <ul className="menu dropdown-content absolute left-0 top-12 z-[1] rounded-lg bg-base-100 shadow gap-2 p-4">
            <li className="text-gray-3">Español</li>
            <li className="text-gray-3">English</li>
          </ul>
        </div>
        {isLoggedIn
          ? <div className='flex gap-4'>
            <button
              type='button'
              className="rounded-lg bg-white px-3 py-2 font-medium text-gray"
              onClick={logout}
            >
              <img src={Settings} alt="Settings button" />
            </button>
            <Link
              className="rounded-lg bg-white px-3 py-2 font-medium text-gray"
              to='/profile'
            >
              <img src={UserIcon} alt="User icon button" />
            </Link>
          </div>

          : <button
            type="button"
            className="rounded-lg bg-white px-3 py-2 font-medium text-gray-3"
            onClick={handleButtonClick}
          >
            Login/registro
          </button>}
      </div>

      {isRestrictedPopupOpen && (
        <div className="fixed left-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black bg-opacity-50">
          <div className="relative flex px-24 py-12 flex-col items-center rounded-lg bg-white">
            <button
              type="button"
              className="absolute right-2 top-2 h-8 w-8 cursor-pointer rounded-lg border-none bg-transparent"
              onClick={handleCloseRestrictedPopup}
            >
              ✕
            </button>
            <img src={Lock} alt="Lock" className="mb-2 h-24 w-24" />
            <h2 className="mb-8 text-xl font-bold">Acceso restringido</h2>
            <p className="mb-8 ">Entra o regístrate para acceder al perfil</p>
            <div className="w-full">
              <button
                type="button"
                className="mb-3 h-12 w-full rounded-lg bg-primary font-bold text-white"
                onClick={handleOpenRegisterPopup}>
                Quiero registrarme
              </button>
              <button
                type="button"
                className="mb-4 h-12 w-full rounded-lg bg-primary font-bold text-white"
                onClick={handleOpenLoginPopup}>
                Ya tengo cuenta
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
          <LoginPopup
            onClose={handleCloseLoginPopup}
            onOpenRegisterPopup={handleOpenRegisterPopup}
            user={{
              userID: '',
              token: '',
              studentID: ''
            }}
          />
        </div>
      )}
    </div>
  )
}

export default UserNavbar
