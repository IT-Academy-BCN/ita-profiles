import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchBootcampData } from "../../../api/FetchStudentBootcamp";

const getStudentBootcamp = createAsyncThunk(
    "getStudentBootcampThunk",
    async (studenSUID: string | null) => {
        const response = await fetchBootcampData(studenSUID)
        return response;
    })

export default getStudentBootcamp
