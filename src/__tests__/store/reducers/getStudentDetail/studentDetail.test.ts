import { createSlice } from "@reduxjs/toolkit";
import { TAbout } from "../../../../interfaces/interfaces";

// const getStudentDetailThunk = createAsyncThunk(
//     "getStudentDetailThunk",
//     async (studentID: string | null) => {
//         try {
//             const response = await fetchStudentDetail(studentID)
//             return response;
//         } catch (error) {
//             const MyError = error as ErrorEvent
//             throw new Error(MyError.message)
//         }
//     })

const aboutData: TAbout = {
    id: 0,
    fullname: '',
    resume: {
        subtitle: '',
        social_media: {
            github: {
                url: ''
            },
            linkedin: {
                url: ''
            }
        },
        about: '',
    },
    photo: '',
    tags: []
}

// const studentDetail = createSlice({
//     name: "studentDetailSlice",
//     initialState: {
//         isLoadingAboutData: false,
//         isErrorAboutData: false,
//         aboutData
//     },
//     reducers: {},
//     extraReducers: (builder) => {
//         builder.addCase(getStudentDetailThunk.pending, (state) => {
//             state.isLoadingAboutData = true
//             state.isErrorAboutData = false
//         })
//         builder.addCase(getStudentDetailThunk.fulfilled, (state, action) => {
//             state.aboutData = action.payload
//             state.isLoadingAboutData = false
//             state.isErrorAboutData = false
//         })
//         builder.addCase(getStudentDetailThunk.rejected, (state) => {
//             state.isLoadingAboutData = false
//             state.isErrorAboutData = true
//         })
//     }
// });

const studentDetail = createSlice({
    name: "studentDetailSlice",
    initialState: {
        isLoadingAboutData: false,
        isErrorAboutData: false,
        aboutData
    },
    reducers: {}
})
describe("studentDetail", () => {
    it("should reducer return defined", () => {
        expect(studentDetail.reducer).toBeDefined();
    })
})