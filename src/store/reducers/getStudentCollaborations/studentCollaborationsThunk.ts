import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentsCollaboration } from "../../../api/FetchStudentCollaboration";

const getStudentCollaborationThunk = createAsyncThunk(
    "getStudentCollaborationThunk",
    async (studenSUID: string | null) => {
        const response = await fetchStudentsCollaboration(studenSUID)
        return response;
    })

export default getStudentCollaborationThunk
