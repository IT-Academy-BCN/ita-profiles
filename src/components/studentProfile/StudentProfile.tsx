import React from 'react';
import StudentProfileDetail from './StudentProfileDetail';
import CompletionPercentage from './CompletionPercentage';
import CompletedSteps from './CompletedSteps';


const StudentProfile: React.FC = () => (
  <>
    <StudentProfileDetail />
    <CompletionPercentage completion={0} />
    <CompletedSteps />
    <button type="button" className="border-2">
      Volver
    </button>
  </>
);

export default StudentProfile;