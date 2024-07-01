import { useContext, useState } from 'react'
import { ItAcademyLogo } from '../../assets/svg'
import { useLogin } from '../../context/LoginContext'


const MenuNavbar = () => {
  const [activeItem, setActiveItem] = useState('Perfiles')
  const { isLoggedIn } = useLogin()
  const menuItems = isLoggedIn
    ? ['Mi Perfil', 'Matching', 'Proyectos', 'Estadísticas', 'Guías útiles']
    : ['Perfiles', 'Matching', 'Proyectos', 'Estadísticas', 'Guías útiles'];

    return (
      <nav className="hidden gap-28 w-44 flex-none px-6 py-7 md:flex md:flex-col">
        <div>
          <img src={ItAcademyLogo} alt="itAcademy Logo" />
        </div>
        <div className="flex flex-col gap-9">
          {menuItems.map((item) => (
            <button
              type="button"
              key={item}
              className={`flex items-center ${
                
                isLoggedIn ? 'text-black-2' : 'text-gray-3'
              }`}
            >
              
              {isLoggedIn && (
                <div className="mr-2 h-2 w-2 rounded-full bg-primary" />
              )}
              <p
                className={`font-poppins text-left text-sm font-semibold leading-4 tracking-tight ${
                  isLoggedIn ? 'text-black-2' : 'text-gray-3'
                }`}
              >
                {item}
              </p>
            </button>
          ))}
        </div>
      </nav>
    );
  };
export default MenuNavbar
