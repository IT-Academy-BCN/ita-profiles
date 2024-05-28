<<<<<<< HEAD
=======
import React, { useContext } from 'react';
>>>>>>> 9bd4db5b3c994a28efe334f62f98f1a0065c73f2
import { Link } from 'react-router-dom';
import MenuNavbar from '../menuNavbar/MenuNavbar';
import UserNavbar from '../userNavBar/UserNavbar';
import StudentProfileDetail from './StudentProfileDetail';
import CompletedSteps from './CompletedSteps';
import { StudentContext } from '../../context/StudentContext';

<<<<<<< HEAD
const StudentProfile: React.FC = () => (
  <div className="flex">
    <MenuNavbar />
    <div className="flex w-full md:w-[calc(100%-176px)] flex-col p-2.5 md:p-2 md:pb-8 md:pr-14">
      <UserNavbar />
      <div className="flex flex-col xl:h-[90vh] h-full xl:flex-row w-full justify-between items-center rounded-xl bg-white mt-3 pt-20 xl:px-28">
        <CompletedSteps />
        <StudentProfileDetail />
      </div>
      <Link to="/">
        <p className='absolute bottom-10 left-10'>Back to Home</p>
      </Link>      
=======
const StudentProfile: React.FC = () => {
  const { studentData } = useContext(StudentContext);

  if (!studentData) {
    return <div>Loading...</div>;
  }

  return (
    <div className="flex">
      <MenuNavbar />
      <div className="flex w-full md:w-[calc(100%-176px)] flex-col p-2.5 md:p-2 md:pb-8 md:pr-14">
        <UserNavbar />
        <div className="flex h-[90vh] w-full justify-between items-center rounded-xl bg-white px-28 pt-20 mt-3">
          <CompletedSteps/> 
          <StudentProfileDetail />
        </div>
        <Link to="/">
          <p className='absolute bottom-10 left-10'>Back to Home</p>
        </Link>
      </div>
>>>>>>> 9bd4db5b3c994a28efe334f62f98f1a0065c73f2
    </div>
  );
};

export default StudentProfile;
