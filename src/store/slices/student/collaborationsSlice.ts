import { createSlice } from '@reduxjs/toolkit'
import { TCollaboration } from '../../../../types'
import { collaborationThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'

const collaborationsSlice = createSlice({
    name: 'collaborationsSlice',
    initialState: {
        isLoadingCollaborations: false,
        isErrorCollaborations: false,
        collaborationsData: <TCollaboration[]>[],
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(collaborationThunk.pending, (state) => {
            state.isLoadingCollaborations = true
            state.isErrorCollaborations = false
        })
        builder.addCase(
            collaborationThunk.fulfilled,
            (state, action) => {
                state.collaborationsData = action.payload.collaborations
                state.isLoadingCollaborations = false
                state.isErrorCollaborations = false
            },
        )
        builder.addCase(collaborationThunk.rejected, (state) => {
            state.isLoadingCollaborations = false
            state.isErrorCollaborations = true
        })
    },
})

export default collaborationsSlice.reducer
