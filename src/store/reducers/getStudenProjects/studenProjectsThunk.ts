import { createAsyncThunk } from "@reduxjs/toolkit";
import { FetchStudentsProjects } from "../../../api/FetchStudentsProjects";

const getStudenProjects = createAsyncThunk(
    "getStudenProjectsThunk",
    async (studenSUID: string | null) => {
        const response = await FetchStudentsProjects(studenSUID)
        return response;
    })

export default getStudenProjects