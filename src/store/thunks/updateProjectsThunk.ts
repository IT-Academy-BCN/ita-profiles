import { createAsyncThunk } from '@reduxjs/toolkit'
import { callUpdateStudent } from '../../api/student/callUpdateStudent'

export const updateProjectsThunk = createAsyncThunk<
    string,
    { url: string; formData: object; options: object }
>('updateProjectsThunk', async (data) => {
    try {
        const response = await callUpdateStudent(data)
        return response
    } catch (error) {
        const MyError = error as ErrorEvent
        throw new Error(MyError.message)
    }
})
