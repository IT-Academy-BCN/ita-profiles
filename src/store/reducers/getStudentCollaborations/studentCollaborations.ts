/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";
import getStudentCollaborationThunk from "./studentCollaborationsThunk";
import { TCollaboration } from "../../../interfaces/interfaces";


const studentCollaborations = createSlice({
    name: "studentCollaborationsSlice",
    initialState: {
        isLoadingCollaborations: false,
        isErrorCollaborations: false,
        collaborationsData: <TCollaboration[]>[]
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentCollaborationThunk.pending, (state) => {
            state.isLoadingCollaborations = true
            state.isErrorCollaborations = false
        })
        builder.addCase(getStudentCollaborationThunk.fulfilled, (state, action) => {
            state.collaborationsData = action.payload
            state.isLoadingCollaborations = false
            state.isErrorCollaborations = false
        })
        builder.addCase(getStudentCollaborationThunk.rejected, (state) => {
            state.isLoadingCollaborations = false
            state.isErrorCollaborations = true
        })
    }
});

export default studentCollaborations.reducer;