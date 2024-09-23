/* eslint-disable no-param-reassign */

import { createSlice } from "@reduxjs/toolkit";
import { TBootcamp } from "../../../interfaces/interfaces";
import getStudentBootcamp from "./studentBootcampThunk";

const bootcampData: TBootcamp[] = [];

const studentBootcamp = createSlice({
    name: "studentBootcampsSlice",
    initialState: {
        isLoadingBootcamp: false,
        isErrorBootcamp: false,
        bootcampData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentBootcamp.pending, (state) => {
            state.isLoadingBootcamp = true
            state.isErrorBootcamp = false
        })
        builder.addCase(getStudentBootcamp.fulfilled, (state, action) => {
            state.bootcampData = action.payload.bootcamps
            state.isLoadingBootcamp = false
            state.isErrorBootcamp = false
        })
        builder.addCase(getStudentBootcamp.rejected, (state) => {
            state.isLoadingBootcamp = false
            state.isErrorBootcamp = true
        })
    }
});

export default studentBootcamp.reducer;
