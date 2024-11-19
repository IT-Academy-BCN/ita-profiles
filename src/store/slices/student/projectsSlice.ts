import { createSlice } from '@reduxjs/toolkit'
import { TProject } from '../../../interfaces/interfaces'
import {
    projectsThunk,
    updateProjectsThunk,
} from '../../thunks/getDetailResourceStudentWithIdThunk'

const projectsData: TProject[] = []

export const initialState = {
    isLoadingProjects: false,
    isErrorProjects: false,
    projectsData,
    editProjectModalIsOpen: false,
    selectedProjectID: '',
}

const projectsSlice = createSlice({
    name: 'projectsSlice',
    initialState,
    reducers: {
        setEditProjectModalIsOpen: (state) => {
            state.editProjectModalIsOpen = !state.editProjectModalIsOpen
        },
        setSelectedProjectID: (state, action) => {
            state.selectedProjectID = action.payload
        },
    },
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

        builder.addCase(updateProjectsThunk.pending, () => {
            console.log('pending')
        })

        builder.addCase(updateProjectsThunk.fulfilled, () => {
            console.log('actualizado')
        })
        builder.addCase(updateProjectsThunk.rejected, () => {
            console.log('rejected')
        })
    },
})

export const { setEditProjectModalIsOpen, setSelectedProjectID } =
    projectsSlice.actions

export default projectsSlice.reducer
