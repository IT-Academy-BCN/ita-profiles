import MenuNavbar from '../menuNavbar/MenuNavbar'
import UserNavbar from '../userNavBar/UserNavbar'
import StudentDetailsLayout from '../studentDetail/StudentDetailsLayout'
import StudentsLayout from '../students/StudentsLayout'
import StudentFiltersLayout from '../studentFilters/StudentFiltersLayout'
import { StudentFiltersProvider } from '../../context/StudentFiltersContext'


const Landing = () => (
  <div className="flex h-screen">
    <MenuNavbar />
    <div className="flex w-full md:w-[calc(100%-176px)] flex-col gap-3 p-2.5 md:p-2 md:pb-8 md:pr-14">
      <UserNavbar />
      <StudentFiltersProvider>
          <div className="flex h-[90vh] gap-10">
            <div className="flex flex-1 w-auto h-full rounded-xl bg-white p-10">
              <StudentFiltersLayout />
              <StudentsLayout />
            </div>
            <StudentDetailsLayout />
          </div>
      </StudentFiltersProvider>
    </div>
  </div>
);

export default Landing;
