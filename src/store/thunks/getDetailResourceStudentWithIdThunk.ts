import { createAsyncThunk } from '@reduxjs/toolkit'
import {
    getStudentDetailWithId,
    resumes,
} from '../../api/student/getStudentDetailWithId'
import { callUpdateStudent } from '../../api/student/callUpdateStudent'

const bootcampThunk = createAsyncThunk(
    'bootcampThunk',
    async (studentId: string | null) => {
        const response = await getStudentDetailWithId(
            studentId,
            resumes.bootcamp,
        )
        return response
    },
)
const collaborationThunk = createAsyncThunk(
    'collaborationThunk',
    async (studentId: string | null) => {
        const response = await getStudentDetailWithId(
            studentId,
            resumes.collaborations,
        )
        return response
    },
)
const detailThunk = createAsyncThunk(
    'detailThunk',
    async (studentID: string | null) => {
        try {
            const response = await getStudentDetailWithId(
                studentID,
                resumes.detail,
            )
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    },
)

const updateDetailThunk = createAsyncThunk<
    string,
    { url: string; formData: object }
>('updateDetailThunk', async ({ url, formData }) => {
    try {
        const response = await callUpdateStudent({
            url,
            formData,
        })
        return response
    } catch (error) {
        const MyError = error as ErrorEvent
        throw new Error(MyError.message)
    }
})

const languagesThunk = createAsyncThunk(
    'languagesThunk',
    async (studentID: string | null) => {
        const response = await getStudentDetailWithId(
            studentID,
            resumes.languages,
        )
        return response
    },
)
const modalityThunk = createAsyncThunk(
    'modalityThunk',
    async (studenSUID: string | null) => {
        const response = await getStudentDetailWithId(
            studenSUID,
            resumes.modality,
        )
        return response
    },
)
const projectsThunk = createAsyncThunk(
    'projectsThunk',
    async (studenSUID: string | null) => {
        const response = await getStudentDetailWithId(
            studenSUID,
            resumes.projects,
        )
        return response
    },
)
const additionalTrainingThunk = createAsyncThunk(
    'additionalTrainingThunk',
    async (studentID: string | null) => {
        try {
            const response = await getStudentDetailWithId(
                studentID,
                resumes.additionaltraining,
            )
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    },
)
export {
    bootcampThunk,
    collaborationThunk,
    detailThunk,
    languagesThunk,
    modalityThunk,
    projectsThunk,
    additionalTrainingThunk,
    updateDetailThunk,
}
