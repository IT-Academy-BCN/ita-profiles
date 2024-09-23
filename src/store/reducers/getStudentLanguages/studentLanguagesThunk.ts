import { createAsyncThunk } from "@reduxjs/toolkit";
import { FetchStudentLanguages } from "../../../api/FetchStudentLanguages";

const getStudentLanguages = createAsyncThunk(
    "getStudentLanguages",
    async (studentID: string | null) => {
        const response = await FetchStudentLanguages(studentID)
        return response;
    })

export default getStudentLanguages