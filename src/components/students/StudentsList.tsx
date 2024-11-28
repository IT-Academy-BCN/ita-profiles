import { useContext, useEffect, useState } from 'react'
import StudentCard from './StudentCard'
import { useAppSelector } from '../../hooks/ReduxHooks'
import { IStudentList } from '../../interfaces/interfaces'
import { getStudentsList } from '../../api/getStudentsList'
import { StudentFiltersContext } from '../../context/StudentFiltersContext'

const StudentsList: React.FC = () => {
    const isPanelOpen = useAppSelector(
        (state) => state.ShowUserReducer.isUserPanelOpen,
    )

    const studentFilterContext = useContext(StudentFiltersContext)

    const [students, setStudents] = useState<IStudentList[] | null>()

    useEffect(() => {
        const fetchStudents = async () => {
            try {
                const studentsList = await getStudentsList(
                    studentFilterContext?.selectedRoles || [],
                )
                setStudents(studentsList)
            } catch (error) {
                //
            }
        }
        fetchStudents()
    }, [studentFilterContext?.selectedRoles])

    return (
        <div
            className={`${
                isPanelOpen
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
