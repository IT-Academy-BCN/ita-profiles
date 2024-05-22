import React from 'react';
import StudentProfileDetail from './StudentProfileDetail';
import CompletionPercentage from './CompletionPercentage';
import CompletedSteps from './CompletedSteps';

interface StudentProfileProps {
  handleBack: () => void; // Propiedad para la función de regresar
}

const StudentProfile: React.FC<StudentProfileProps> = ({ handleBack }) => (
  <>
    <StudentProfileDetail />
    <CompletionPercentage />
    <CompletedSteps />
    <button type="button" className="border-2" onClick={handleBack}>
      Volver
    </button>
  </>
);

export default StudentProfile;