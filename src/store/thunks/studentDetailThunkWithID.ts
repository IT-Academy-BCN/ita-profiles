import { createAsyncThunk } from '@reduxjs/toolkit'
import { getDetailResourceStudentWithId } from '../../api/student/getResourceStudentWithId'

const getStudentBootcampThunk = createAsyncThunk(
    'getStudentBootcampThunk',
    async (studentId: string | null) => {
        const response = await getDetailResourceStudentWithId(
            studentId,
            'bootcamp',
        )
        return response
    },
)

const getStudentCollaborationThunk = createAsyncThunk(
    'getStudentCollaborationThunk',
    async (studentId: string | null) => {
        const response = await getDetailResourceStudentWithId(
            studentId,
            'collaborations',
        )
        return response
    },
)

const getStudentDetailThunk = createAsyncThunk(
    'getStudentDetailThunk',
    async (studentID: string | null) => {
        try {
            const response = await getDetailResourceStudentWithId(
                studentID,
                'detail',
            )
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    },
)

const getStudentLanguagesThunk = createAsyncThunk(
    'getStudentLanguagesThunk',
    async (studentID: string | null) => {
        const response = await getDetailResourceStudentWithId(
            studentID,
            'languages',
        )
        return response
    },
)

const getStudentModalityThunk = createAsyncThunk(
    'getStudentModalityThunk',
    async (studenSUID: string | null) => {
        const response = await getDetailResourceStudentWithId(
            studenSUID,
            'modality',
        )
        return response
    },
)

const getStudentProjectsThunk = createAsyncThunk(
    'getStudentProjectsThunk',
    async (studenSUID: string | null) => {
        const response = await getDetailResourceStudentWithId(
            studenSUID,
            'projects',
        )
        return response
    },
)

const getStudentAdditionalTrainingThunk = createAsyncThunk(
    'getStudentAdditionalTrainingThunk',
    async (studentID: string | null) => {
        try {
            const response = await getDetailResourceStudentWithId(
                studentID,
                'additionaltraining',
            )
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    },
)

export {
    getStudentBootcampThunk,
    getStudentCollaborationThunk,
    getStudentDetailThunk,
    getStudentLanguagesThunk,
    getStudentModalityThunk,
    getStudentProjectsThunk,
    getStudentAdditionalTrainingThunk,
}
