import { createAsyncThunk } from '@reduxjs/toolkit'
import api, { resumes } from '../../api/api'

const bootcampThunk = createAsyncThunk(
    'bootcampThunk',
    async (studentId: string | null) => {
        const response = await api.get(`/student/${studentId}/resume/${resumes.bootcamp}`)
        return response
    },
)
const collaborationThunk = createAsyncThunk(
    'collaborationThunk',
    async (studentId: string | null) => {
        const response = await api.get(`/student/${studentId}/resume/${resumes.collaborations}`)
        return response
    },
)
const detailThunk = createAsyncThunk(
    'detailThunk',
    async (studentID: string | null) => {
        try {
            const response = await api.get(`/student/${studentID}/resume/${resumes.detail}`)
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    },
)

const updateDetailThunk = createAsyncThunk<string, { url: string; formData: object }>
    ('updateDetailThunk', async ({ url, formData }) => {
        try {
            const response = await api.update(url, formData as FormData)
            return response
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    })

const languagesThunk = createAsyncThunk(
    'languagesThunk',
    async (studentID: string | null) => {
        const response = await api.get(`/student/${studentID}/resume/${resumes.languages}`)
        return response
    },
)
const modalityThunk = createAsyncThunk(
    'modalityThunk',
    async (studenSUID: string | null) => {
        const response = await api.get(`/student/${studenSUID}/resume/${resumes.modality}`)
        return response
    },
)
const projectsThunk = createAsyncThunk(
    'projectsThunk',
    async (studenSUID: string | null) => {
        const response = await api.get(`/student/${studenSUID}/resume/${resumes.projects}`)
        return response
    },
)
const additionalTrainingThunk = createAsyncThunk(
    'additionalTrainingThunk',
    async (studentID: string | null) => {
        try {
            const response = await api.get(`/student/${studentID}/resume/${resumes.additionaltraining}`)
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
