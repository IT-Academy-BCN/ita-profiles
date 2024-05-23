import { useState } from 'react'
import MenuNavbar from '../menuNavbar/MenuNavbar'
import UserNavbar from '../userNavBar/UserNavbar'
import StudentDetailsLayout from '../studentDetail/StudentDetailsLayout'
import StudentsLayout from '../students/StudentsLayout'
import StudentFiltersLayout from '../studentFilters/StudentFiltersLayout'
import { StudentFiltersProvider } from '../../context/StudentFiltersContext'
import StudentProfile from '../studentProfile/StudentProfile';


const Landing: React.FC = () => {
  

  const [viewProfile, setViewProfile] = useState(false); // Quitar

  // Quitar de fila 15 a 26(botón auxiliar para ver perfil)
  const handleViewProfile = () => {
    setViewProfile(true);
  };

  const handleBackToList = () => {
    setViewProfile(false);
  };

  if (viewProfile) {
    return <StudentProfile onBack={handleBackToList} />;
  }

return (
  <div className="flex h-screen">
    <MenuNavbar data-testid="MenuNavbar" /> {/* Added data-testid */}
    <div className="flex w-full md:w-[calc(100%-176px)] flex-col gap-3 p-2.5 md:p-2 md:pb-8 md:pr-14">
      <UserNavbar data-testid="UserNavbar" /> {/* Added data-testid */}
      <StudentFiltersProvider>
        <div className="flex h-[90vh] gap-10">
          <div className="flex flex-1 w-auto h-full rounded-xl bg-white p-10">
            <StudentFiltersLayout data-testid="StudentFiltersLayout" />{' '}
            {/* Added data-testid */}
            <StudentsLayout data-testid="StudentLayout" />{' '}
            {/* Added data-testid */}
          </div>
          <StudentDetailsLayout data-testid="StudentDetailsLayout" />{' '}
          {/* Added data-testid */}
        </div>
      </StudentFiltersProvider>
    </div>
    {/* Quitar de fila 43 a 45(botón auxiliar para ver perfil) */}
    <button type='button' onClick={handleViewProfile}>
        View Profile
      </button>
  </div>
)
}

export default Landing
