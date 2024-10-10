import { useContext, useEffect, useState } from 'react'
import { TSmallScreenContext } from '../interfaces/interfaces'
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
        if (typeof role === 'string' && role === 'user') {
            studentDetails.forEach((student) => {
                dispatch(student(studentID))
            })
        } else if (!role && studentUUID) {
            studentDetails.forEach((student) => {
                dispatch(student(studentUUID))
            })
        }
    }, [dispatch, role, studentDetails, studentID, studentUUID])

    return { isMobile }
}

export { useStudentDetailHook }
