import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchStudentsProjects } from "../../../api/FetchStudentsProjects";

const getStudentProjects = createAsyncThunk(
    "getStudentProjectsThunk",
    async (studenSUID: string | null) => {
        const response = await fetchStudentsProjects(studenSUID)
        return response;
    })

export default getStudentProjects
