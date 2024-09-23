import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchBootcampData } from "../../../api/FetchStudentBootcamp";

const getStudenBootcamp = createAsyncThunk(
    "getStudenBootcampThunk",
    async (studenSUID: string | null) => {
        const response = await fetchBootcampData(studenSUID)
        return response;
    })

export default getStudenBootcamp