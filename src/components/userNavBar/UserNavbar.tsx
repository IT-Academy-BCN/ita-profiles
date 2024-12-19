import { Link } from 'react-router-dom'
import { useState } from 'react'
import { Lock, ArrowDown, BurgerMenu, Settings, UserIcon } from '../../assets/svg'
import LoginPopup from '../login_&_register/LoginPopup'
import RegisterPopup from '../login_&_register/RegisterPopup'
import { useLogin } from '../../context/LoginContext'
import Modal from '../molecules/Modal'
import { Button } from '../atoms/Button'

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
        <div className="p-.5 dropdown relative rounded-lg bg-white px-3 py-2 font-medium">
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
              <Button 
                navbar
                defaultButton={false}
                onClick={logout}
              >
                <img src={Settings} alt="Settings button" />
              </Button>
              <Link
                className="rounded-lg bg-white px-3 py-2 font-medium text-gray hover:scale-[1.02] transition duration-150 ease-in-out"
                to='/profile'
              >
                <img src={UserIcon} alt="User icon button" />
              </Link>
            </div>

          : <Button
              navbar
              defaultButton={false}
              onClick={handleButtonClick}
            >
              Login/registro
            </Button>
        }          
      </div>
      <Modal isOpen={isRestrictedPopupOpen} onClose={() => handleCloseRestrictedPopup()}>
        <div className="flex px-24 py-12 flex-col items-center rounded-lg bg-white">
          <img src={Lock} alt="Lock" className="mb-2 h-24 w-24" />
          <h2 className="mb-8 text-xl font-bold">Acceso restringido</h2>
          <p className="mb-8 ">Entra o regístrate para acceder al perfil</p>
          <div className="w-full">
          <Button onClick={handleOpenRegisterPopup}>Registrarme</Button>
          <Button defaultButton={false} outline onClick={handleOpenLoginPopup}>Entrar</Button>
          </div>
        </div>
      </Modal>
      <RegisterPopup
        isOpen={isRegisterPopupOpen}
        onClose={handleCloseRegisterPopup}
        onOpenLoginPopup={handleOpenLoginPopup}
      />
      <LoginPopup
        onClose={handleCloseLoginPopup}
        onOpenRegisterPopup={handleOpenRegisterPopup}
        user={{
          userID: '',
          token: '',
          studentID: ''
        }}
        isOpen={isLoginPopupOpen}
      />
    </div>
  )
}

export default UserNavbar
