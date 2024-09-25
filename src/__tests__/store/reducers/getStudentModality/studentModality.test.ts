import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import { fetchBootcampData } from "../../../../api/FetchStudentBootcamp";
import { TModality } from "../../../../interfaces/interfaces";

const modality: TModality[] = [];

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
            state.modality = action.payload.modality
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

    it("should be defined getStudentModalityThunk", () => {
        expect(getStudentModalityThunk).toBeDefined()
    })

    it("should be defined const modality type TModality", () => {
        expect(modality).toBeDefined()
    })

    it("should be return initialValues", () => {
        expect(studentModality(undefined, {
            type: "object",
            payload: []
        })).toEqual({
            isLoadingModality: false,
            isErrorModality: false,
            modality: []
        })
    })

    it("It is expected to return values ​​when the request is pending resolution.", () => {
        expect(studentModality(undefined, {
            type: "getStudentModalityThunk/pending",
            payload: []
        })).toEqual({
            isLoadingModality: true,
            isErrorModality: false,
            modality: []
        })
    })

    it("It is expected to return values when the request is fulfilled resolution", () => {
        expect(studentModality(undefined, {
            type: "getStudentModalityThunk/fulfilled",
            payload: {
                "modality": [
                    "Presencial",
                    "Remot"
                ]
            }
        })).toEqual({
            isLoadingModality: false,
            isErrorModality: false,
            modality: [
                "Presencial",
                "Remot"
            ]
        })
    })

    it("It is expected to return values when the request is rejected resolution", () => {
        expect(studentModality(undefined, {
            type: "getStudentModalityThunk/rejected",
            payload: []
        })).toEqual({
            isLoadingModality: false,
            isErrorModality: true,
            modality: []
        })
    })
})