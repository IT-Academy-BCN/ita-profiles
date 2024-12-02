import { useContext, useEffect, useState } from 'react'
import { TSmallScreenContext } from '../../types'
import { useAppDispatch } from './ReduxHooks'
import { SmallScreenContext } from '../context/SmallScreenContext'
import { useStudentIdContext } from '../context/StudentIdContext'
import * as thunks from '../store/thunks/getDetailResourceStudentWithIdThunk'

const useStudentDetailHook = (role?: string | null) => {
    const { isMobile }: TSmallScreenContext = useContext(SmallScreenContext)
    const { studentUUID } = useStudentIdContext()
    const studentID = localStorage.getItem('studentID')
    const dispatch = useAppDispatch()

    const [studentDetails] = useState([
        thunks.detailThunk,
        thunks.projectsThunk,
        thunks.collaborationThunk,
        thunks.bootcampThunk,
        thunks.additionalTrainingThunk,
        thunks.modalityThunk,
        thunks.languagesThunk,
    ])

    useEffect(() => {
        const fetchData = async () => {
            try {
                const id = role === 'user' ? studentID : studentUUID;
                if (!id) return;

                await Promise.all(
                    studentDetails.map((thunk) => dispatch(thunk(id)))
                );
            } catch (error) {
                console.error('Error al obtener los detalles del estudiante:', error);
            }
        };

        fetchData();
    }, [dispatch, role, studentDetails, studentID, studentUUID])

    return { isMobile }
}

export { useStudentDetailHook }
