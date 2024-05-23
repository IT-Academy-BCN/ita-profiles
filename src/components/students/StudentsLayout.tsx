import React, { useState } from 'react';
import StudentsList from './StudentsList';
import StudentsFiltersModal from '../studentFilters/StudentFiltersModal';
import StudentProfile from '../studentProfile/StudentProfile';

const StudentsLayout: React.FC = () => {
  const [openModal, setOpenModal] = useState(false);
  const [viewProfile, setViewProfile] = useState(false); // Quitar

  const handleOpenModal = () => {
    setOpenModal(!openModal);
  };

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
    <div className="flex flex-col w-full gap-20">
      <div className="flex justify-between">
        <h3 className="pl-5 text-2xl font-bold text-black-3">Alumn@s</h3>
        {/* Filter button only seen in small screens */}
        <button
          type="button"
          className="border-gray-400 hover:bg-gray-100 rounded-lg border px-4 py-1 font-semibold md:hidden"
          onClick={handleOpenModal}
        >
          Filtrar
        </button>
      </div>
      <StudentsList />
      {openModal && <StudentsFiltersModal handleOpenModal={handleOpenModal} />}
      {/* Quitar de fila 43 a 45(botón auxiliar para ver perfil) */}
      <button type='button' onClick={handleViewProfile}>
        View Profile
      </button>
    </div>
  );
};

export default StudentsLayout;