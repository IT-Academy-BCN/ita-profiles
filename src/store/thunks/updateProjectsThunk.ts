import { createAsyncThunk } from '@reduxjs/toolkit'
import { callUpdateStudent } from '../../api/student/callUpdateStudent'

export const updateProjectsThunk = createAsyncThunk<
    string,
    { url: string; formData: object }
>('updateProjectsThunk', async ({ url, formData }) => {
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
