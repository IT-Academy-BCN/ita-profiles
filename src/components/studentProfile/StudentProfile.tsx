import React from 'react';
import { Link } from 'react-router-dom';
import StudentProfileDetail from './StudentProfileDetail';
import CompletedSteps from './CompletedSteps';
import MenuNavbar from '../menuNavbar/MenuNavbar';
import UserNavbar from '../userNavBar/UserNavbar';



const StudentProfile: React.FC = () => (
  

  <div className="flex">
    <MenuNavbar />
    <div className="flex w-full md:w-[calc(100%-176px)] flex-col p-2.5 md:p-2 md:pb-8 md:pr-14">
      <UserNavbar />
      <div className="flex h-[90vh] w-full justify-between items-center rounded-xl bg-white px-28 pt-20 mt-3">
        <CompletedSteps />
        <StudentProfileDetail />
      </div>
      <Link to="/">
        <p className='absolute bottom-10 left-10'>Back to Home</p>
      </Link>

      
    </div>
  </div>
);

export default StudentProfile;