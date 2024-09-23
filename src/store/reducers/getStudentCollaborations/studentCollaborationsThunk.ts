import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentsCollaboration } from "../../../api/FetchStudentCollaboration";

const getStudentCollaborations = createAsyncThunk(
    "getStudentCollaborationThunk",
    async (studenSUID: string | null) => {
        const response = await fetchStudentsCollaboration(studenSUID)
        return response;
    })

export default getStudentCollaborations
