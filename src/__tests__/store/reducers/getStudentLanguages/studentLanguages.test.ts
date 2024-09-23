import { createSlice } from "@reduxjs/toolkit";
import { TLanguage } from "../../../../interfaces/interfaces";
// import getStudentLanguagesThunk from "./studentLanguagesThunk";


const languagesData: TLanguage[] = []

// const studentLanguages = createSlice({
//     name: "studentLanguagesSlice",
//     initialState: {
//         isLoadingLanguages: false,
//         isErrorLanguages: false,
//         languagesData
//     },
//     reducers: {},
//     extraReducers: (builder) => {
//         builder.addCase(getStudentLanguagesThunk.pending, (state) => {
//             state.isLoadingLanguages = true
//             state.isErrorLanguages = false
//         })
//         builder.addCase(getStudentLanguagesThunk.fulfilled, (state, action) => {
//             state.languagesData = action.payload
//             state.isLoadingLanguages = false
//             state.isErrorLanguages = false
//         })
//         builder.addCase(getStudentLanguagesThunk.rejected, (state) => {
//             state.isLoadingLanguages = false
//             state.isErrorLanguages = true
//         })
//     }
// });
const studentLanguages = createSlice({
    name: "studentLanguagesSlice",
    initialState: {
        isLoadingLanguages: false,
        isErrorLanguages: false,
        languagesData
    },
    reducers: {}
})

describe("StudentLanguagesTest reducer", () => {
    it("should be defined", () => {
        expect(studentLanguages).toBeDefined();
    })
})