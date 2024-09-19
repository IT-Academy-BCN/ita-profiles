import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentDetail } from "../../../../api/FetchStudentDetail";

const getStudenDetail = createAsyncThunk(
    "getStudenDetailThunk",
    async (studenSUID: string | null) => {
        const response = await fetchStudentDetail(studenSUID)
        return response[0];
    })

export default getStudenDetail