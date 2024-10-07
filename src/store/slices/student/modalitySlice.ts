import { createSlice } from '@reduxjs/toolkit'
import { TModality } from '../../../interfaces/interfaces'
import { modalityThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'

const modality: TModality[] = []

const modalitySlice = createSlice({
    name: 'modalitySlice',
    initialState: {
        isLoadingModality: false,
        isErrorModality: false,
        modality,
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(modalityThunk.pending, (state) => {
            state.isLoadingModality = true
            state.isErrorModality = false
        })
        builder.addCase(modalityThunk.fulfilled, (state, action) => {
            state.isLoadingModality = false
            state.isErrorModality = false
            state.modality = action.payload.modality
        })
        builder.addCase(modalityThunk.rejected, (state) => {
            state.isLoadingModality = false
            state.isErrorModality = true
        })
    },
})

export default modalitySlice.reducer
