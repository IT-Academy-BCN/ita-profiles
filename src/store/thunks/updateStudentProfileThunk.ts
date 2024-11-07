import { createAsyncThunk } from '@reduxjs/toolkit'
import { updateEndpointWithAxiosPut } from '../../api/student/updateEndpointWithAxiosPut'

export const updateCollaborationsThunk = createAsyncThunk<string, { url: string; formData: object }>('updateDetailThunk', async ({ url, formData }) => {
    try {
        const response = await updateEndpointWithAxiosPut({
            url,
            formData,
        })
        return response
    } catch (error) {
        const MyError = error as ErrorEvent
        throw new Error(MyError.message)
    }
})