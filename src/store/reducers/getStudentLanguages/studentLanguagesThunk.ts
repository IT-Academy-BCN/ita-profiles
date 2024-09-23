import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentLanguages } from "../../../api/FetchStudentLanguages";

const getStudentLanguages = createAsyncThunk(
    "getStudentLanguages",
    async (studentID: string | null) => {
        const response = await fetchStudentLanguages(studentID)
        return response;
    })

export default getStudentLanguages
