/* eslint-disable no-param-reassign */
import { createSlice } from '@reduxjs/toolkit'
import { TBootcamp } from '../../../interfaces/interfaces'
import { bootcampThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'

const bootcampData: TBootcamp[] = []

const bootcampSlice = createSlice({
    name: 'bootcampSlice',
    initialState: {
        isLoadingBootcamp: false,
        isErrorBootcamp: false,
        bootcampData,
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(bootcampThunk.pending, (state) => {
            state.isLoadingBootcamp = true
            state.isErrorBootcamp = false
        })
        builder.addCase(bootcampThunk.fulfilled, (state, action) => {
            state.isLoadingBootcamp = false
            state.isErrorBootcamp = false
            state.bootcampData = action.payload.bootcamps
        })
        builder.addCase(bootcampThunk.rejected, (state) => {
            state.isLoadingBootcamp = false
            state.isErrorBootcamp = true
        })
    },
})

export default bootcampSlice.reducer
