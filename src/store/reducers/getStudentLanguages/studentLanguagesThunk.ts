import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentLanguages } from "../../../api/FetchStudentLanguages";

const getStudentLanguagesThunk = createAsyncThunk(
    "getStudentLanguagesThunk",
    async (studentID: string | null) => {
        const response = await fetchStudentLanguages(studentID)
        return response;
    })

export default getStudentLanguagesThunk
