import { useContext, useEffect, useState } from 'react'
import StudentCard from './StudentCard'
import { useAppSelector } from '../../hooks/ReduxHooks'
import { TStudent } from '../../../types'
import { FetchStudentsList } from '../../api/FetchStudentsList'
import { StudentFiltersContext } from '../../context/StudentFiltersContext'

const StudentsList: React.FC = () => {
    const isPanelOpen = useAppSelector(
        (state) => state.ShowUserReducer.isUserPanelOpen,
    )

    const studentFilterContext = useContext(StudentFiltersContext)

    const [students, setStudents] = useState<TStudent[] | null>()

    useEffect(() => {
        const fetchStudents = async () => {
            const studentsList = await FetchStudentsList(studentFilterContext?.selectedRoles || []);
            setStudents(() => studentsList);
        }
        fetchStudents()
    }, [studentFilterContext?.selectedRoles])

    return (
        <div
            className={`${isPanelOpen
                ? 'md:grid-cols-[minmax(300px,450px)]'
                : 'lg:grid-cols-[minmax(300px,450px)_minmax(300px,450px)]'
                } grid gap-y-1 gap-x-6 pr-8 overflow-y-auto`}
        >
            {students ? (
                students.map((student) => (
                    <StudentCard key={student.id} {...student} />
                ))
            ) : (
                <p className="py-2">Cargando</p>
            )}
        </div>
    )
}

export default StudentsList
