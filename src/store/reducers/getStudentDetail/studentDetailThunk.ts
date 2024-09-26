import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentDetail } from "../../../api/FetchStudentDetail";

const getStudentDetailThunk = createAsyncThunk(
    "getStudentDetailThunk",
    async (studentID: string | null) => {
        try {
            const response = await fetchStudentDetail(studentID)
            return response;
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    })

export default getStudentDetailThunk
