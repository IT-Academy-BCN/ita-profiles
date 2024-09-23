import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentDetail } from "../../../api/FetchStudentDetail";

const getStudenDetail = createAsyncThunk(
    "getStudenDetailThunk",
    async (studentID: string | null) => {
        const response = await fetchStudentDetail(studentID)
        return response[0];
    })

export default getStudenDetail