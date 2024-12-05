import { createSlice } from '@reduxjs/toolkit'
import { TProject } from '../../../../types'
import { projectsThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'

const projectsData: TProject[] = []

const projectsSlice = createSlice({
    name: 'projectsSlice',
    initialState: {
        isLoadingProjects: false,
        isErrorProjects: false,
        projectsData,
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(projectsThunk.pending, (state) => {
            state.isLoadingProjects = true
            state.isErrorProjects = false
        })
        builder.addCase(projectsThunk.fulfilled, (state, action) => {
            state.projectsData = action.payload.projects
            state.isLoadingProjects = false
            state.isErrorProjects = false
        })
        builder.addCase(projectsThunk.rejected, (state) => {
            state.isLoadingProjects = false
            state.isErrorProjects = true
        })
    },
})

export default projectsSlice.reducer
