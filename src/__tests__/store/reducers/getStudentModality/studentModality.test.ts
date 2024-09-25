// const bootcampData: TBootcamp[] = [];

import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import { fetchBootcampData } from "../../../../api/FetchStudentBootcamp";

const getStudentModalityThunk = createAsyncThunk(
    "getStudentModalityThunk",
    async (studenSUID: string | null) => {
        const response = await fetchBootcampData(studenSUID)
        return response;
    })

const studentModality = createSlice({
    name: "studentModalitySlice",
    initialState: {
        isLoadingModality: false,
        isErrorModality: false,
        modality: []
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentModalityThunk.pending, (state) => {
            state.isLoadingModality = true
            state.isErrorModality = false
        })
        builder.addCase(getStudentModalityThunk.fulfilled, (state, action) => {
            state.isLoadingModality = false
            state.isErrorModality = false
            state.modality = action.payload.bootcamps
        })
        builder.addCase(getStudentModalityThunk.rejected, (state) => {
            state.isLoadingModality = false
            state.isErrorModality = true
        })
    }
}).reducer;



describe("studentModality", () => {
    it("should be defined", () => {
        expect(studentModality).toBeDefined()
    })

})