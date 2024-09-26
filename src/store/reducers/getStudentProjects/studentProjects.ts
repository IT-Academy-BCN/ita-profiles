/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";
import getStudentProjectsThunk from "./studentProjectsThunk";
import { TProject } from "../../../interfaces/interfaces";

const projectsData: TProject[] = [];

const studentProjects = createSlice({
    name: "studentProjectsSlice",
    initialState: {
        isLoadingProjects: false,
        isErrorProjects: false,
        projectsData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentProjectsThunk.pending, (state) => {
            state.isLoadingProjects = true
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjectsThunk.fulfilled, (state, action) => {
            state.projectsData = action.payload
            state.isLoadingProjects = false
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjectsThunk.rejected, (state) => {
            state.isLoadingProjects = false
            state.isErrorProjects = true
        })
    }
});

export default studentProjects.reducer;
