import React from 'react';
import StudentProfileDetail from './StudentProfileDetail';
import CompletedSteps from './CompletedSteps';
import MenuNavbar from '../menuNavbar/MenuNavbar';
import UserNavbar from '../userNavBar/UserNavbar';


interface StudentProfileProps {
  onBack: () => void;
}

const StudentProfile: React.FC<StudentProfileProps> = ({ onBack }) => (
  <div className="flex">
    <MenuNavbar />
    <div className="flex w-full md:w-[calc(100%-176px)] flex-col gap-3 p-2.5 md:p-2 md:pb-8 md:pr-14">
      <UserNavbar />
      <div className="flex h-[90vh] w-full justify-between items-center rounded-xl bg-white px-20 pt-20">
        <CompletedSteps />
        <StudentProfileDetail />
      </div>
      <button type="button" onClick={onBack} className='absolute left-20 top-20'>
        Back to List
      </button>
    </div>
  </div>
);

export default StudentProfile;