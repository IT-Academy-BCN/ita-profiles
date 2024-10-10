import { createSlice } from "@reduxjs/toolkit";
import { TBootcamp } from "../../../../interfaces/interfaces";

const bootcampData: TBootcamp[] = [];


const studentBootcamp = createSlice({
    name: "studentBootcampSlice",
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