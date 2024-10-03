/* eslint-disable no-param-reassign */
import { createSlice } from '@reduxjs/toolkit'
// import getStudentProjectsThunk from "./studentProjectsThunk";
import { TProject } from '../../../interfaces/interfaces'
import { getStudentProjectsThunk } from '../../thunks/studentDetailThunkWithID'

const projectsData: TProject[] = []

const studentProjectsSlice = createSlice({
    name: 'studentProjectsSlice',
    initialState: {
        isLoadingProjects: false,
        isErrorProjects: false,
        projectsData,
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentProjectsThunk.pending, (state) => {
            state.isLoadingProjects = true
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjectsThunk.fulfilled, (state, action) => {
            state.projectsData = action.payload.projects
            state.isLoadingProjects = false
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjectsThunk.rejected, (state) => {
            state.isLoadingProjects = false
            state.isErrorProjects = true
        })
    },
})

export default studentProjectsSlice.reducer
