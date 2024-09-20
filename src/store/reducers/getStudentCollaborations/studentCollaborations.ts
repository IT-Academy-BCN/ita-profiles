/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";
import getStudenCollaborations from "./studentCollaborationsThunk";


const studentCollaborations = createSlice({
    name: "studentCollaborationsSlice",
    initialState: {
        isLoadindCollaborations: false,
        isErrorCollaborations: false,
        collaborationsData: {}
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudenCollaborations.pending, (state) => {
            state.isLoadindCollaborations = true
            state.isErrorCollaborations = false
        })
        builder.addCase(getStudenCollaborations.fulfilled, (state, action) => {
            state.collaborationsData = action.payload
            state.isLoadindCollaborations = false
            state.isErrorCollaborations = false
        })
        builder.addCase(getStudenCollaborations.rejected, (state) => {
            state.isLoadindCollaborations = false
            state.isErrorCollaborations = true
        })
    }
});

export default studentCollaborations.reducer;