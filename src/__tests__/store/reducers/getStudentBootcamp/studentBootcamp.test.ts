import { createSlice } from "@reduxjs/toolkit";
import { TBootcamp } from "../../../../interfaces/interfaces";
// import { fetchBootcampData } from "../../../../api/FetchStudentBootcamp";

const bootcampData: TBootcamp[] = [];

// const getStudentBootcampThunk = createAsyncThunk(
//     "getStudentBootcampThunk",
//     async (studenSUID: string | null) => {
//         const response = await fetchBootcampData(studenSUID)
//         return response;
//     })

// const studentBootcamp = createSlice({
//     name: "studentBootcampsSlice",
//     initialState: {
//         isLoadingBootcamp: false,
//         isErrorBootcamp: false,
//         bootcampData
//     },
//     reducers: {},
//     extraReducers: (builder) => {
//         builder.addCase(getStudentBootcampThunk.pending, (state) => {
//             state.isLoadingBootcamp = true
//             state.isErrorBootcamp = false
//         })
//         builder.addCase(getStudentBootcampThunk.fulfilled, (state, action) => {
//             state.isLoadingBootcamp = false
//             state.isErrorBootcamp = false
//             state.bootcampData = action.payload.bootcamps
//         })
//         builder.addCase(getStudentBootcampThunk.rejected, (state) => {
//             state.isLoadingBootcamp = false
//             state.isErrorBootcamp = true
//         })
//     }
// });

const studentBootcamp = createSlice({
    name: "studentBootcampsSlice",
    initialState: {
        isLoadingBootcamp: false,
        isErrorBootcamp: false,
        bootcampData
    },
    reducers: {},
})
describe("studentBootcamp", () => {
    it("should reducer return defined", () => {
        expect(studentBootcamp.reducer).toBeDefined();
    })
})