import { createAsyncThunk } from '@reduxjs/toolkit'
import api, { resumes } from '../../api/api'
import { TStudentFormData } from '../../../types'

const bootcampThunk = createAsyncThunk(
    'bootcampThunk',
    async (studentId: string | null) => {
        const response = await api.get(`//localhost:8000/api/v1/student/${studentId}/resume/${resumes.bootcamp}`)
        return response
    },
)
const collaborationThunk = createAsyncThunk(
    'collaborationThunk',
    async (studentId: string | null) => {
        const response = await api.get(`//localhost:8000/api/v1/student/${studentId}/resume/${resumes.collaborations}`)
        return response
    },
)
const detailThunk = createAsyncThunk(
    'detailThunk',
    async (studentID: string | null) => {
        try {
            const response = await api.get(`//localhost:8000/api/v1/student/${studentID}/resume/${resumes.detail}`)
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    },
)

const updateDetailThunk = createAsyncThunk
    ('updateDetailThunk', async ({ url, formData }: { url: string, formData: FormData | TStudentFormData }) => {
        try {
            const response = await api.update(url, formData)
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    })

const languagesThunk = createAsyncThunk(
    'languagesThunk',
    async (studentID: string | null) => {
        const response = await api.get(`//localhost:8000/api/v1/student/${studentID}/resume/${resumes.languages}`)
        return response
    },
)
const modalityThunk = createAsyncThunk(
    'modalityThunk',
    async (studenSUID: string | null) => {
        const response = await api.get(`//localhost:8000/api/v1/student/${studenSUID}/resume/${resumes.modality}`)
        return response
    },
)
const projectsThunk = createAsyncThunk(
    'projectsThunk',
    async (studenSUID: string | null) => {
        const response = await api.get(`//localhost:8000/api/v1/student/${studenSUID}/resume/${resumes.projects}`)
        return response
    },
)
const additionalTrainingThunk = createAsyncThunk(
    'additionalTrainingThunk',
    async (studentID: string | null) => {
        try {
            const response = await api.get(`//localhost:8000/api/v1/student/${studentID}/resume/${resumes.additionaltraining}`)
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
