import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchModalityData } from "../../../api/FetchStudentModality";

/* eslint-disable no-param-reassign */
const getStudentModalityThunk = createAsyncThunk(
    "getStudentModalityThunk",
    async (studenSUID: string | null) => {
        const response = await fetchModalityData(studenSUID)
        return response;
    })

export default getStudentModalityThunk;