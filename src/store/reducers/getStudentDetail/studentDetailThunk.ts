import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentDetail } from "../../../api/FetchStudentDetail";

const getStudentDetail = createAsyncThunk(
    "getStudentDetailThunk",
    async (studentID: string | null) => {
        const response = await fetchStudentDetail(studentID)
        return response[0];
    })

export default getStudentDetail
