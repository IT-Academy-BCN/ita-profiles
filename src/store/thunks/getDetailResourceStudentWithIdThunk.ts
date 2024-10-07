import { createAsyncThunk } from "@reduxjs/toolkit";
import { getStudentDetailWithId, resumes } from "../../api/student/getStudentDetailWithId";

const getStudentBootcampThunk = createAsyncThunk(
    "getStudentBootcampThunk",
    async (studentId: string | null) => {
        const response = await getStudentDetailWithId(studentId, resumes.bootcamp)
        return response;
    })
const getStudentCollaborationThunk = createAsyncThunk(
    "getStudentCollaborationThunk",
    async (studentId: string | null) => {
        const response = await getStudentDetailWithId(studentId, resumes.collaborations)
        return response;
    })
const getStudentDetailThunk = createAsyncThunk(
    "getStudentDetailThunk",
    async (studentID: string | null) => {
        try {
            const response = await getStudentDetailWithId(studentID, resumes.detail)
            return response;
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    })
const getStudentLanguagesThunk = createAsyncThunk(
    "getStudentLanguagesThunk",
    async (studentID: string | null) => {
        const response = await getStudentDetailWithId(studentID, resumes.languages)
        return response;
    })
const getStudentModalityThunk = createAsyncThunk(
    "getStudentModalityThunk",
    async (studenSUID: string | null) => {
        const response = await getStudentDetailWithId(studenSUID, resumes.modality)
        return response;
    })
const getStudentProjectsThunk = createAsyncThunk(
    "getStudentProjectsThunk",
    async (studenSUID: string | null) => {
        const response = await getStudentDetailWithId(studenSUID, resumes.projects)
        return response;
    })
const getStudentAdditionalTrainingThunk = createAsyncThunk(
    "getStudentAdditionalTrainingThunk",
    async (studentID: string | null) => {
        try {
            const response = await getStudentDetailWithId(studentID, resumes.additionaltraining)
            return response;
        } catch (error) {
            const MyError = error as ErrorEvent
            throw new Error(MyError.message)
        }
    })
export {
    getStudentBootcampThunk,
    getStudentCollaborationThunk,
    getStudentDetailThunk,
    getStudentLanguagesThunk,
    getStudentModalityThunk,
    getStudentProjectsThunk,
    getStudentAdditionalTrainingThunk
}
