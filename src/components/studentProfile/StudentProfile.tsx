import React from 'react';
import StudentProfileDetail from './StudentProfileDetail';
import CompletedSteps from './CompletedSteps';


interface StudentProfileProps {
  onBack: () => void;
}

const StudentProfile: React.FC<StudentProfileProps> = ({ onBack }) => (
  <>
    <div className='flex'>
      <div className="flex flex-col gap-6">
        <CompletedSteps />
      </div>
      <div className="justify-end">
        <StudentProfileDetail />
      </div>
    </div>
    <button type="button" onClick={onBack} className='absolute right-20 top-20'>
      Back to List
    </button>
  </>




);

export default StudentProfile;