import { createSlice } from "@reduxjs/toolkit";
import { TCollaboration } from "../../../../interfaces/interfaces";


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