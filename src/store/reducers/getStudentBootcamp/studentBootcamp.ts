/* eslint-disable no-param-reassign */

import { createSlice } from "@reduxjs/toolkit";
import { TBootcamp } from "../../../interfaces/interfaces";
import getStudentBootcampThunk from "./studentBootcampThunk";

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
        builder.addCase(getStudentBootcampThunk.pending, (state) => {
            state.isLoadingBootcamp = true
            state.isErrorBootcamp = false
        })
        builder.addCase(getStudentBootcampThunk.fulfilled, (state, action) => {
            state.isLoadingBootcamp = false
            state.isErrorBootcamp = false
            state.bootcampData = action.payload.bootcamps
        })
        builder.addCase(getStudentBootcampThunk.rejected, (state) => {
            state.isLoadingBootcamp = false
            state.isErrorBootcamp = true
        })
    }
});

export default studentBootcamp.reducer;
