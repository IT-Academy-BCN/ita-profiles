import { createAsyncThunk } from "@reduxjs/toolkit";
import { FetchStudentsCollaboration } from "../../../api/FetchStudentCollaboration";

const getStudentCollaborations = createAsyncThunk(
    "getStudentCollaborationThunk",
    async (studenSUID: string | null) => {
        const response = await FetchStudentsCollaboration(studenSUID)
        return response;
    })

export default getStudentCollaborations