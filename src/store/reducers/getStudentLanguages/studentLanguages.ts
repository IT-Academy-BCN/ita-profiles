/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";
import getStudentLanguagesThunk from "./studentLanguagesThunk";
import { TLanguage } from "../../../interfaces/interfaces";

const languagesData: TLanguage[] = []

const studentLanguages = createSlice({
    name: "studentLanguagesSlice",
    initialState: {
        isLoadingLanguages: false,
        isErrorLanguages: false,
        languagesData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentLanguagesThunk.pending, (state) => {
            state.isLoadingLanguages = true
            state.isErrorLanguages = false
        })
        builder.addCase(getStudentLanguagesThunk.fulfilled, (state, action) => {
            state.languagesData = action.payload
            state.isLoadingLanguages = false
            state.isErrorLanguages = false
        })
        builder.addCase(getStudentLanguagesThunk.rejected, (state) => {
            state.isLoadingLanguages = false
            state.isErrorLanguages = true
        })
    }
});

export default studentLanguages.reducer;