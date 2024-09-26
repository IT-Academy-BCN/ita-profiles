import { createAsyncThunk } from "@reduxjs/toolkit";
import { FetchAdditionalTraining } from "../../../api/FetchAdditionalTraining";

const getStudentAdditionalTrainingThunk = createAsyncThunk(
    "getStudentAdditionalTrainingThunk",
    async (studentID: string | null) => {
        try {
            const response = await FetchAdditionalTraining(studentID)

            return response;
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    })

export default getStudentAdditionalTrainingThunk
