/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";

import { TCollaboration } from "../../../interfaces/interfaces";
import { getStudentCollaborationThunk } from "../../thunks/getDetailResourceStudentWithIdThunk";


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
            state.collaborationsData = action.payload.collaborations
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