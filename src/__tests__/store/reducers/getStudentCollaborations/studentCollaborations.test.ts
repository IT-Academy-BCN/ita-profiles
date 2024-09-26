import { createSlice } from "@reduxjs/toolkit";
import { TCollaboration } from "../../../../interfaces/interfaces";

// const getStudentCollaborationThunk = createAsyncThunk(
//     "getStudentCollaborationThunk",
//     async (studenSUID: string | null) => {
//         const response = await fetchStudentsCollaboration(studenSUID)
//         return response;
//     })

// const studentCollaborations = createSlice({
//     name: "studentCollaborationsSlice",
//     initialState: {
//         isLoadingCollaborations: false,
//         isErrorCollaborations: false,
//         collaborationsData: <TCollaboration[]>[]
//     },
//     reducers: {},
//     extraReducers: (builder) => {
//         builder.addCase(getStudentCollaborationThunk.pending, (state) => {
//             state.isLoadingCollaborations = true
//             state.isErrorCollaborations = false
//         })
//         builder.addCase(getStudentCollaborationThunk.fulfilled, (state, action) => {
//             state.collaborationsData = action.payload
//             state.isLoadingCollaborations = false
//             state.isErrorCollaborations = false
//         })
//         builder.addCase(getStudentCollaborationThunk.rejected, (state) => {
//             state.isLoadingCollaborations = false
//             state.isErrorCollaborations = true
//         })
//     }
// });

// export default studentCollaborations.reducer;

const studentCollaborations = createSlice({
    name: "studentCollaborationsSlice",
    initialState: {
        isLoadingCollaborations: false,
        isErrorCollaborations: false,
        collaborationsData: <TCollaboration[]>[]
    },
    reducers: {}
})
describe("studentCollaborations", () => {
    it("should be reducer defined", () => {
        expect(studentCollaborations.reducer).toBeDefined();
    })
})