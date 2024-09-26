import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentsProjects } from "../../../api/FetchStudentsProjects";

const getStudentProjectsThunk = createAsyncThunk(
    "getStudentProjectsThunk",
    async (studenSUID: string | null) => {
        const response = await fetchStudentsProjects(studenSUID)
        return response;
    })

export default getStudentProjectsThunk
