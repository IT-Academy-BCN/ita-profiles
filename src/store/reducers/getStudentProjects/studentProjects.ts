/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";
import getStudentProjects from "./studentProjectsThunk";
import { TProject } from "../../../interfaces/interfaces";

const projectsData: TProject[] = [];

const studentProjects = createSlice({
    name: "studentProjectsSlice",
    initialState: {
        isLoadindProjects: false,
        isErrorProjects: false,
        projectsData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentProjects.pending, (state) => {
            state.isLoadindProjects = true
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjects.fulfilled, (state, action) => {
            state.projectsData = action.payload
            state.isLoadindProjects = false
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjects.rejected, (state) => {
            state.isLoadindProjects = false
            state.isErrorProjects = true
        })
    }
});

export default studentProjects.reducer;
