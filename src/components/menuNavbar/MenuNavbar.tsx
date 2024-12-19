import { Link } from 'react-router-dom'
import { useState } from 'react'
import { ItAcademyLogo } from '../../assets/svg'
import { Button } from '../atoms/Button'

const MenuNavbar = () => {
  const [activeItem, setActiveItem] = useState('Perfiles')
  const menuItems = [
    'Perfiles',
    'Matching',
    'Proyectos',
    'Estadísticas',
    'Guías útiles',
  ]

  return (
    <nav className="hidden gap-28 w-44 flex-none px-6 py-7 md:flex md:flex-col">
        <div>
          <Link to='/'>
            <img src={ItAcademyLogo} alt="itAcademy Logo" />
          </Link>
        </div>
        <div className="flex flex-col gap-9">
          {menuItems.map((item) => (
            <Button
              key={item}
              onClick={() => setActiveItem(item)}
              defaultButton={false}
              className={`flex items-center 
                ${activeItem === item ? 'text-black-2' : 'text-gray-3'}`
              }
            >
              {activeItem === item && (
                <div className="mr-2 h-2 w-2 rounded-full bg-primary" />
              )}
              <p
                className={`font-poppins text-left text-sm font-semibold leading-4 tracking-tight
                  ${activeItem === item ? 'text-black-2' : 'text-gray-3'}`
                }
              >
                {item}
              </p>
            </Button>
          ))}
        </div>
      </nav>
    )
  }

export default MenuNavbar
