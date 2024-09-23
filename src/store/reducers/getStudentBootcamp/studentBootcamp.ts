/* eslint-disable no-param-reassign */

import { createSlice } from "@reduxjs/toolkit";
import { TBootcamp } from "../../../interfaces/interfaces";
import getStudenBootcamp from "./getStudenBootcampThunk";


const bootcampData: TBootcamp[] = [];




const studentBootcamp = createSlice({
    name: "studentDetailSlice",
    initialState: {
        isLoadindBootcamp: false,
        isErrorBootcamp: false,
        bootcampData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudenBootcamp.pending, (state) => {
            state.isLoadindBootcamp = true
            state.isErrorBootcamp = false
        })
        builder.addCase(getStudenBootcamp.fulfilled, (state, action) => {
            state.bootcampData = action.payload.bootcamps
            state.isLoadindBootcamp = false
            state.isErrorBootcamp = false
        })
        builder.addCase(getStudenBootcamp.rejected, (state) => {
            state.isLoadindBootcamp = false
            state.isErrorBootcamp = true
        })
    }
});

export default studentBootcamp.reducer;
