/* eslint-disable no-param-reassign */
import { createSlice } from '@reduxjs/toolkit'
import { TModality } from '../../../interfaces/interfaces'
import { getStudentModalityThunk } from '../../thunks/studentDetailThunkWithID'
// import getStudentModalityThunk from "./studentModalityThunk";

const modality: TModality[] = []

const studentModalitySlice = createSlice({
    name: 'studentModalitySlice',
    initialState: {
        isLoadingModality: false,
        isErrorModality: false,
        modality,
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentModalityThunk.pending, (state) => {
            state.isLoadingModality = true
            state.isErrorModality = false
        })
        builder.addCase(getStudentModalityThunk.fulfilled, (state, action) => {
            state.isLoadingModality = false
            state.isErrorModality = false
            state.modality = action.payload.modality
        })
        builder.addCase(getStudentModalityThunk.rejected, (state) => {
            state.isLoadingModality = false
            state.isErrorModality = true
        })
    },
})

export default studentModalitySlice.reducer
