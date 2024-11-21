import { createSlice } from '@reduxjs/toolkit'
import { TInitialStateProjectsSlice } from '../../../interfaces/interfaces'
import { projectsThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'
import { updateProjectsThunk } from '../../thunks/updateProjectsThunk'
import {
    toastError,
    toastLoading,
    toastSuccess,
} from '../../../utils/toastFeedbackMessages'

export const initialState: TInitialStateProjectsSlice = {
    isLoadingProjects: false,
    isErrorProjects: false,
    projectsData: [],
    editProjectModalIsOpen: false,
    selectedProjectID: null,
    isLoadingUpdateProjects: false,
    isErrorUpdateProjects: false,
    isSuccessUpdateProjects: false,
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

        builder.addCase(updateProjectsThunk.pending, (state) => {
            state.isLoadingUpdateProjects = true
            toastLoading('El proyecto se está actualizando...')
        })

        builder.addCase(updateProjectsThunk.fulfilled, (state) => {
            state.isLoadingUpdateProjects = false
            state.isSuccessUpdateProjects = true
            toastSuccess(' El proyecto se ha actualizado correctamente')
        })

        builder.addCase(updateProjectsThunk.rejected, (state) => {
            state.isLoadingUpdateProjects = false
            state.isErrorUpdateProjects = true
            toastError('Error: El proyecto no se ha actualizado')
        })
    },
})

export const { setEditProjectModalIsOpen, setSelectedProjectID } =
    projectsSlice.actions

export default projectsSlice.reducer
