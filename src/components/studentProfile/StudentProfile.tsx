import { Link } from 'react-router-dom';
import StudentProfileDetail from './StudentProfileDetail';
import MenuNavbar from '../menuNavbar/MenuNavbar';
import UserNavbar from '../userNavBar/UserNavbar';
import CompletedSteps from './CompletedSteps';

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
    </div>
  </div>
);

export default StudentProfile;