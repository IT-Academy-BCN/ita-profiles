import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchBootcampData } from "../../../api/FetchStudentBootcamp";

/* eslint-disable no-param-reassign */
const getStudentModalityThunk = createAsyncThunk(
    "getStudentModalityThunk",
    async (studenSUID: string | null) => {
        const response = await fetchBootcampData(studenSUID)
        return response;
    })

export default getStudentModalityThunk;