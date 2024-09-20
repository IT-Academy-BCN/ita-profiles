/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";
import getStudenProjects from "./studenProjectsThunk";
import { TProject } from "../../../interfaces/interfaces";

const projectsData: TProject[] = [];

const studenProjects = createSlice({
    name: "studenProjectsSlice",
    initialState: {
        isLoadindProjects: false,
        isErrorProjects: false,
        projectsData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudenProjects.pending, (state) => {
            state.isLoadindProjects = true
            state.isErrorProjects = false
        })
        builder.addCase(getStudenProjects.fulfilled, (state, action) => {
            state.projectsData = action.payload.projects
            state.isLoadindProjects = false
            state.isErrorProjects = false
        })
        builder.addCase(getStudenProjects.rejected, (state) => {
            state.isLoadindProjects = false
            state.isErrorProjects = true
        })
    }
});

export default studenProjects.reducer;